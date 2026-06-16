<?php
declare(strict_types=1);

/**
 * Single endpoint for the contact form (POST from contact.php via fetch).
 * PHPMailer lives in /phpmailer/ — do not add a second save.php there.
 */
set_time_limit(0);

header('Content-Type: text/plain; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'method_not_allowed';
    exit;
}

include __DIR__ . '/database.php';

/** @var array<string, mixed> $appConfig */
$appConfig = require __DIR__ . '/includes/config.php';

date_default_timezone_set('Asia/Kolkata');
$timestamp = date('Y-m-d H:i:s');

/**
 * @return never
 */
function save_fail(string $code): void
{
    echo $code;
    exit;
}

function getClientIP(): string
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return (string) $_SERVER['HTTP_CLIENT_IP'];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $parts = explode(',', (string) $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($parts[0]);
    }
    return (string) ($_SERVER['REMOTE_ADDR'] ?? '');
}

/* ---------- Form fields (contact page) ---------- */

$name = trim((string) ($_POST['name'] ?? ''));
$designation = trim((string) ($_POST['designation'] ?? ''));
$company = trim((string) ($_POST['company'] ?? ''));
$country = trim((string) ($_POST['country'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$mobile = trim((string) ($_POST['your_phone'] ?? $_POST['mobile'] ?? ''));
$product = trim((string) ($_POST['product'] ?? ''));
$quantity = trim((string) ($_POST['quantity'] ?? ''));
$remarks = trim((string) ($_POST['remarks'] ?? ''));

$utm_source = trim((string) ($_POST['utm_source'] ?? ''));
$utm_campaign = trim((string) ($_POST['utm_campaign'] ?? ''));
$utm_medium = trim((string) ($_POST['utm_medium'] ?? ''));
$utm_term = trim((string) ($_POST['utm_term'] ?? ''));

/* ---------- Validation ---------- */

if ($name === '' || mb_strlen($name) > 255) {
    save_fail('validation_error');
}
if ($designation === '' || mb_strlen($designation) > 255) {
    save_fail('validation_error');
}
if ($company === '' || mb_strlen($company) > 255) {
    save_fail('validation_error');
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 255) {
    save_fail('validation_error');
}
if ($product === '' || mb_strlen($product) > 255) {
    save_fail('validation_error');
}
if ($quantity === '' || mb_strlen($quantity) > 128) {
    save_fail('validation_error');
}
if ($country !== '' && mb_strlen($country) > 100) {
    save_fail('validation_error');
}
if ($mobile === '' || !preg_match('/^\d{10}$/', $mobile)) {
    save_fail('validation_error');
}
if (mb_strlen($remarks) > 10000) {
    save_fail('validation_error');
}

/* ---------- Client / geo ---------- */

$ip_address = getClientIP();
$c_browser = (string) ($_SERVER['HTTP_USER_AGENT'] ?? '');
if (mb_strlen($c_browser) > 512) {
    $c_browser = mb_substr($c_browser, 0, 512);
}

$c_city = '';
$c_state = '';
$c_country = '';
if ($ip_address !== '') {
    $geoUrl = 'http://ip-api.com/json/' . rawurlencode($ip_address) . '?fields=status,city,regionName,country';
    $geoRaw = @file_get_contents($geoUrl);
    $geo = is_string($geoRaw) ? json_decode($geoRaw, true) : null;
    if (is_array($geo) && ($geo['status'] ?? '') === 'success') {
        $c_city = trim((string) ($geo['city'] ?? ''));
        $c_state = trim((string) ($geo['regionName'] ?? ''));
        $c_country = trim((string) ($geo['country'] ?? ''));
    }
}

/* Use strings for mysqli bind_param (avoids null/reference issues on some PHP builds). */
$countryDb = $country === '' ? '' : $country;
$mobileDb = $mobile === '' ? '' : $mobile;
$remarksDb = $remarks === '' ? '' : $remarks;

/* ---------- DB insert (extended columns, or fallback if migration not run) ---------- */

$sqlExtended = 'INSERT INTO contact_submissions (
    name, designation, company, country, email, mobile, product, quantity, remarks,
    ip_address, user_agent, geo_city, geo_state, geo_country,
    utm_source, utm_campaign, utm_medium, utm_term,
    created_at
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

$sqlBasic = 'INSERT INTO contact_submissions (
    name, designation, company, country, email, mobile, product, quantity, remarks
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';

$stmt = null;
$dbOk = false;

try {
    $stmt = $conn->prepare($sqlExtended);
    if ($stmt === false) {
        throw new RuntimeException($conn->error);
    }
    $stmt->bind_param(
        str_repeat('s', 19),
        $name,
        $designation,
        $company,
        $countryDb,
        $email,
        $mobileDb,
        $product,
        $quantity,
        $remarksDb,
        $ip_address,
        $c_browser,
        $c_city,
        $c_state,
        $c_country,
        $utm_source,
        $utm_campaign,
        $utm_medium,
        $utm_term,
        $timestamp
    );
    if (!$stmt->execute()) {
        throw new RuntimeException($stmt->error);
    }
    $dbOk = true;
} catch (Throwable $e) {
    error_log('save.php extended insert: ' . $e->getMessage());
    if ($stmt instanceof mysqli_stmt) {
        $stmt->close();
        $stmt = null;
    }
    try {
        $stmt = $conn->prepare($sqlBasic);
        if ($stmt === false) {
            throw new RuntimeException($conn->error);
        }
        $stmt->bind_param(
            str_repeat('s', 9),
            $name,
            $designation,
            $company,
            $countryDb,
            $email,
            $mobileDb,
            $product,
            $quantity,
            $remarksDb
        );
        if (!$stmt->execute()) {
            throw new RuntimeException($stmt->error);
        }
        $dbOk = true;
    } catch (Throwable $e2) {
        error_log('save.php basic insert: ' . $e2->getMessage());
    }
}

if ($stmt instanceof mysqli_stmt) {
    $stmt->close();
}
if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}

if (!$dbOk) {
    save_fail('db_error');
}

/* ---------- PHPMailer (same style as landing save: $message1 + foreach recipients) ---------- */

$mailCfg = $appConfig['mail'] ?? [];
if (is_array($mailCfg) && !empty($mailCfg['enabled'])) {

    require_once dirname(__FILE__) . '/phpmailer/class.phpmailer.php';
    require_once dirname(__FILE__) . '/phpmailer/class.smtp.php';

    $smtpHost = trim((string) ($mailCfg['smtp_host'] ?? ''));
    $smtpFrom = trim((string) ($mailCfg['from_email'] ?? ''));
    $smtpUser = trim((string) ($mailCfg['smtp_user'] ?? ''));
    $smtpAuth = !empty($mailCfg['smtp_auth']);
    $smtpPass = trim((string) ($mailCfg['smtp_pass'] ?? ''));

    if ($smtpFrom === '' && $smtpUser !== '' && filter_var($smtpUser, FILTER_VALIDATE_EMAIL)) {
        $smtpFrom = $smtpUser;
    }

    $recipientsRaw = $mailCfg['alert_recipients'] ?? '';
    if (is_array($recipientsRaw)) {
        $recipientsRaw = implode(',', $recipientsRaw);
    }
    $recipients = array_map('trim', explode(',', (string) $recipientsRaw));
    $recipients = array_values(array_filter($recipients, static function (string $a): bool {
        return $a !== '';
    }));

    $he = static function (string $s): string {
        return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    };

    $message1 = 'Hi,<br/><br/>';
    $message1 .= 'You have received a new enquiry from the SRI VASAVI website contact page. Details are below:<br/><br/>';
    $message1 .= 'Name : ' . $he($name) . '<br/>';
    $message1 .= 'Designation : ' . $he($designation) . '<br/>';
    $message1 .= 'Company : ' . $he($company) . '<br/>';
    $message1 .= 'Country : ' . $he($country !== '' ? $country : '—') . '<br/>';
    $message1 .= 'Email : ' . $he($email) . '<br/>';
    $message1 .= 'Phone : ' . $he($mobile) . '<br/>';
    $message1 .= 'Product : ' . $he($product) . '<br/>';
    $message1 .= 'Quantity : ' . $he($quantity) . '<br/>';
    $message1 .= 'Remarks : ' . nl2br($he($remarks !== '' ? $remarks : '—')) . '<br/>';
    $message1 .= 'UTM Source : ' . $he($utm_source) . '<br/>';
    $message1 .= 'UTM Campaign : ' . $he($utm_campaign) . '<br/>';
    $message1 .= 'UTM Medium : ' . $he($utm_medium) . '<br/>';
    $message1 .= 'UTM Term : ' . $he($utm_term) . '<br/>';
    $message1 .= 'IP Address : ' . $he($ip_address) . '<br/>';
    $message1 .= 'City : ' . $he($c_city) . '<br/>';
    $message1 .= 'State : ' . $he($c_state) . '<br/>';
    $message1 .= 'Country (geo) : ' . $he($c_country) . '<br/>';
    $message1 .= 'Submitted At : ' . $he($timestamp) . '<br/>';

    $smtpReady = $smtpHost !== ''
        && $smtpFrom !== ''
        && filter_var($smtpFrom, FILTER_VALIDATE_EMAIL)
        && (!$smtpAuth || ($smtpPass !== '' && $smtpUser !== ''));

    if (!$smtpReady) {
        error_log('Contact mail skipped: set mail.smtp_host, smtp_user, smtp_pass, from_email in includes/config.php');
    } elseif ($recipients === []) {
        error_log('Contact mail skipped: mail.alert_recipients empty or invalid.');
    } else {
        $mail = new PHPMailer();

        try {
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host = $smtpHost;
            $mail->SMTPAuth = $smtpAuth;
            if ($smtpAuth) {
                $mail->Username = $smtpUser;
                $mail->Password = $smtpPass;
            }
            $secure = $mailCfg['smtp_secure'] ?? 'tls';
            if ($secure !== '' && $secure !== null) {
                $mail->SMTPSecure = (string) $secure;
            }
            $mail->Port = (int) ($mailCfg['smtp_port'] ?? 587);
            $mail->SMTPDebug = 0;
            $mail->Timeout = 45;

            $opts = $mailCfg['smtp_options'] ?? null;
            if (is_array($opts) && $opts !== []) {
                $mail->SMTPOptions = $opts;
            }

            $fromName = trim((string) ($mailCfg['from_name'] ?? 'SRI VASAVI Website'));
            $mail->setFrom($smtpFrom, $fromName);

            $addrCount = 0;
            foreach ($recipients as $rcpt) {
                if (filter_var($rcpt, FILTER_VALIDATE_EMAIL)) {
                    $mail->addAddress($rcpt);
                    $addrCount++;
                }
            }

            if ($addrCount === 0) {
                error_log('Contact mail: no valid email addresses after filter_var.');
            } else {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $mail->addReplyTo($email, $name);
                }

                $mail->isHTML(true);
                $mail->Subject = 'New Customer Enquiry via Website';
                $mail->Body = $message1;
                $mail->AltBody = strip_tags(str_replace(['<br/>', '<br>', '<br />'], "\n", $message1));

                if (!$mail->send()) {
                    error_log('Mail Error: ' . $mail->ErrorInfo);
                }
            }
        } catch (Throwable $e) {
            $info = isset($mail) && $mail instanceof PHPMailer ? $mail->ErrorInfo : '';
            error_log('Mail Error: ' . ($info !== '' ? $info . ' | ' : '') . $e->getMessage());
        }
    }
}

echo 'success';
exit;

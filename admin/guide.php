<?php
declare(strict_types=1);

require __DIR__ . '/auth.php';

$adminPageTitle = 'Guide';
$adminNavActive = 'guide';

require __DIR__ . '/../includes/admin/shell-start.php';
?>

<div class="admin-inner admin-inner--narrow">
    <section class="admin-prose-grid">
        <article class="admin-prose-card">
            <div class="admin-prose-card-head">
                <span class="admin-prose-ico" aria-hidden="true"><i class="fa-solid fa-inbox"></i></span>
                <h2 class="admin-prose-title">Reading enquiries</h2>
            </div>
            <p class="admin-prose-text">
                The <strong>Dashboard</strong> shows counts and the five most recent messages. Open <strong>All leads</strong> for the full table.
                Use the email links to reply directly from your mail app.
            </p>
        </article>

        <article class="admin-prose-card">
            <div class="admin-prose-card-head">
                <span class="admin-prose-ico" aria-hidden="true"><i class="fa-solid fa-shield-halved"></i></span>
                <h2 class="admin-prose-title">Security</h2>
            </div>
            <p class="admin-prose-text">
                Change the default admin password in <code class="admin-code">includes/config.php</code> by generating a new hash with PHP’s
                <code class="admin-code">password_hash()</code>. Do not share admin URLs or credentials publicly.
            </p>
        </article>

        <article class="admin-prose-card">
            <div class="admin-prose-card-head">
                <span class="admin-prose-ico" aria-hidden="true"><i class="fa-solid fa-database"></i></span>
                <h2 class="admin-prose-title">Database</h2>
            </div>
            <p class="admin-prose-text">
                Submissions are stored in MySQL table <code class="admin-code">contact_submissions</code>. If the dashboard shows a connection error,
                import <code class="admin-code">sql/schema.sql</code> in phpMyAdmin and verify credentials in config.
            </p>
        </article>

        <article class="admin-prose-card">
            <div class="admin-prose-card-head">
                <span class="admin-prose-ico" aria-hidden="true"><i class="fa-solid fa-envelope"></i></span>
                <h2 class="admin-prose-title">Contact form</h2>
            </div>
            <p class="admin-prose-text">
                The form on <a class="admin-inline-link" href="../contact.php">contact.php</a> posts to <code class="admin-code">save.php</code> (AJAX).
                A thank-you popup appears on success; rows are stored in <code class="admin-code">contact_submissions</code>. Email alerts use PHPMailer;
                enable them in <code class="admin-code">includes/config.php</code> under <code class="admin-code">mail</code>. If <code class="admin-code">save.php</code> errors on insert, run
                <code class="admin-code">sql/alter_contact_submissions_tracking.sql</code> once for older databases.
            </p>
        </article>
    </section>
</div>

<?php require __DIR__ . '/../includes/admin/shell-end.php'; ?>

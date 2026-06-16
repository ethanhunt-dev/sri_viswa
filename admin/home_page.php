<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../includes/db.php';

$dbPrivs = get_menu_privileges(__FILE__);
if (!$dbPrivs['view']) {
    header("Location: home");
    exit;
}
require_once __DIR__ . '/core/models/CrudModel.php';

// Force redirect to the single settings edit page (ID 1) if not already there
if (!isset($_GET['edit']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $msgParam = isset($_GET['msg']) ? '&msg=' . urlencode($_GET['msg']) : '';
    header("Location: ?edit=1" . $msgParam);
    exit;
}

// === 1. Configuration (The Controller Setup) ===
$tableName = 'home_page';
$adminPageTitle = 'Manage Home Page';
$adminNavActive = 'home_page';
$privs = [
    'add'    => false,
    'update' => $dbPrivs['update'],
    'delete' => false
];

// Define file upload fields
$images = [
    'hero_image',
    'legacy_image',
    'pillar1_icon',
    'pillar2_icon',
    'pillar3_icon',
    'about_image'
];
$documents = [];

// Exclude text inputs and images from CKEditor to keep forms clean
$excludeCkEditor = [
    'hero_kicker',
    'hero_button_text',
    'stat1_value',
    'stat1_label',
    'stat1_sub',
    'stat2_value',
    'stat2_label',
    'stat2_sub',
    'stat3_value',
    'stat3_label',
    'stat3_sub',
    'legacy_title',
    'pillar1_title',
    'pillar2_title',
    'pillar3_title',
    'about_title',
    'hero_image',
    'legacy_image',
    'pillar1_icon',
    'pillar2_icon',
    'pillar3_icon',
    'about_image',
    'industries_title'
];

// Human-friendly labels for fields
$displayNames = [
    'hero_kicker' => 'Hero Subheading / Kicker (e.g. PLASTIMIX)',
    'hero_sub' => 'Hero Main Text / Tagline',
    'hero_button_text' => 'Hero Button Text',
    'hero_image' => 'Hero Banner Background Image',
    
    'stat1_value' => 'Stat 1: Number/Value (e.g. 28)',
    'stat1_label' => 'Stat 1: Label (e.g. Years)',
    'stat1_sub' => 'Stat 1: Sub-label (e.g. in Business)',
    
    'stat2_value' => 'Stat 2: Number/Value (e.g. 2,500)',
    'stat2_label' => 'Stat 2: Label (e.g. Colors)',
    'stat2_sub' => 'Stat 2: Sub-label (e.g. Created)',
    
    'stat3_value' => 'Stat 3: Number/Value (e.g. 800)',
    'stat3_label' => 'Stat 3: Label (e.g. Customers)',
    'stat3_sub' => 'Stat 3: Sub-label (e.g. Served)',
    
    'legacy_title' => 'Legacy Section Title',
    'legacy_text' => 'Legacy Section Content',
    'legacy_image' => 'Legacy Section Image',
    
    'pillar1_title' => 'Pillar 1 Title',
    'pillar1_icon' => 'Pillar 1 Icon (PNG/SVG)',
    'pillar2_title' => 'Pillar 2 Title',
    'pillar2_icon' => 'Pillar 2 Icon (PNG/SVG)',
    'pillar3_title' => 'Pillar 3 Title',
    'pillar3_icon' => 'Pillar 3 Icon (PNG/SVG)',
    
    'about_title' => 'About Section Title',
    'about_text' => 'About Section Content',
    'about_image' => 'About Section Image',
    
    'industries_title' => 'Industries Section Title',
    'industries_text' => 'Industries Section Description'
];

$relations = [];
$multipleChoiceFields = [];
$hideInList = [
    'hero_kicker', 'hero_sub', 'hero_button_text', 'hero_image',
    'stat1_value', 'stat1_label', 'stat1_sub',
    'stat2_value', 'stat2_label', 'stat2_sub',
    'stat3_value', 'stat3_label', 'stat3_sub',
    'legacy_title', 'legacy_text', 'legacy_image',
    'pillar1_title', 'pillar1_icon',
    'pillar2_title', 'pillar2_icon',
    'pillar3_title', 'pillar3_icon',
    'about_title', 'about_text', 'about_image',
    'industries_title', 'industries_text',
    'created_at', 'updated_at'
];
$hideInAdd = [];
$hideInEdit = [];

$pdo = db();
$model = new CrudModel($pdo, $tableName);
$message = '';
$isError = false;

// === 2. Handle POST Actions (The Controller Logic) ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    
    // Generic File Upload Logic
    if ($action === 'add' || $action === 'edit') {
        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $allFiles = array_merge($images ?? [], $documents ?? []);
        foreach ($allFiles as $fileField) {
            if (isset($_FILES[$fileField]) && $_FILES[$fileField]['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES[$fileField]['tmp_name'];
                $safeName = preg_replace('/[^a-zA-Z0-9.\-_]/', '', basename($_FILES[$fileField]['name']));
                $fileName = time() . '_' . $safeName;
                $targetPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($tmpName, $targetPath)) {
                    $_POST[$fileField] = 'uploads/' . $fileName;
                }
            }
        }
    }
    
    if ($action === 'edit' && !empty($privs['update']) && isset($_POST['id'])) {
        try {
            $model->update((int)$_POST['id'], $_POST);
            header("Location: ?msg=updated");
            exit;
        } catch (Exception $e) {
            $message = "Error updating: " . $e->getMessage();
            $isError = true;
        }
    }
}

if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'updated') {
        $message = "Home Page settings updated successfully!";
    }
}

// === 3. Fetch Data for Views ===
$schema = [];
try {
    $schema = $model->getSchema();
} catch (PDOException $e) {
    $message = "Database table '{$tableName}' does not exist. Please run migration first.";
    $isError = true;
}

$hasId = false;
foreach ($schema as $c) {
    if ($c['Field'] === 'id') $hasId = true;
}

$editData = null;
if (isset($_GET['edit']) && !empty($privs['update']) && $hasId) {
    $editData = $model->getById((int)$_GET['edit']);
}

// Pagination setup (required by views/layout.php even if not used in edit-only mode)
$limit = 10;
$page = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
$filter = [];
$totalRecords = $model->countAll($filter);
$totalPages = (int)ceil($totalRecords / $limit);
$rows = [];
if ($schema) {
    $rows = $model->getPaginated($page, $limit, $filter);
}

$actionUrl = '?';
$addMode = '';

require __DIR__ . '/core/views/layout.php';

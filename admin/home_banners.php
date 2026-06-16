<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/core/models/CrudModel.php';

// === 1. Configuration (The Controller Setup) ===
$tableName = 'homepage_banners';
$adminPageTitle = 'Manage Hero Banners';
$adminNavActive = 'home_banners';
$privs = get_menu_privileges(__FILE__);
if (!$privs['view']) {
    header("Location: home");
    exit;
}

// Define file upload fields
$images = ['image']; // Banner images
$documents = [];

// Exclude single line parameters from CKEditor
$excludeCkEditor = ['kicker', 'button_text', 'button_url', 'image', 'sort_order'];

// Human-friendly field display labels
$displayNames = [
    'kicker' => 'Banner Kicker (e.g. PLASTIMIX)',
    'title' => 'Tagline / Banner Title (CKEditor support)',
    'button_text' => 'Button Text',
    'button_url' => 'Button Destination Link',
    'image' => 'Banner Image',
    'sort_order' => 'Sort Order'
];

$relations = [];
$multipleChoiceFields = [];
$hideInList = ['created_at', 'updated_at'];
$hideInAdd = [];
$hideInEdit = [];

$fieldHelpText = [
    'image' => 'Recommended size: 1920x550 pixels (or similar landscape proportions).',
    'button_url' => 'Use relative path like "contact.php" or absolute URL.'
];

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
    
    if ($action === 'delete' && !empty($privs['delete']) && isset($_POST['id'])) {
        try {
            $model->delete((int)$_POST['id']);
            header("Location: ?msg=deleted");
            exit;
        } catch (Exception $e) {
            $message = "Error deleting: " . $e->getMessage();
            $isError = true;
        }
    } 
    elseif ($action === 'add' && !empty($privs['add'])) {
        try {
            $model->insert($_POST);
            header("Location: ?msg=added");
            exit;
        } catch (Exception $e) {
            $message = "Error adding: " . $e->getMessage();
            $isError = true;
        }
    }
    elseif ($action === 'edit' && !empty($privs['update']) && isset($_POST['id'])) {
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
    if ($_GET['msg'] === 'deleted') $message = "Banner deleted successfully!";
    if ($_GET['msg'] === 'added') $message = "Banner added successfully!";
    if ($_GET['msg'] === 'updated') $message = "Banner updated successfully!";
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

// Pagination setup
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

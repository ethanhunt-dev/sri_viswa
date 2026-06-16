<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/core/models/CrudModel.php';

// === 1. Configuration (The Controller Setup) ===
$tableName = 'products';
$adminPageTitle = 'Manage Products';
$adminNavActive = 'products';
$privs = [
    'add'    => true,
    'update' => true,
    'delete' => true
];

// Define file upload fields
$images = ['image', 'app1_image', 'app2_image', 'app3_image', 'app4_image']; // Product and Application images
$documents = ['datasheet_pdf']; // PDF datasheets

// Exclude text fields from CKEditor if needed
$excludeCkEditor = ['product_name', 'app1_text', 'app2_text', 'app3_text', 'app4_text'];

// Advanced Form Controls
$displayNames = [
    'product_name' => 'Product Name',
    'image' => 'Product Image',
    'description' => 'Description (Intro)',
    'app1_title' => 'Application 1 Title',
    'app1_image' => 'Application 1 Image/Icon',
    'app1_text' => 'Application 1 Description',
    'app2_title' => 'Application 2 Title',
    'app2_image' => 'Application 2 Image/Icon',
    'app2_text' => 'Application 2 Description',
    'app3_title' => 'Application 3 Title',
    'app3_image' => 'Application 3 Image/Icon',
    'app3_text' => 'Application 3 Description',
    'app4_title' => 'Application 4 Title',
    'app4_image' => 'Application 4 Image/Icon',
    'app4_text' => 'Application 4 Description',
];
$relations = [];
$multipleChoiceFields = [];
$hideInList = [
    'slug',
    'app1_title', 'app1_image', 'app1_text',
    'app2_title', 'app2_image', 'app2_text',
    'app3_title', 'app3_image', 'app3_text',
    'app4_title', 'app4_image', 'app4_text',
    'created_at', 'updated_at'
];
$hideInAdd = ['slug'];
$hideInEdit = ['slug'];

// Auto-generate slugs: [target_column => source_column]
$slugFields = [
    'slug' => 'product_name'
];

$pdo = db();
$model = new CrudModel($pdo, $tableName);
$message = '';
$isError = false;

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
                // Sanitize filename
                $safeName = preg_replace('/[^a-zA-Z0-9.\-_]/', '', basename($_FILES[$fileField]['name']));
                $fileName = time() . '_' . $safeName;
                $targetPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($tmpName, $targetPath)) {
                    // Save the path to $_POST so CrudModel handles it
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
    if ($_GET['msg'] === 'deleted') $message = "Record deleted successfully!";
    if ($_GET['msg'] === 'added') $message = "Record added successfully!";
    if ($_GET['msg'] === 'updated') $message = "Record updated successfully!";
}

// === 3. Fetch Data for Views ===
$schema = [];
try {
    $schema = $model->getSchema();
} catch (PDOException $e) {
    $message = "Database table '{$tableName}' does not exist. Please create it first.";
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

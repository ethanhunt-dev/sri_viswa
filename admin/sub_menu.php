<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/core/models/CrudModel.php';

// === 1. Configuration (The Controller Setup) ===
$tableName = 'sub_menu';
$adminPageTitle = 'Manage Sub Menus';
$adminNavActive = 'sub_menu';
$privs = get_menu_privileges(__FILE__);
if (!$privs['view']) {
    header("Location: home");
    exit;
}

$excludeCkEditor = ['title', 'file_path', 'icon']; // Exclude these varchar fields from CKEditor

// Advanced Form Controls
$displayNames = [
    'main_menu_id' => 'Main Menu'
];
$relations = [
    'main_menu_id' => ['table' => 'main_menu', 'value_col' => 'id', 'display_col' => 'title']
];
$multipleChoiceFields = []; // e.g., ['tags']
$hideInList = [];
$hideInAdd = [];
$hideInEdit = [];

$pdo = db();
$model = new CrudModel($pdo, $tableName);
$message = '';
$isError = false;

// === 2. Handle POST Actions (The Controller Logic) ===
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['file_path']) && $_POST['file_path'] === '') {
        $_POST['file_path'] = null;
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    
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
            // Require main_menu_id to not be empty for sub menus
            if (empty($_POST['main_menu_id'])) {
                throw new Exception("Please select a parent menu.");
            }
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
            if (empty($_POST['main_menu_id'])) {
                throw new Exception("Please select a parent menu.");
            }
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

// Fetch main menus for parent dropdown selection
$parentMenus = [];
try {
    $parentMenus = $pdo->query("SELECT id, title FROM main_menu ORDER BY sort_order ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);
} catch (Throwable $t) {
    // Ignore if table doesn't exist
}

// Set explicit CKEditor fields (none for menus)
$richTextFields = [];

$editData = null;
if (isset($_GET['edit']) && !empty($privs['update']) && $hasId) {
    $editData = $model->getById((int)$_GET['edit']);
}

// Pagination setup
$limit = 5;
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

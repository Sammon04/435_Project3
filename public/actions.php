<?php

require_once '../src/storage.php';
require_once '../src/flash.php';
require_once '../src/csrf.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!csrfValidate()){
        die("Security error, invalid csrf token. Cannot process request!");
    }

    $id = $_POST['id'] ?? '';
    $action = $_POST['action'] ?? '';

    if ($action === 'complete') {
        completeTask($id);
        setFlash("Task was completed successfully!");
    }

    if ($action === 'delete') {
        deleteTask($id);
        setFlash("Task was deleted successfully!");
    }

    header("Location: index.php");
    exit;

}
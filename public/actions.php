<?php

require_once '../src/storage.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $id = $_POST['id'] ?? '';
        $action = $_POST['action'] ?? '';

        if ($action === 'complete') {
            completeTask($id);
        }

        if ($action === 'delete') {
            deleteTask($id);
        }

        header("Location: index.php");
        exit;
    } else {
        die("Security alert: Invalid CSRF token. Unable to process request.");
    }

}
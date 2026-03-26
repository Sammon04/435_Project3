<?php
require_once '../src/storage.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $priority = $_POST['priority'] ?? '';
    $due = $_POST['due'] ?? '';

    $tasks = loadTasks();

    $tasks[] = [
        'id' => uniqid(),
        'title' => $title,
        'description' => $description,
        'priority' => $priority,
        'due' => $due
    ];

    writeTasks($tasks);

    header("Location: index.php");
    exit;
}
?>

<h1>Create Task</h1>

<form method="POST" action="create.php">
    <input name="title" placeholder="Task Title">
    <br><input name="description" placeholder="Task Description">
    <br><input name="priority" placeholder="Task Priority">
    <br><input name="due" placeholder="Task Due Date">
    <br><button type="submit">Add Task</button>
</form>
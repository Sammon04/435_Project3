<?php
require_once '../src/storage.php';
require_once '../src/validation.php';
require_once '../src/flash.php';

session_start();

$errors = [];
$input = [
    'title' => '',
    'description' => '',
    'priority' => '',
    'due' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $input = [
        'title' => $_POST['title'] ?? '',
        'description' => $_POST['description'] ?? '',
        'priority' => $_POST['priority'] ?? '',
        'due' => $_POST['due'] ?? ''
    ];

    $errors = validateForm($_POST);

    if (empty($errors)) {

        $tasks = loadTasks();

        $tasks[] = [
            'id' => uniqid(),
            'title' => trim($input['title']),
            'description' => trim($input['description']),
            'priority' => $input['priority'],
            'due' => $input['due'] ?: null,
            'complete' => false
        ];

        writeTasks($tasks);

        setFlash("Task created successfully!");
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/styles.css">
    <title>TaskPad</title>
</head>
<body>

    <header class="page-header">
        <h1 class="page-title">Create Task</h1>
    </header>

    <nav class="page-nav">
        <a href="index.php">Home</a>
        <a href="create.php">Create Task</a>
    </nav>

    <main class="content">
        <form class="task-form" method="POST" action="create.php">
            <input name="title" value="<?= htmlspecialchars($input['title']) ?>" placeholder="Task Title">
            <?php if (isset($errors['title'])) : ?>
                <p><?= htmlspecialchars($errors['title']) ?></p>
            <?php endif; ?>

            <br><textarea name="description" placeholder="Task Description"><?= htmlspecialchars($input['description']) ?></textarea>
            <?php if (isset($errors['description'])) : ?>
                <p><?= htmlspecialchars($errors['description']) ?></p>
            <?php endif; ?>

            <br>
            <select name="priority">
                <option value="" <?= $input['priority'] === '' ? 'selected' : '' ?>>Priority</option>
                <option value="Low" <?= $input['priority'] === 'Low' ? 'selected' : '' ?>>Low</option>
                <option value="Medium" <?= $input['priority'] === 'Medium' ? 'selected' : '' ?>>Medium</option>
                <option value="High" <?= $input['priority'] === 'High' ? 'selected' : '' ?>>High</option>
            </select>

            <br><input name="due" placeholder="Task Due Date" value="<?= $input['due'] ?>">
            <?php if (isset($errors['due'])) : ?>
                <p><?= htmlspecialchars($errors['due']) ?></p>
            <?php endif; ?>

            <br><button type="submit">Add Task</button>
        </form>
    </main>
</body>
</html>


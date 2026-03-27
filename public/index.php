<?php
require_once '../src/storage.php';

session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrf_token = $_SESSION['csrf_token'];

$tasks = loadTasks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskPad</title>
</head>
<body>

    <nav>
        <a href="index.php">Home</a> |
        <a href="create.php">Create Task</a>
    </nav>

    <h1>Task List</h1>

    <?php if (empty($tasks)): ?>
        <p>No tasks yet!</p>
    <?php else: ?>

        <?php foreach ($tasks as $task): ?>

            <p>Task: <?= htmlspecialchars($task['title']) ?></p>
            <p>Description: <?= htmlspecialchars($task['description']) ?></p>
            <p>Priority: <?= htmlspecialchars($task['priority']) ?></p>
            <p>Due Date: <?= htmlspecialchars($task['due']) ?></p>
            <p>Completed: <?= ($task['complete'] === true ? 'Yes' : "No") ?></p>
        
            <form method="POST" action="actions.php">
                <input type="hidden" name="id" value="<?= $task['id'] ?>">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                <button name="action" value="complete">Complete</button>
            </form>

            <form method="POST" action="actions.php">
                <input type="hidden" name="id" value="<?= $task['id'] ?>">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                <button name="action" value="delete">Delete</button>
            </form>

            <hr>

        <?php endforeach; ?>

    <?php endif; ?>
</body>
</html>





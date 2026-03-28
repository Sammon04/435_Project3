<?php
require_once '../src/storage.php';
require_once '../src/flash.php';

session_start();

$csrf_token = csrfCreate();

displayFlash();


$tasks = loadTasks();
$q = trim($_GET['q'] ?? '');
$priority = $_GET['priority'] ?? '';

$filteredTasks = array_filter($tasks, function($task) use ($q, $priority) {
    if ($q !== '') {
        $textMatch = 
            stripos($task['title'], $q) !== false ||
            stripos($task['description'], $q) !== false;
        
        if (!$textMatch) {
            return false;
        }
    }

    if ($priority !== '' && $task['priority'] !== $priority) {
        return false;
    }

    return true;
});

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

    <h3>Filter Tasks</h3>
    <form method="GET" action="index.php">
        <input
            type="text"
            name="q"
            placeholder="Search..."
            value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
        >

        <select name="priority">
            <option value="">ALL</option>
            <option value="Low" <?= ($_GET['priority'] ?? '') === 'Low' ? 'selected' : '' ?>>Low</option>
            <option value="Medium" <?= ($_GET['priority'] ?? '') === 'Medium' ? 'selected' : '' ?>>Medium</option>
            <option value="High" <?= ($_GET['priority'] ?? '') === 'High' ? 'selected' : '' ?>>High</option>
        </select>

        <button type="submit">Filter</button>
    </form>


    <?php if (empty($tasks)): ?>
        <p>No tasks yet!</p>
    <?php elseif (empty($filteredTasks)): ?>
        <p>No tasks match filter!</p>
    <?php else: ?>

        <?php if (!empty($_GET) && !empty($filteredTasks)): ?>
            <p><?= count($filteredTasks) ?> task(s) found</p>
        <?php endif; ?>

        <?php foreach ($filteredTasks as $task): ?>

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





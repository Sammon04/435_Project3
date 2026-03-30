<?php

//This is unsurprisingly the main page
//On load we get a csrf token and the list of tasks from the JSON file
//Then we filter them based on anything in the filter form
//The filter form preserves inputs after filtering and reloading the page
//The list just loops through every task in $tasks and displays whatever is there

require_once '../src/storage.php';
require_once '../src/flash.php';
require_once '../src/csrf.php';

session_start();

$csrf_token = csrfCreate();


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
    <link rel="stylesheet" href="../src/styles.css">
    <title>TaskPad</title>
</head>
<body>

    <header class="page-header">
        <h1 class="page-title">Task List</h1>
    </header>

    <nav class="page-nav">
        <a href="index.php">Home</a>
        <a href="create.php">Create Task</a>
    </nav>

    <main class="content">
        <section class="filter-section">

            <h3 class="filter-header">Filter Tasks</h3>
            <form class="filter-form" method="GET" action="index.php">
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

        </section>

        <section class="task-list">

            <div>
                <?php displayFlash(); ?>
            </div>

            <?php if (empty($tasks)): ?>
                <p class="alert">No tasks yet!</p>
            <?php elseif (empty($filteredTasks)): ?>
                <p class="alert">No tasks match filter!</p>
            <?php else: ?>

                <?php if (!empty($_GET) && !empty($filteredTasks)): ?>
                    <p><?= count($filteredTasks) ?> task(s) found</p>
                <?php endif; ?>

                <?php foreach ($filteredTasks as $task): ?>

                    <div class="task-card">
                        <div class="task-details">
                            <h3><?= htmlspecialchars($task['title']) ?></h3>
                            <p><?= htmlspecialchars($task['description']) ?></p>

                            <?php if ($task['priority']): ?>
                                <p class="priority-<?= strtolower($task['priority']) ?>">
                                    <?= htmlspecialchars($task['priority']) ?> Priority
                                </p>
                            <?php endif; ?>

                            <?php if ($task['due']): ?>
                                <p>Due: <?= htmlspecialchars($task['due']) ?></p>
                            <?php endif; ?>

                            <p><?= ($task['complete'] === true ? 'Completed!' : '') ?></p>
                            <?php if ($task['complete'] === true): ?>
                                <img class="badge" src='../src/badge.png'>
                            <?php endif; ?>
                        </div>
                        
                        
                        <div class="task-buttons">
                            <?php if (!$task['complete']): ?>
                                <form method="POST" action="actions.php">
                                    <input type="hidden" name="id" value="<?= $task['id'] ?>">
                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                                    <button name="action" value="complete">Complete</button>
                                </form>
                            <?php endif; ?>
                            <form method="POST" action="actions.php">
                                <input type="hidden" name="id" value="<?= $task['id'] ?>">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                                <button name="action" value="delete">Delete</button>
                            </form>
                        </div>
                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

        </section>
    </main>
    
</body>
</html>





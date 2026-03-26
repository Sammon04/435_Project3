<?php

require_once '../src/storage.php';

$tasks = loadTasks();

foreach ($tasks as $task) {
    echo "<p>" . htmlspecialchars($task['title']) . "</p>";
}

if (empty($tasks)) {
    echo "<p>No tasks yet!</p>";
}
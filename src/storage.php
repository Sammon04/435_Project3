<?php

function loadTasks() {
    $filePath = '../data/tasks.json';

    $jsonString = file_get_contents($filePath);

    if ($jsonString === false) {
        die("Error reading JSON file");
    }

    $data = json_decode($jsonString, true);

    if ($data === null) {
        die("Error decoding JSON data");
    }

    return $data;
}

function writeTasks($tasks) {
    $filePath = '../data/tasks.json';

    $jsonString = json_encode($tasks, JSON_PRETTY_PRINT);

    if (file_put_contents($filePath, $jsonString) !== false) {
        echo "Tasks were written to file";
    } else {
        echo "Error when writing to file";
    }
}
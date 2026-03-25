<?php

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? ''; //?? tests whether the data exists or not, in this case if it doesn't, assign an empty string
    echo "Hello " . htmlspecialchars($username);
}
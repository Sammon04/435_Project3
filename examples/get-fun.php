<?php

$id = $_GET['id'] ?? null;

if($id) {
    echo "Viewing item " . htmlspecialchars($id);
}
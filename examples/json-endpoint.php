<?php

header("Content-Type: application/json");

$data = [
    "course" => "CIS 435",
    "topic" => "PHP"
];

echo json_encode($data);
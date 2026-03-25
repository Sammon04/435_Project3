<?php

require_once('Student.php');

$student = new Student('Alice', 'Computer Science');

echo $student->getDescription();
<?php

//These are tester functions
//If they return true, it means the input 'passed' the test

function validateSpecialChars(string $text): bool {
    return !preg_match('/[^a-zA-Z0-9 \/-_!?,]/', $text);
}

function validateLength(string $text, int $length): bool {
    return strlen($text) <= $length;
}

function validatePriority(string $text): bool {
    return ($text === 'Low' || $text === "Medium" || $text === "High");
}

function validateDate(string $date): bool {
    $format = 'm-d-Y';
    $d = DateTime::createFromFormat($format, $date);

    return $d && $d->format($format) === $date;
}

function validateForm(array $data): array {
    $errors = [];
    if ($data['title'] === '') {
        $errors['title'] = 'Title is required';
    }

    if (!validateLength($data['title'], 50)) {
        $errors['title'] = 'Title must be less than 50 characters';
    }

    if (!validateSpecialChars($data['title'])) {
        $errors['title'] = 'Invalid characters in title';
    }

    if (!validateSpecialChars($data['description'])) {
        $errors['description'] = 'Invalid characters in description';
    }

    if ($data['due'] !== '' && !validateDate($data['due'])) {
        $errors['due'] = 'Invalid date format. Must be mm-dd-YYYY';
    }

    return $errors;
}
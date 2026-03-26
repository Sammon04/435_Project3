<?php

function removeSpecialChars(string $text) {
    $cleanText = preg_replace('/[^a-zA-Z0-9 \-_]', '', $text);
    return $cleanText;
}

function validateLength(string $text, int $length) {
    if (strlen($text) <= $length) {
        return true;
    } else {
        return false;
    }
}

function validatePriority(string $text) {
    if ($text === 'Low' || $text === "Medium" || $text === "High") {
        return true;
    } else {
        return false;
    }
}

function validateDate($date) {
    $format = 'm-d-Y';
    $d = DateTime::createFromFormat($format, $date);

    return $d && $d->format($format) === $date;
}
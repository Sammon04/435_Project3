<?php

//Just sets and displays a flash message in the $_SESSION superglobal

function setFlash(string $message) {
    $_SESSION['flash-message'] = $message;
}

function displayFlash() {
    if (isset($_SESSION['flash-message'])) {
        echo '<div class="alert">' . htmlspecialchars($_SESSION['flash-message']) . '</div>';
        unset($_SESSION['flash-message']);
    }
}
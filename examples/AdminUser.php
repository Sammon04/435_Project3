<?php

require_once('User.php');

class AdminUser extends User {
    public function getRole() : string {
        return "Administrator";
    }
}
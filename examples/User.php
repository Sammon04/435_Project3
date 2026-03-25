<?php

class User {
    protected string $username;

    public function __construct(string $username) {
        $this->username = $username;
    }

    public function getRole() : string {
        return "User";
    }

    public function getUsername() : string {
        return $this->username;
    }
}
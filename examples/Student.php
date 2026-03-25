<?php

class Student {
    private string $name;
    private string $major;
    
    public function __construct(string $name, string $major) {
        $this->name = $name;
        $this->major = $major;
    }

    public function getDescription() : string {
        return "{$this->name} majors in {$this->major}";
    }
}
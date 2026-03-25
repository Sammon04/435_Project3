<?php

require_once('User.php');
require_once('AdminUser.php');

$user = new User("Jdoe");
$admin = new AdminUser("prof");

echo "Username: " . $user->getUsername();
echo " Role: " . $user->getRole();
echo "<br>Username: " . $admin->getUsername();
echo " Role: " . $admin->getRole();
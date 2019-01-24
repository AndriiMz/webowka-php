<?php
require 'db.php';

$errors = [];
$mysqli = getMysqli($errors);
if ($mysqli) {
    $query = getPlainQuery($mysqli);
    $query('CREATE TABLE users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            login VARCHAR(30) NOT NULL,
            password VARCHAR(255) NOT NULL,
            firstname VARCHAR(30) NOT NULL,
            lastname VARCHAR(30) NOT NULL,
            email VARCHAR(50)
            )');
}


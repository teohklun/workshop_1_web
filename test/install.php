<?php

/**
 * Open a connection via PDO to create a
 * new database and table with structure.
 *
 */

 //just to want get define host, dbusername, dbpassword
require "config.php";

try {
    $connection = new PDO("mysql:host=$host", $dbUsername, $dbPassword, $options);
    $sql = file_get_contents("data/init.sql");
    $connection->exec($sql);
    
    $sql = file_get_contents("data/init2.sql");
    $connection->exec($sql);
        
    $sql = file_get_contents("data/init3.sql");
    $connection->exec($sql);
    echo "Database and table users created successfully.";
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

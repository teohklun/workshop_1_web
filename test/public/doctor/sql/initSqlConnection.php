<?php
if(!isset($selected)) {
    $selected = '*';
}
$from = 'doctor';
$join = ['LEFT JOIN', 'LEFT JOIN'];
$linkColumn = ['ProfileID', 'AddressID'];
$relationTable = ['profile', 'address'];
$tableName = ['doctor', 'profile'];
$primaryKey = 'DoctorID';
$excludeFromDetailColumn = ['ProfileID', 'AddressID'];


$connection = new PDO($dsn, $dbUsername, $dbPassword, $options);
$sql = getSelectQueryString($selected, $from, $join, $linkColumn, $relationTable, $tableName);
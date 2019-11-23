<?php
$selected = '*';
$from = 'patient';
$join = ['LEFT JOIN', 'LEFT JOIN'];
$linkColumn = ['ProfileID', 'AddressID'];
$relationTable = ['profile', 'address'];
$tableName = ['patient', 'profile'];
$primaryKey = 'PatientID';
$excludeFromDetailColumn = ['ProfileID', 'AdressID'];

$connection = new PDO($dsn, $dbUsername, $dbPassword, $options);
$sql = getSelectQueryString($selected, $from, $join, $linkColumn, $relationTable, $tableName);
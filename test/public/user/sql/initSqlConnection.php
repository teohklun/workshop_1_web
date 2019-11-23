<?php
$selected = '*';
$from = 'users';
$join = ['LEFT JOIN', 'LEFT JOIN'];
$linkColumn = ['ProfileID', 'AddressID'];
$relationTable = ['profile', 'address'];
$tableName = ['users', 'profile'];
$primaryKey = 'UserID';

$excludeFromDetailColumn = ['Password', 'ProfileID', 'AddressID'];

$connection = new PDO($dsn, $dbUsername, $dbPassword, $options);
$sql = getSelectQueryString($selected, $from, $join, $linkColumn, $relationTable, $tableName);
$statement = $connection->prepare($sql);
$statement->execute();
$result = $statement->fetch(PDO::FETCH_ASSOC);
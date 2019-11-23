<?php
if(!isset($selected)) {
    $selected = '*';
}
$from = 'schedule';
$join = ['LEFT JOIN', 'LEFT JOIN'];
$linkColumn = ['DoctorID', 'ProfileID'];
$relationTable = ['doctor', 'profile'];
$tableName = ['schedule', 'doctor'];
$primaryKey = 'ScheduleID';
$excludeFromDetailColumn = ['DoctorID','ProfileID', 'AddressID'];

$connection = new PDO($dsn, $dbUsername, $dbPassword, $options);
$sql = getSelectQueryString($selected, $from, $join, $linkColumn, $relationTable, $tableName);
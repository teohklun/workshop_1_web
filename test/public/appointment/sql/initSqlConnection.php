<?php
if(!isset($selected)) {
    $selected = '*';
}

$from = 'appointment';
$join = ['LEFT JOIN', 'LEFT JOIN', 'LEFT JOIN'];
$linkColumn = ['ScheduleID', 'PatientID', 'profileID'];
$relationTable = ['schedule', 'patient', 'profile'];
$tableName = ['appointment', 'appointment', 'patient'];
$primaryKey = 'AppointmentID';

$excludeFromDetailColumn = [];

$connection = new PDO($dsn, $dbUsername, $dbPassword, $options);
$sql = getSelectQueryString($selected, $from, $join, $linkColumn, $relationTable, $tableName);
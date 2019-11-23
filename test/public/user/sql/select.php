<?php 
    include 'initSqlConnection.php';
    $sql .= ' where '.$from.'.'.$primaryKey.' = '.$paramID.'';
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
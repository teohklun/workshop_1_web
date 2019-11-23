<?php 

    //will execut sql based on initSqlConnection define data to perform select query
    // mainly are just to get the record with its primary key ID only

    // use to get record with the id, check this id exist in the data table

    // previousIncludeFilePath will be declare before calling this file
    // so it will include the called file 's initSqlConnection.php
    include $previousIncludeFilePath . '/sql/' .'initSqlConnection.php';
    $sql .= ' where '.$from.'.'.$primaryKey.' = '.$paramID.'';
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
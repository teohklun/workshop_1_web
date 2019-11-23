<?php 

    //sql statement share by all delete page to perform basic delete with primary key, id

    $id = $_POST["id"];
    
    $sql = 'DELETE FROM '.$tableName[0].' WHERE '.$primaryKey.' =:id';
    $statement = $connection->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_STR);
    $statement->execute();
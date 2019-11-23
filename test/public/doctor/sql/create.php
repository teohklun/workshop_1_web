<?php 
    try  {
        include "../templates/address/sql/create.php";
        include "../templates/profile/sql/create.php";

        $newUser = array(
            "Professional" => $input['Professional'],
            "ProfileID" => $ProfileID
        );

        $sql = getSqlInsertQueryString($tableName[0], $newUser);
        $statement = $connection->prepare($sql);
        $statement->execute($newUser);
        $username = $input['Name'];
        $input = [];

    } catch(PDOException $error) {
        $dbAction = false;
        echo $sql . "<br>" . $error->getMessage();
    }
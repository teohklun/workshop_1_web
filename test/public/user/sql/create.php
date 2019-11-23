<?php 
    try  {
        include "../templates/address/sql/create.php";
        include "../templates/profile/sql/create.php";

        $newUser = array(
            "Username" => $input['Username'],
            "Password"  => password_hash($input['Password'], 1),
            "ProfileID" => $ProfileID
        );

        $sql = getSqlInsertQueryString($tableName[0], $newUser);
        $statement = $connection->prepare($sql);
        $statement->execute($newUser);
        $username = $input['Username'];
        $input = [];

    } catch(PDOException $error) {
        $dbAction = false;
        echo $sql . "<br>" . $error->getMessage();
    }
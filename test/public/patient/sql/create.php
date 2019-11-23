<?php 
    try  {
        include "../templates/address/sql/create.php";
        include "../templates/profile/sql/create.php";

        $newUser = array(
            "Debt" => $input['Debt'],
            "ProfileID" => $ProfileID,
            // 'UpdatedAt' => date('Y-m-d h:i:s'),
            'CreatedBy' => $_SESSION['UserID'],
            'UpdatedBy' => $_SESSION['UserID'],
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
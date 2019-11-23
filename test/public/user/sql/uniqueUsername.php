<?php
      //unique username
      $sqlTemp = $sql;
      $sqlTemp .= ' where users.Username = "'.$input['Username'].'" ';
      if(isset($paramID)) {
        $sqlTemp .= ' and users.UserID !=' . $paramID;
      }
      $statement = $connection->prepare($sqlTemp);
      $statement->execute();
      $dbResult = $statement->fetchAll(PDO::FETCH_ASSOC);
      if(count($dbResult) > 0) {
        $errMessage .= 'Username \''. $input['Username'] .'\' existed in the database.</br>';
        $validation = false;
      }
      unset($dbResult);
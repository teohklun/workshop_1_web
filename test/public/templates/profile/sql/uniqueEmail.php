<?php 
  if($input['Email'] !== '') {
    $sqlTemp = $sql;
    $sqlTemp .= ' where profile.Email = "'.$input['Email'].'" ';
    if(isset($paramID)) {
        $sqlTemp .= ' and '.$tableName[0].'.'. $primaryKey .' !=' . $paramID;
    }
    $statement = $connection->prepare($sqlTemp);
    $statement->execute();
    $tempResult = $statement->fetchAll(PDO::FETCH_ASSOC);
    if(count($tempResult) > 0) {
      $errMessage .= 'Email \''. $input['Email'] .'\' existed in the database.</br>';
      $validation = false;
    }
    unset($tempResult);
  }
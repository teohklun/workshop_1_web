<?php 
  if($input['IC'] !== '') {
    $sqlTemp = $sql;
    $sqlTemp .= ' where profile.IC = "'.$input['IC'].'" ';
    if(isset($paramID)) {
        $sqlTemp .= ' and '.$tableName[0].'.'. $primaryKey .' !=' . $paramID;
    }
    $statement = $connection->prepare($sqlTemp);
    $statement->execute();
    $tempResult = $statement->fetchAll(PDO::FETCH_ASSOC);
    // print_r($tempResult);
    // die;
    if(count($tempResult) > 0) {
      $errMessage .= 'IC \''. $input['IC'] .'\' existed in the database.</br>';
      $validation = false;
    }
    unset($tempResult);
  }
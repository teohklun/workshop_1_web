<?php
// if no error in testing mean this file no longer using
?>
<?php
    //   //unique username
    //   $sqlTemp = $sql;
    //   $sqlTemp .= ' where users.Username = "'.$input['Username'].'" ';
    //   if(isset($paramID)) {
    //     $sqlTemp .= ' and users.UserID !=' . $paramID;
    //   }
    //   $statement = $connection->prepare($sqlTemp);
    //   $statement->execute();
    //   $dbResult = $statement->fetchAll(PDO::FETCH_ASSOC);
    //   if(count($dbResult) > 0) {
    //     $errMessage .= 'Username \''. $input['Username'] .'\' existed in the database.</br>';
    //     $validation = false;
    //   }
    //   unset($dbResult);


//    parameter 
//      input - inputValue
//    return void
    function isNotUniqueDatabaseValue ($input, $inputColumn, $paramID = null, $dbResult = null) {
        if(!$dbResult) {

            global $sql;
            $sqlTemp = $sql;
            $sqlTemp .= ' where users.'.$inputcolumn.' = "'.$input[$inputcolumn].'" ';
            if(isset($paramID)) {
                $sqlTemp .= ' and users.UserID !=' . $paramID;
            }
            $statement = $connection->prepare($sqlTemp);
            $statement->execute();
            $dbResult = $statement->fetchAll(PDO::FETCH_ASSOC);
            if(count($dbResult) > 0) {
                $errMessage .= $inputcolumn . '\''. $input[$inputcolumn] .'\' existed in the database.</br>';
                $validation = false;
            }
        }
    }
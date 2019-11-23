<?php

try  {
    if($input['ConfirmPassword'] === '' || $input['ConfirmPassword'] === null) {
        $input['Password'] = $result['Password'];
    } else {
        $beforeHashPassword = $input['Password'];
        $input['Password'] = password_hash($input['Password'], 1);
    }
    unset($input['ConfirmPassword']);

    if(!isset($uploadFileName, $uploadFileName['img']) && $input['DelProfile'] == 0 ) {
        $input['ProfilePath'] = $result['ProfilePath'];
    } elseif ($input['DelProfile'] == 1 && !isset($uploadFileName, $uploadFileName['img']) && $result['ProfilePath'] != null) {
        $input['ProfilePath'] = null;
        deleteUnsaveFile(PATH_C . $result['ProfilePath']);
    }
     elseif(isset($uploadFileName, $uploadFileName['img'])){
        $input['ProfilePath'] = PATH_STORAGE . basename($uploadFileName['img']);
        deleteUnsaveFile(PATH_C . $result['ProfilePath']);
    } else {
        $input['ProfilePath'] = PATH_STORAGE . basename($uploadFileName['img']);
    }
    
    unset($input['DelProfile']);

    $sql = "UPDATE ". $from ." ". $from ."
    left join profile profile on profile.ProfileID = ".$from.".ProfileID
    left join address address on address.AddressID = profile.AddressID
    SET 
      Username = :Username, 
      Password = :Password,
      profile.ContactNo = :ContactNo,
      profile.Name = :Name, 
      profile.IC = :IC, 
      profile.Email = :Email ,
      profile.ProfilePath = :ProfilePath ,
      address.City = :City ,
      address.State = :State ,
      address.Postcode = :Postcode,
      address.Street = :Street 
    WHERE users.UserID = ".$paramID."";
    
    $statement = $connection->prepare($sql);
    $statement->execute($input);
    $username = $input['Username'];
    if(isset($beforeHashPassword)) {
        $input['Password'] = $beforeHashPassword;
        $input['ConfirmPassword'] = $beforeHashPassword;
    } else {
        unset($input['Password']);
    }
} catch(PDOException $error) {
    $dbAction = false;
    echo $sql . "<br>" . $error->getMessage();
    die;
}
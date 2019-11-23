<?php

try  {
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
    inner join profile profile on profile.ProfileID = ".$from.".ProfileID
    inner join address address on address.AddressID = address.AddressID
    SET 
      Debt = :Debt,
      profile.ProfilePath = :ProfilePath ,
      UpdatedAt = CURRENT_TIMESTAMP,
      UpdatedBy = :UpdatedBy,
      profile.ContactNo = :ContactNo,
      profile.Name = :Name, 
      profile.IC = :IC, 
      profile.Email = :Email ,
      Address.City = :City ,
      Address.State = :State ,
      Address.Postcode = :Postcode,
      Address.Street = :Street 
    WHERE ".$primaryKey." = ".$paramID."";

    $statement = $connection->prepare($sql);
    $input['UpdatedBy'] = $_SESSION['UserID'];
    $statement->execute($input);
    $username = $input['Name'];

} catch(PDOException $error) {
    $dbAction = false;
    echo $sql . "<br>" . $error->getMessage();
}
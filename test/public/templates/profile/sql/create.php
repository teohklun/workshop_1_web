<?php
if($uploadFileName) {
    $profilePath = PATH_STORAGE . basename($uploadFileName['img']);
} else {
    $profilePath = null;
}
$newProfile = array(
    "ContactNo" => $input['ContactNo'],
    "Name"  => $input['Name'],
    "IC"  => $input['IC'],
    "Email"  => $input['Email'],
    'AddressID' => $addressID,
    'profilePath' => $profilePath
);
unset($profilePath);
$sql = getSqlInsertQueryString('profile', $newProfile);
$statement = $connection->prepare($sql);
$statement->execute($newProfile);
$ProfileID = $connection->lastInsertId();
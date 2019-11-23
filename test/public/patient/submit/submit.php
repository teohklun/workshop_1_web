<?php
  // init data
  $validation = true;
  $errMessage = '';
	include "../crudPhp/form/initFormField.php";

    do {
      //validation withouth database
      include "../templates/validation/validateClientInput.php";
      include "../templates/profile/savePicture.php";
      if($errMessage !== '') {
        $validation = false;
        produceSessionMessage();
        deleteUnsaveFile($uploadFileName);
        break;
      }

      //init data for db connection
      include "sql/initSqlConnection.php";

      include "../templates/profile/sql/uniqueEmail.php";
      include "../templates/profile/sql/uniqueIC.php";
      produceSessionMessage();
      if($errMessage) {
        deleteUnsaveFile($uploadFileName);
      }
      if($validation) {
        try  {
          include "sql/$action.php";
        } catch(PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
        produceSessionMessage();
        unsetSubmittedData();
      }

} while (0);
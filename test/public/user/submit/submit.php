<?php
  // init data
  $validation = true;
  $errMessage = '';

	include "../crudPhp/form/initFormField.php";
    do {
      $validateClient = true;
      // validation without database
      include "../templates/validation/validateClientInput.php";

      include "../templates/profile/savePicture.php";
      if($errMessage !== '') {
        produceSessionMessage();
        deleteUnsaveFile($uploadFileName);
        $validation = false;
        break;
      }
      
      //init data for db connection
      //logic for craete user with sql
      include "sql/initSqlConnection.php";

      include "sql/uniqueUsername.php";
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
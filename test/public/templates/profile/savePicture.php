<?php 
//save picture based on input
foreach ($_FILES as $key => $file) {
    $uploadFileName = [];
    if(isset($file) && $file['error'] == 0 ) { // only file input inside got file 
      $file_type = $file['type']; //returns the mimetype

      $allowed = array("image/jpeg", "image/gif", "image/png");
      if(in_array($file_type, $allowed)) {
        $m=microtime(true);
        $uploadFileName[$key] = $_SERVER['DOCUMENT_ROOT'] . PATH_STORAGE . sprintf("%8x%05x",floor($m),($m-floor($m))*1000000) . '.' . explode('/' , $file_type)[1];
        move_uploaded_file(
          $file["tmp_name"],
          $uploadFileName[$key]
        );
      } else {
        $errMessage .= 'Only jpg, gif, and png files are allowed for image upload.';
      }
    } elseif (isset($file) && $file['error'] == 1) {
      $errMessage .= 'The uploaded file exceeds the upload max size setting.';
    } elseif (isset($file) && $file['error'] == 2) {
      $errMessage .= 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
    } elseif (isset($file) && $file['error'] == 3) {
      $errMessage .= 'The uploaded file was only partially uploaded.';
    }
  }
  ?>
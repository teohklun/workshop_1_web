<?php 

// this file is to perform the action of retrieve the record from post data or submitted data.

// if it is create or submit then will be get the all posted data
    if($action === 'create' || isset($_POST['submit'])) {
        $input = [];
        $posted = $_POST;

        //unset unused data for database object array
        unset($posted['csrf']);
        unset($posted['submit']);
        $initDataArray = $posted;

    } else {
        // initial status of edit
        $initDataArray = [];
        if($result && is_array($result)){
            $initDataArray = $result;
        }
    }
    foreach ($initDataArray as $key => $value) {
        $key = str_replace('_', '', $key);

        //declare varaible input as receive from post or data from database
        $input[$key] = $value;
    }
?>
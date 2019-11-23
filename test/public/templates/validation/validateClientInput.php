<?php

    // a list of codes / statement will be responsible to check the input with config setting 

    foreach ($config[PAGEMODULE][$baseName]['action'][$action]['configFields']['fields'] as $key => $value) {
        if(isset($input[$key])) {
            $inputToVerify[$key] = array_merge($value, 
            ['value' => $input[$key]]);
        } else {
            $errMessage .= 'Field ' . $key . ' does not receive.</br>';
        }
    }
    if($inputToVerify) {
        include "../templates/validation/core.php";
        $errMessage .= validateValues($inputToVerify);
    } else {
        throw new \Exception("Config Error, config field not found for validation", 1);
    }
?>
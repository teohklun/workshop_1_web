<?php
//responsible to check the input array is valid or not based on config file setting

include "../templates/validation/emailInput.php";
include "../templates/validation/numberInput.php";
include "../templates/validation/dateInput.php";
include "../templates/validation/timeInput.php";
include "../templates/validation/lengthInput.php";
include "../templates/validation/compareInput.php";

// where use - when want to get validateValues
// usage - validate input of array with config to ensure the input is valid in setting
// parameter
	// inputsToVerify - @dataType - array 
//return string || ''
function validateValues($inputsToVerify){
    if($inputsToVerify && is_array($inputsToVerify)) {
        $errMessage = '';
        foreach ($inputsToVerify as $inputName => $inputSettings) {
            $inputValue = $inputSettings['value'];
            foreach ($inputSettings['validation'] as $validationType => $validationName) {
                if($validationName === 'required') {
                    if($inputValue === '') {
                            $errMessage .= 'The input of ' . $inputName. ' must not be blank.</br>';
                    }
                }
                if($inputValue !== '') {
                    if($validationType === 0 && $validationName === 'number' || $validationType === 'number' 
                    ) {
                        if(is_array($validationName)) {
                                
                            if(isset($validationName[0]) && $validationName[0] === '!') {
                                // try check it is to check not number?
                                if(validateGotNumber($inputValue)) {
                                    $validation = false;
                                    $errMessage .= 'The input of ' . $inputName. ' must not has numberic characters Or is numberic characters.</br>';
                                }
                                continue;
                            }
                            elseif( is_numeric($validationName[1])) {
                                if(!validateNumberInput($inputValue, $validationName[0], $validationName[1])) {
                                    $validation = false;
                                    $errMessage .= 'The input of ' . $inputName. ' must be at least more than '.$validationName[0]. ' and less than '. $validationName[1] .'</br>';
                                }
                            } elseif($validationName[1] === '>' || $validationName[1] === '>=' 
                                || $validationName[1] === '<' || $validationName[1] === '<=' 
                                || $validationName[1] === '==' || $validationName[1] === '!='
                                ) {
                                if(!operatorValidateNumbersInput($inputValue, $validationName[1], $validationName[0])) {
                                    $validation = false;
                                    $errMessage .= 'The input of ' . $inputName. ' must be '.$validationName[1]. ' '. $validationName[0] .'</br>';
                                }
                            }
                        }
                        if(!isNumber($inputValue)) {
                            $validation = false;
                            $errMessage .= 'The input of ' . $inputName. ' must be number.</br>';
                        }
                    } 
                    elseif($validationType === 'length') {
                        if(!validateStringLength($inputValue, $validationName)) {
                            if(is_array($validationName)){
                                if(isset($validationName[0], $validationName[1])) {
                                    $validation = false;
                                    $errMessage .= 'The input of ' . $inputName. ' must be more than ' . $validationName[0] . ' and less than '. $validationName[1] .' characters.</br>';
                                } else {
                                    throw new \Exception("parameter missing for array config in length validation setting.", 1);
                                }
                            } else{
                                $strlen = strlen($inputValue);
                                $validation = false;
                                $errMessage .= 'The input of ' . $inputName. ' must be more than ' . $validationName . ' characters. Currently is ' . $strlen .' </br>';
                            }
                        }
                    } 
                    elseif($validationName === 'email') {
                        if(!isEmail($inputValue)) {
                            $validation = false;
                            $errMessage .= 'The input of ' . $inputName. ' "' . $validationName .'" ' . 'is not a valid '.$validationName.' format .</br>';
                        }
                    }
                    elseif($validationName === 'date') {

                        if(!validateDate($inputValue)) {
                            $validation = false;
                            $errMessage .= 'The input of ' . $inputName . ' "' . $validationName .'" ' . 'is not a valid '.$validationName.' format' . '.</br>';
                        }
                    }
                    elseif($validationName === 'time') {
                        if(!isValidTimeStamp($inputValue)) {
                            $validation = false;
                            $errMessage .= 'The input of ' . $inputName. ' "' . $validationName .'" ' . 'is not a valid '.$validationName.' format' . '.</br>';
                        }
                    }
                    elseif($validationType === 'compare') {
                        $compareWithValue = $inputsToVerify[$validationName]['value'];
                        if($compareWithValue) {
                            if(!validateCompare($inputValue, $compareWithValue)) {
                                $validation = false;
                                $errMessage .= 'The input of ' . $inputName. ' does not match ' . 'with field of '. $validationName . '.</br>';
                            }
                        }
                    }
                }
            }
        }
    }
    return $errMessage;
}
?>
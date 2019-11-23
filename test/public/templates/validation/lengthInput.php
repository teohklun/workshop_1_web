<?php 

//lengeth can be value or array,
//default first parameter is min
//array [min, max]
function validateStringLength ($string, $length, $option = 'exactly') {
    if(is_array($length) && isset($length[0], $length[1])) {
        $minLength = $length[0];
        $maxLength = $length[1];
    }
    $len = strlen($string);

    if(isset($maxLength, $minLength)) {
        if($len < $minLength || $len > $maxLength) {
            return false;
        }
    } elseif($option === 'minimum') {
        $minLength = $length;
        if($len < $minLength) {
            return false;
        }
    } elseif($option === 'maximum') {
        $maxLength = $length;
        if($len > $maxLength) {
            return false;
        }
    } elseif($option === 'exactly') {
        $exactLength = $length;
        if(!($len === $exactLength)) {
            return false;
        }
    }

    return TRUE;

}
?>
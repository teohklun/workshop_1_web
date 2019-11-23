<?php 

//lengeth can be value or array,
//default first parameter is min
//array [min, max]
function validateCompare ($input, $input2, $option = 'same') {
    if($input === $input2) {
        return true;
    } else {
        return false;
    }
}


function validateGotNumber($string) {
    if (preg_match('~[0-9]+~', $string)) {
        return true;
    }
    return false;
}
?>
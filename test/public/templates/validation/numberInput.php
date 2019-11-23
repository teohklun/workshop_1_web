<?php 

function isNumber ($input) {
    if(is_numeric($input)) {
      return true;
    } else {
      return false;
    }
  }

  function validateNumberInput($inputValue, $param_1 = null, $param_2 = null) {
      if(isset($param_1) && $inputValue < $param_1) {
        return false;
      } elseif (isset($param_2) && $inputValue > $param_2) {
        return false;
      }
      return true;
  }

  function operatorValidateNumbersInput($value1, $operator, $value2)
{
    switch ($operator) {
        case '<':
            return $value1 < $value2;
            break;
        case '<=':
            return $value1 <= $value2;
            break;
        case '>':
            return $value1 > $value2;
            break;
        case '>=':
            return $value1 >= $value2;
            break;
        case '==':
            return $value1 == $value2;
            break;
        case '!=':
            return $value1 != $value2;
            break;
        default:
            return false;
    }
    return false;
}
?>
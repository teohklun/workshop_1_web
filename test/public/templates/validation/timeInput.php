<?php 
function isValidTimeStamp($timeString)
{
    return preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$/", $timeString);
}
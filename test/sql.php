<?php 
// a list of function relate to get simplyify sql string

// where use - when want to get SqlInsertQueryString
// usage - can get the sql string of insert of trying to prevent sql injection
// parameter
	// tableName - string - users 
	// object - array - [UserID => 1 ]
//return string
function getSqlInsertQueryString($tableName, $object) {
	return sprintf(
		"INSERT INTO %s (%s) values (%s)",
		$tableName,
		implode(", ", array_keys($object)),
		":" . implode(", :", array_keys($object))
	  );
}

// where use - when want to get SqlSelect, in simple module of index.php
// usage - can get the sql string of select
//  special of this function is can based on the wish to select column, which table, join with who, to form a powerful sql string
// parameter
	// selected - string - * or select users.UserID 
    // from - string - users
    // join - array - [left join ,left join]
    // linkColumn - array - [ProfileID, AddressID]
    // relationTable - array - [users, address]
    // tableName - array - [profile, address]
//return string
function getSelectQueryString($selected, $from, $join = false, $linkColumn = false, $relationTable = false, $tableName = false) {
    $sql = 
    'select ' . $selected . 
    ' from ' . $from;

    if($join) {
        //relation link array size should same
        for ($i = 0; $i < count($linkColumn); $i++) { 
            $sql .=  ' ' . $join[$i] . ' ' . $relationTable[$i] . ' ON ' . $tableName[$i] . '.' . $linkColumn[$i] . ' = ' . $relationTable[$i] . '.' . $linkColumn[$i];
        }
    }

    return $sql;
}
<?php

// where use - when want to verify the form field is valid
// usage - know the subbmitted form is valid, not from another person(device) subbmited data
//return void
if (empty($_SESSION['csrf'])) {
	if (function_exists('random_bytes')) {
		$_SESSION['csrf'] = bin2hex(random_bytes(32));
	} else if (function_exists('mcrypt_create_iv')) {
		$_SESSION['csrf'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
	} else {
		$_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
	}
}

/**
 * Escapes HTML for output
 *
 */
function escape($html) {
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

// where use - when want to compare password
// usage - know the two input is same
//parameter
	// string1 - password 
	// string1 - confirmPassword
//return boolean
function comparePassword($string1, $string2) {
	if($string1 === $string2){
		return true;
	} else{
		return false;
	}
}

// where use - when want to get availableSlotFromTwoDateTime
// usage - get can use slot from two datetime(YYYY-MM-DD HH:MM:SS)
// parameter
	// date1 - datetime 
	// date2 - datetime
//return integer
function getAvailableSlotFromTwoDateTime($date1, $date2) {
	$date1 = new DateTime($date1);
	$diff = $date1->diff(new DateTime($date2));
	
	$hour = $diff->h;
	$minutes = $diff->i + ($hour * 60);
	return $usedSlot = floor($minutes / 15);
}

// where use - called from every page to ensure the page currently is serving a device got session id inside the database
// usage - identity the user is authorised to use this page or not
// parameter
	// baseName - example, patient,user,doctor,schedule,appointment 
	// actionName - index,create,edit,delete,detail, and etc
//return boolean as 0 or 1
function checkAccess($baseName = null, $actionName = null) {
	
	global $dsn;
	global $dbUsername;
	global $dbPassword;
	global $options;

	$connection = new PDO($dsn, $dbUsername, $dbPassword, $options);
	if(isset($_SESSION, $_SESSION['UserID'])) {

		$sql = 'select type from users where UserID = '. $_SESSION['UserID'];
		$statement = $connection->prepare($sql);
		$statement->execute();
		//local variable will not effect global
		$result = $statement->fetch(PDO::FETCH_ASSOC);
		$type = $result['type'];

		if($baseName == null ) {
			global $baseName;
		}
	
		if($actionName == null) {
			global $actionName;
		}
	
		global $config;
		if(isset($config[PAGEMODULE], $config[PAGEMODULE][$baseName])) {
			$moduleSettings = $config[PAGEMODULE][$baseName];
		}
	
		if(!isset($moduleSettings)) {
			return 0;
		}
	
		if(isset($moduleSettings['commonSettings'], $moduleSettings['commonSettings']['permissionAll'])) {
			if(in_array($type, $moduleSettings['commonSettings']['permissionAll'])) {
				return 1;
			}
		}
	
		if(isset($moduleSettings['action'], $moduleSettings['action'][$actionName], $moduleSettings['action'][$actionName], $moduleSettings['action'][$actionName][ALLOWUSERTYPE])) {
			if(in_array($type, $moduleSettings['action'][$actionName][ALLOWUSERTYPE])) {
				return 1;
			}
		}
	}

	return 0;
}

// where use - when want to get the field config from config 
// usage - return a actual array of field
// parameter
	// fieldName - example, Name, IC, Professional and etc 
//return array
function getField($fieldName) {
	global $config;
	global $baseName;
	global $actionName;

	$moduleSettings = $config[PAGEMODULE][$baseName];
	if(isset($moduleSettings['action'],
	$moduleSettings['action'][$actionName],
	$moduleSettings['action'][$actionName]['configFields'],
	$moduleSettings['action'][$actionName]['configFields']['fields'],
	$moduleSettings['action'][$actionName]['configFields']['fields'][$fieldName])) {
		$field = $moduleSettings['action'][$actionName]['configFields']['fields'][$fieldName];
		return $field;
	}
	return [];
}

// where use - when want to get the field name is required field
// usage - return the field is requrie or notd
// parameter
	// inputFieldName - example, Name, IC, Professional and etc 
//return boolean
function isFieldRequired($inputFieldName) {
	$field = getField($inputFieldName);
	if(isset($field['validation'])) {
		foreach ($field['validation'] as $key => $value) {
			if($value === 'required') {
				return true;
			}
		}
	}
	return null;
}

// where use - when want to delete the submitted data from post, after create or update or delete
	// example user feeling wouldbe after F5, will not ask the form continue bla bla
// usage - after refresh or redirect will not remain the alert and hidden data in form
// parameter - none
//return void
function unsetSubmittedData() {
	$referer = $_SERVER['HTTP_REFERER'];
	$strExplode = explode('?', $referer);
	$streToBeImplode = '';

	//custom style of rewrite URL so that after submit got way to know it is submitted

	if(count($strExplode) > 1) {
	  $streToBeImplode = '&submit=success';
	} else {
	  if($action !== 'update') {
		$streToBeImplode = '?submit=success';
	  } else {
		$streToBeImplode = '&submit=success';
	  }
	}
	header('Location: '.$_SERVER['HTTP_REFERER'].$streToBeImplode);
	unset($strExplode);

	// this is important becasue without it, the system would be bug
	exit(0);
}

// where use - when want to create session message
	// example after clear header, the glboal variable will not going to work anymore, because it is a flash page,
	// so need to use session to store extra data
// usage - after refresh or redirect will not remain the alert and hidden data in form
// parameter - none
//return void
function produceSessionMessage(){

	$message;
	$messageType;

	global $errMessage;
	if($errMessage === '') {
		global $succesfulMessage;
		$message = $succesfulMessage;
		$messageType = 'success';

	} else {
		$messageType = 'error';
		$message = $errMessage;
	}

	if($messageType === 'error') {
		$class = 'error-message';
	} elseif($messageType === 'success') {
		$class = 'success-message';
	}

	// html format
	$sessionMessage = "<blockquote class=$class>
	<button type='button' class='close' aria-label='Close'>
		<span aria-hidden='true'>×</span>
	</button> 
	$message
  </blockquote>";
  $_SESSION['message'] = $sessionMessage;
}

function sessionMessage() {
	if(isset($_SESSION['message'])) {
		$message = $_SESSION['message'];

		//after show the message to user, delete the message in system, so after u refresh
		//, will not oging to show to u anymore
		echo($message);
		unset($_SESSION['message']);
	}
}

// where use - when want to create Summary Row For Summary Result in report page
	// currently mainly use for doctor performance report only
// usage - generate an array for html to print single row
// parameter - @dataType - array searched data from database
//return array
function createSummaryRowForSummaryResult($result) {
	$sum = 0;
	$max = 0;
	$min = 0;
	$count = 0;
	foreach ($result as $key => $value) {
		$sum += $value['sum'];
		if($max < $value['max'] ) {
			$max = $value['max'];
		}
		if($min == 0 || $min > $value['min']) {
			$min = $value['min'];
		}
		$count += $value['count(*)'];
	}
	$result[] = [
		'IFNULL(DoctorID, "Total")' => 'SUMMARY',
		'total' => $count,
		'sum' => number_format((float)$sum, 2, '.', ''),
		'min' => number_format((float)$min, 2, '.', ''),
		'max' => number_format((float)$max, 2, '.', ''),
		'avg' => number_format((float)$sum / $count, 2, '.', ''),
	];
	return $result;
}

// where use - when after the user submit the picture that is deleted or updated
// usage - delete the old / removed file or pciture path in user desire action
// parameter - @dataType - file C:\xampp\htdocs\public\storage\picture.png
//return array
function deleteUnsaveFile($fileAbsoultePath) {
	if(is_array($fileAbsoultePath)) {

		foreach ($fileAbsoultePath as $file) {
			if (file_exists($file)) {
				unlink($file);
			} else {
				// File not found.
			}
		}
	} else {
		if (file_exists($fileAbsoultePath)) {
			unlink($fileAbsoultePath);
		} else {
			// File not found.
		}
	}

}
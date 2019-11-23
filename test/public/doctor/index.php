<?php include_once "../../init.php"; ?>
<?php if(isset($_SESSION['UserID'])): ?>
	<?php
		$actionName = basename(__FILE__, ".php");
		$baseName = basename(__DIR__);
		$allow = checkAccess();
	?>
	<?php if($allow): ?>
		<?php include_once "../templates/header.php"; ?>
		<?php
			include_once "../../sql.php";
			$selected = 'DoctorID, Professional, Name, ContactNo, Email';
			// Users.ProfileID as ProfileID'
			$tableHeader = ['DoctorID', 'Professional','Name', 'Contact No', 'Email' , 'Action'];
			$from = 'doctor';
			$join = ['LEFT JOIN'];
			$linkColumn = ['ProfileID'];
			$relationTable = ['profile'];
			$tableName = ['doctor'];
			$primaryKey = 'DoctorID';
		?>

		<?php include_once "../crudPhp/retrieve/getSearch.php"; ?>

		<?php
			$sqlKeyword = ' where '. $from .'.'. $primaryKey .'
			LIKE "'. $whereKeyword .'"
			OR ' . 'doctor.Professional LIKE "%'.$whereKeyword.'%"
			OR ' . 'profile.Email LIKE "%'.$whereKeyword.'%"
			OR ' . 'profile.Name LIKE "%'.$whereKeyword.'%"
			OR ' . 'profile.ContactNo LIKE "%'.$whereKeyword.'%"
			';
			include_once "../crudPhp/retrieve/sqlIndex.php";
			$previousIncludeFilePath = __DIR__;
		?>
		<?php include_once "../crudPhp/index.php" ?>
	<?php else: ?>
		<?php include_once "../templates/permissionError.php"; ?>
	<?php endif; ?>
<?php else: ?>
	<script>
		window.location = ('<?= LOGIN ?>');
	</script>
<?php endif ?>
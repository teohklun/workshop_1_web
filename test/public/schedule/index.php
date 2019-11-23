<?php include_once "../../init.php"; ?>
<?php if(isset($_SESSION['UserID'])): ?>
	<?php
		$actionName = basename(__FILE__, ".php");
		$baseName = basename(__DIR__);
		$allow = checkaccess();
	?>
	<?php if($allow): ?>
		<?php include_once "../templates/header.php"; ?>
		<?php
			include_once "../../sql.php";
			$selected = 'ScheduleID, schedule.Date, schedule.StartTime, schedule.EndTime ,doctor.Professional, profile.Name';
			// Users.ProfileID as ProfileID'
			$tableHeader = ['ScheduleID', 'Date','StartTime', 'EndTime', 'Professional', 'Name', 'Action'];
			$from = 'schedule';
			$join = ['LEFT JOIN', 'LEFT JOIN'];
			$linkColumn = ['DoctorID', 'ProfileID'];
			$relationTable = ['doctor', 'profile'];
			$tableName = ['schedule', 'doctor'];
			$primaryKey = 'ScheduleID';
		?>

		<?php include_once "../crudPhp/retrieve/getSearch.php"; ?>

		<?php
			$sqlKeyword = ' where '. $from .'.'. $primaryKey .' LIKE "'. $whereKeyword .'"
			OR ' . 'doctor.Professional LIKE "%'.$whereKeyword.'%"
			OR ' . 'profile.Name LIKE "%'.$whereKeyword.'%"
			OR ' . ' (YEAR(schedule.Date) = "'.$whereKeyword.'" OR MONTH(schedule.Date) = "'.$whereKeyword.'" OR DAY(schedule.Date) = "'.$whereKeyword.'")
			';
			// OR ' . ' (Hour(schedule.StartTime) = "'.$whereKeyword.'" OR Minute(schedule.StartTime) = "'.$whereKeyword.'")
			// OR ' . ' (Hour(schedule.EndTime) = "'.$whereKeyword.'" OR Minute(schedule.EndTime) = "'.$whereKeyword.'")
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
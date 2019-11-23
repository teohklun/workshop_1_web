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
			$selected = 'AppointmentID, appointment.Time, appointment.EndTime ,schedule.Date, Remark ,Completed, TreatmentDesc, Price, profile.name ';
			// $selected = '*';
			// Users.ProfileID as ProfileID'
			$tableHeader = ['AppointmentID', 'Time', 'EndTime','Date', 'Remark', 'TreatmentDesc', 'Price', 'Name', 'Action'];
			$from = 'appointment';
			$join = ['LEFT JOIN', 'LEFT JOIN', 'LEFT JOIN'];
			$linkColumn = ['ScheduleID', 'PatientID', 'profileID'];
			$relationTable = ['schedule', 'patient', 'profile'];
			$tableName = ['appointment', 'appointment', 'patient'];
			$primaryKey = 'AppointmentID';

			$columnDoNotShowFroMSelected = ['Completed'];
		?>

		<?php include_once "../crudPhp/retrieve/getSearch.php"; ?>

		<?php
			$sqlKeyword = ' where '. $from .'.'. $primaryKey .'
			LIKE "'. $whereKeyword .'"
			OR ' . 'profile.Name LIKE "'.$whereKeyword.'"
			OR ' . 'appointment.Remark LIKE "%'.$whereKeyword.'%"
			OR ' . 'appointment.TreatmentDesc LIKE "%'.$whereKeyword.'%"
			OR ' . 'appointment.Price LIKE "%'.$whereKeyword.'%"
			';
			// OR ' . ' (YEAR(schedule.Date) = "'.$whereKeyword.'" OR MONTH(schedule.Date) = "'.$whereKeyword.'" OR DAY(schedule.Date) = "'.$whereKeyword.'")
			// OR ' . ' EXTRACT(HOUR FROM appointment.Time) = "'.$whereKeyword.'"
			// OR ' . ' EXTRACT(MINUTE FROM appointment.Time) = "'.$whereKeyword.'"
			// OR ' . ' EXTRACT(HOUR FROM appointment.EndTime) = "'.$whereKeyword.'"
			// OR ' . ' EXTRACT(MINUTE FROM appointment.EndTime) = "'.$whereKeyword.'"
			include_once "../crudPhp/retrieve/sqlIndex.php";
			$previousIncludeFilePath = __DIR__;
			$extraButton = [
				'button 1' => [
					'label' => 'Mark as Completed',
					'class' => 'mark-complete btn btn-primary generate-report',
					'showCondition' => 0,
					'showVariable' => 'Completed',
					'baseName' => $baseName,
					'action' => 'markComplete',
					'message' => 'Are you sure want to mark this record as Complete ? '
				],
				'button 2' => [
					'label' => 'Mark as Uncompleted',
					'class' => 'mark-uncomplete btn btn-primary generate-report',
					'showCondition' => 1,
					'showVariable' => 'Completed',
					'baseName' => $baseName,
					'action' => 'markUnComplete',
					'message' => 'Are you sure want to mark this record as Uncomplete ? '
				],
			];
		?>
		<?php include_once "../crudPhp/index.php" ?>

	<!-- dirty method	 -->
	<script>
		$('.mark-complete').on('click', function () {
			var url = $(this).attr('data-url');
			var id = $(this).attr('data-id');
			var confirmMessage = $(this).attr('data-message');
			$.ajax({
				url: url,
				method: 'post',
				data: {
					id: id,
				},
				dataType : 'json',
				success: function(response) {
					if(response.status == true) {
						alert(response.message);
							$('.mark-uncomplete[data-id='+id+']').removeClass('hidden');
							$('.mark-complete[data-id='+id+']').addClass('hidden');
					} else {
						alert(response.message);
					}
				},
				beforeSend:function(){
					return confirm(confirmMessage);
				},
			});

		});
		$('.mark-uncomplete').on('click', function () {
			var url = $(this).attr('data-url');
			var id = $(this).attr('data-id');
			var confirmMessage = $(this).attr('data-message');
			$.ajax({
				url: url,
				method: 'post',
				data: {
					id: id,
				},
				dataType : 'json',
				success: function(response) {
					if(response.status == true) {
						alert(response.message);
							$('.mark-complete[data-id='+id+']').removeClass('hidden');
							$('.mark-uncomplete[data-id='+id+']').addClass('hidden');
					} else {
						alert(response.message);
					}
				},
				beforeSend:function(){
					return confirm(confirmMessage);
				},
			});

		});

	</script>

	<?php else: ?>
		<?php include_once "../templates/permissionError.php"; ?>
	<?php endif; ?>
<?php else: ?>
	<script>
		window.location = ('<?= LOGIN ?>');
	</script>
<?php endif ?>
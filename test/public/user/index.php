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
			$selected = 'UserID, username, profile.name, profile.contactNo, profile.email, Type';
			// Users.ProfileID as ProfileID'
			$tableHeader = ['UserID', 'Username','Name', 'Contact No', 'Email' , 'Action'];
			$from = 'users';
			$join = ['LEFT JOIN'];
			$linkColumn = ['ProfileID'];
			$relationTable = ['profile'];
			$tableName = ['users'];
			$primaryKey = 'UserID';

			$columnDoNotShowFroMSelected = ['Type'];
		?>

		<?php include_once "../crudPhp/retrieve/getSearch.php"; ?>

		<?php
			$sqlKeyword = ' where '. $from .'.'. $primaryKey .'
			LIKE "'. $whereKeyword .'"
			OR ' . 'users.Username LIKE "%'.$whereKeyword.'%"
			OR ' . 'profile.Email LIKE "%'.$whereKeyword.'%"
			OR ' . 'profile.Name LIKE "%'.$whereKeyword.'%"
			OR ' . 'profile.ContactNo LIKE "%'.$whereKeyword.'%"
			';
			include_once "../crudPhp/retrieve/sqlIndex.php";
			$previousIncludeFilePath = __DIR__;

			$extraButton = [
				'button 1' => [
					'label' => 'Be Admin',
					'class' => 'be-admin btn btn-primary generate-report',
					'showCondition' => 0,
					'showVariable' => 'Type',
					'baseName' => $baseName,
					'action' => 'beAdmin',
					'message' => 'Are you sure want to mark this record as Complete ? '
				],
				'button 2' => [
					'label' => 'Be Staff',
					'class' => 'be-staff btn btn-primary generate-report',
					'showCondition' => 1,
					'showVariable' => 'Type',
					'baseName' => $baseName,
					'action' => 'beStaff',
					'message' => 'Are you sure want to mark this record as Uncomplete ? '
				],
			];

		?>
		<?php include_once "../crudPhp/index.php" ?>
			<!-- dirty method	 -->
	<script>
		$('.be-admin').on('click', function () {
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
							$('.be-staff[data-id='+id+']').removeClass('hidden');
							$('.be-admin[data-id='+id+']').addClass('hidden');
					} else {
						alert(response.message);
					}
				},
				beforeSend:function(){
					return confirm(confirmMessage);
				},
			});

		});
		$('.be-staff').on('click', function () {
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
						$('.be-admin[data-id='+id+']').removeClass('hidden');
						$('.be-staff[data-id='+id+']').addClass('hidden');
						if(id == <?= $_SESSION['UserID'] ?>) {
							window.location = ('<?= PATH_USER ?>');
						}
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
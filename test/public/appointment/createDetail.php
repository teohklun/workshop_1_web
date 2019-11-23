<?php include_once "../../init.php"; ?>
<?php if(isset($_SESSION['UserID'])): ?>
	<?php
		$actionName = basename(__FILE__, ".php");
		$baseName = basename(__DIR__);
		$allow = checkaccess();
	?>
<?php if($allow): ?>
    <?php
        include "../templates/header.php";
        include "../../sql.php";

        include "sql/initSqlConnection.php";

        $subTittle = 'Appointment detail ' . ucfirst($baseName);
        $action = 'createDetail';
        $succesfulMessage = 'Successfully created a '. $baseName;

        if(isset($_GET)) {
            if(isset($_GET['ScheduleID'])) {
                $scheduleID = $_GET['ScheduleID'];
                $previousIncludeFilePath = __DIR__;
                $selected = null;

                $sql = 'select * from schedule where scheduleID = ?
                and schedule.StartTime <= ?
                and schedule.EndTime >= ?
                ';
                $objectArray =[
                    $scheduleID,
                    $_GET['Time'],
                    date('H:i:s', strtotime('+ '. $_GET['Duration'], strtotime($_GET['Time'])))
                ];
                $statement = $connection->prepare($sql);
                $statement->execute($objectArray);
                $result = $statement->fetch(PDO::FETCH_ASSOC);

                if(!$result) {
                    $errMessage = 'The ID not exist in the database.';
                    include "../templates/error.php";
                } else {
                    // return view
                    if (isset($_POST['submit'])) {
                        include "submit/submit.php";
                    } else {
                        include "../crudPhp/form/initFormField.php";
                    }
                    include "detailForm.php";
                }
            }
        }
    ?>
<?php else: ?>
    <?php include_once "../templates/permissionError.php"; ?>
<?php endif; ?>
<?php else: ?>
<script>
window.location = ('<?= LOGIN ?>');
</script>
<?php endif ?>
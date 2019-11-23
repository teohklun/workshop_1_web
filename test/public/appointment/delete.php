<?php include_once "../../init.php"; ?>
<?php if(isset($_SESSION['UserID'])): ?>
	<?php
		$actionName = basename(__FILE__, ".php");
		$baseName = basename(__DIR__);
		$allow = checkaccess();
	?>
<?php if($allow): ?>
    <?php
    include_once "../../sql.php";
    include_once "sql/initSqlConnection.php";

    $baseName = basename(__DIR__);
    $action = 'delete';
    $status = true;
    $jsonMessage = 'Successfully Deleted a '.$baseName;
    if(isset($_POST)) {
        if(isset($_POST['id'])) {
            if (null !== ($paramID = filter_input(INPUT_GET, 'paramID', FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE))) {
                $paramID = $_POST['id'];
                $previousIncludeFilePath = __DIR__;
                include "../crudPhp/form/sql/retrieveRecordWithPrimaryID.php";

                if(count($result) == 0) {
                    $errMessage = 'The ID not exist in the database.';
                    include "../templates/error.php";
                } else {
                    // return view
                    try {

                        $sql = 'select * from appointment where AppointmentID = ?';
                        $statement = $connection->prepare($sql);
                        $statement->execute([$paramID]);
		                $result  = $statement->fetch(PDO::FETCH_ASSOC);

                        $usedSlot = getAvailableSlotFromTwoDateTime($result['Date'] . ' ' . $result['Time'], $result['Date'] . ' ' . $result['EndTime']);
                        $newObjectArray = [
                          $usedSlot  , $result['ScheduleID']
                        ];

                        $sql = 'update schedule set SlotAvailable = SlotAvailable + ? where ScheduleID = ?';
                        $statement = $connection->prepare($sql);
                        $statement->execute($newObjectArray);

                        include "../crudPhp/delete/sqlDelete.php";
                    } catch(PDOException $error) {
                        $jsonMessage = $sql . "<br>" . $error->getMessage(); 
                        $status = false;
                        // echo $sql . "<br>" . $error->getMessage();
                    }
                    header('Content-type: application/json');
                    $response = [
                        'status' => $status,
                        'message' => $jsonMessage
                    ];
                    echo json_encode($response);
                }
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

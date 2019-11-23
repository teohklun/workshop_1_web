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

        $selected = 'doctor.DoctorID, profile.Name, Professional ';
        include "../doctor/sql/initSqlConnection.php";
        // $sql .= ' where '.$relationTable.'.'.$linkColumn.' = '.$paramID.'';
        $statement = $connection->prepare($sql);
        $statement->execute();
        $arrayResultDoctorWithName = $statement->fetchAll(PDO::FETCH_ASSOC);

        $subTittle = 'Edit ' . ucfirst($baseName);
        $action = 'edit';
        $succesfulMessage = 'Successfully Updated a '. $baseName;

        if(isset($_GET)) {
            if(isset($_GET['id'])) {
                if (null !== ($paramID = filter_input(INPUT_GET, 'paramID', FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE))) {
                    $paramID = $_GET['id'];
                    $previousIncludeFilePath = __DIR__;
                    $selected = null;
                    $sql = 'select schedule.Date, appointment.AppointmentID, appointment.PatientID, appointment.Time,
                    appointment.EndTime, appointment.Remark,appointment.TreatmentDesc, appointment.Price, appointment.CreatedBy,
                    appointment.ScheduleID, appointment.Completed,
                    schedule.StartTime as SStartTime, schedule.EndTime as SEndTime
                    from appointment 
                    left join schedule on appointment.ScheduleID = schedule.ScheduleID
                    left join patient on patient.PatientID = appointment.PatientID
                    where AppointmentID = ?';
                    $statement = $connection->prepare($sql);
                    $statement->execute([$paramID]);
                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    if(count($result) == 0) {
                        $errMessage = 'The ID not exist in the database.';
                        include "../templates/error.php";
                    } else {
                        // return view
                        if (isset($_POST['submit'])) {
                            $inputDate = $result['Date'];
                            $inputTime = $_POST['Time'];
                            $inputDuration = $_POST['Duration'] * 15 . ' minutes';
                            $inputDateTime = $inputDate . ' ' . $inputTime;
                    
                            if(!isset($inputDateTimeAddDuration)) {
                              $inputDateTimeAddDuration = strtotime("+ " . $inputDuration, strtotime($inputDateTime));
                              $inputTimeAddDuration = date('H:i:s', $inputDateTimeAddDuration);
                            }

                            $sql = 'select scheduleID
                            from schedule
                            where StartTime < "'.$_POST['Time'].'" 
                            and EndTime > "'.$_POST['Time'].'" 
                            and EndTime >= "'.$inputTimeAddDuration.'" 
                            and StartTime < "'.$inputTimeAddDuration.'"
                            and ScheduleID = (select ScheduleID from appointment where appointmentID = "'.$paramID.'")
                            ';
                            $statement = $connection->prepare($sql);
                            $statement->execute();
                            $resultSchedule = $statement->fetch(PDO::FETCH_ASSOC);
                            if(!$resultSchedule) {
                                $errMessage = 'Schedule not found with such Start and endTime';
                            }

                            if (!$resultSchedule) {
                                $_POST['EndTime'] = $inputTimeAddDuration;
                            }
                            include "submit/submit.php";

                        } else {
                            include "../crudPhp/form/initFormField.php";
                        }

                        include "editForm.php";
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
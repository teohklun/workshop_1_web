<?php include_once "sql/getExistedAppointment.php"; ?>
<?php
  // init data
  $validation = true;
  if(!isset($errMessage)) {
    $errMessage = '';
  }
  $parameterError = false;
  include "../crudPhp/form/initFormField.php";
    do {
      $validateClient = true;
      include "../templates/validation/validateClientInput.php";
      if(isset($_POST, $_POST['Time'], $_POST['Duration'], $_POST['ScheduleID'])) {
        if($scheduleID = filter_input(INPUT_POST, 'ScheduleID', FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE)) {
          $sql = 'select * from schedule where ScheduleID =' . $scheduleID;
          $statement = $connection->prepare($sql);
          $statement->execute();
          $resultSchedule = $statement->fetch(PDO::FETCH_ASSOC);
          if(!$resultSchedule) {
            $errMessage .= 'Schedule not exist.';
          }
        } else {
          $parameterError = true;
          $errMessage = 'Parameter for scheduleID failed.';
        }
        if(!$parameterError && $validateClient) {

          $inputDate = $resultSchedule['Date'];
          $inputTime = $_POST['Time'];
          $inputDuration = $_POST['Duration'];
          $inputDateTime = $inputDate . ' ' . $inputTime;
  
          if(!isset($inputDateTimeAddDuration)) {
            $inputDateTimeAddDuration = strtotime("+ " . $inputDuration, strtotime($inputDateTime));
            $inputTimeAddDuration = date('H:i:s', $inputDateTimeAddDuration);
          }
          $resultAppointment = getExistedAppointment($inputDate, $inputTime, $inputTimeAddDuration, isset($paramID) ? $paramID : false);
          if($resultAppointment) {
            $errMessage .= 
            '</br>The following appointment crash with the current input<br>' .
            'Appointment ID: ' . $resultAppointment['AppointmentID'] . '</br>' .
            'Date : ' . $resultAppointment['Date'] . '</br>' .
            'Time : ' . $resultAppointment['Time'] . '</br>' .
            'EndTime : ' . $resultAppointment['EndTime'] . '</br>';
          }
          unset($inputDateTime);
          unset($inputDateAddDuration);
          unset($inputDateTimeAddDuration);
        }
      }

      if($errMessage !== '') {
        $validation = false;
        produceSessionMessage();
        break;
      }
      
      //init data for db connection
      if($validation) {
        try  {
          include "sql/initSqlConnection.php";
          include "sql/$action.php";
        } catch(PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
        produceSessionMessage();
        unsetSubmittedData();
      }

} while (0);
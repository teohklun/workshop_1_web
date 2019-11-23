<?php
  // init data
  $validation = true;
  $errMessage = '';

  include "../crudPhp/form/initFormField.php";

    do {
      $basicClientValidation = true;

      // validation without database
      include "../templates/validation/validateClientInput.php";

      if($errMessage !== '') {
        $basicClientValidation = false;
      }

      if($basicClientValidation) {

        $doctorIDs = [];
        foreach ($arrayResultDoctorWithName as $key => $resultDoctorWithName) {
          foreach ($resultDoctorWithName as $columnName => $value) {
            if($columnName === 'DoctorID') {
              $doctorIDs[] = $value;
            }
          }
        }

        //validate exist
        $selected = 'schedule.ScheduleID, doctor.DoctorID, schedule.Date, schedule.StartTime, schedule.EndTime';
        include "sql/initSqlConnection.php";
        if(isset($paramID)) {
          $sql.= ' where ScheduleID <> ' . $paramID ;
        }
        $statement = $connection->prepare($sql);
        $statement->execute();
        $arrayResultOfSchedule = $statement->fetchAll(PDO::FETCH_ASSOC);

        $startTime = $input['StartTime'];
        $endTime = $input['EndTime'];
        $date = $input['Date'];
        $date = date("Y-m-d", strtotime($date));

        if($startTime > $endTime) {
          $errMessage .= 'StartTime can not be less than end time.';
        }

        $slot = getAvailableSlotFromTwoDateTime($input['Date'] . " " . $input['StartTime'], $input['Date'] . " " . $input['EndTime']);
        if($slot < 1) {
          $errMessage .= '</br> The time interval is not enough to create a at least 15 minutes time slot for appointment.';
        }

        $doctorID = $input['DoctorID'];
        if(!in_array($_POST['DoctorID'], $doctorIDs)) {
          $errMessage .= 'DoctorID does not exist, please contact admin for further information.';
        }
        foreach ($arrayResultOfSchedule as $key => $schedule) {
          
          if($doctorID === $schedule['DoctorID']) {
            if($date == $schedule['Date']) {
              if($startTime >= $schedule['StartTime'] && $endTime <= $schedule['EndTime'] ) {
                $errMessage .= '</br> The input time is crashed with database time Date :' . $schedule['Date'] . ' time ' . $schedule['StartTime'] . ' - ' . $schedule['EndTime'];
                //input time inside middle
                break;
              }
              if($startTime <= $schedule['StartTime'] && $endTime >= $schedule['EndTime'] ) {
                $errMessage .= '</br> The input time is crashed with database time Date :' . $schedule['Date'] . ' time ' . $schedule['StartTime'] . ' - ' . $schedule['EndTime'];
                //input time inside middle
                break;
              }
              if($startTime >= $schedule['StartTime'] && $startTime <= $schedule['EndTime'] ) {
                $errMessage .= '</br> The input time is crashed with database time Date :' . $schedule['Date'] . ' time ' . $schedule['StartTime'] . ' - ' . $schedule['EndTime'];
                //input time inside middle
                break;
              }
              if($endTime >= $schedule['StartTime'] && $endTime <= $schedule['EndTime'] ) {
                $errMessage .= '</br> The input time is crashed with database time Date :' . $schedule['Date'] . ' time ' . $schedule['StartTime'] . ' - ' . $schedule['EndTime'];
                //input time inside middle
                break;
              }
            }
          }
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
            $errMessage .= $sql . "<br>" . $error->getMessage();
          }
        produceSessionMessage();
        unsetSubmittedData();
      }

} while (0);
<?php 
    try  {
        // $input['Date'] = date("Y-m-d", strtotime($input['Date']));

        $inputDateTime = $resultSchedule['Date'] . ' ' . $input['Time'];
        $inputDateTimeAddDuration = strtotime("+ ".$input['Duration'], strtotime($inputDateTime));
        $inputTimeAddDuration = date('H:i:s', $inputDateTimeAddDuration);

        $newObjectArray = [
            "ScheduleID" => $input['ScheduleID'],
            "Price" => $input['Price'],
            "Time" => $input['Time'],
            "EndTime" => $inputTimeAddDuration,
            "Remark" => $input['Remark'],
            "TreatmentDesc" => $input['TreatmentDesc'],
            "PatientID" => $input['PatientID'],
            'CreatedBy' => $_SESSION['UserID'],
            'UpdatedBy' => $_SESSION['UserID'],
        ];

        $sql = getSqlInsertQueryString($tableName[0], $newObjectArray);
        $statement = $connection->prepare($sql);
        $statement->execute($newObjectArray);

        $usedSlot = getAvailableSlotFromTwoDateTime($inputDateTime, date('Y-m-d H:i:s', $inputDateTimeAddDuration));

        $newObjectArray = [
            $usedSlot, $input['ScheduleID']
        ];

        $appointmentID = $connection->lastInsertId();
        $sql = 'update schedule set slotAvailable = slotAvailable - ? where ScheduleID = ?';
        $statement = $connection->prepare($sql);
        $statement->execute($newObjectArray);

        $sql = 'select appointment.Date, appointment.Time, appointment.EndTime, profile.Name
        from appointment
        left join patient on patient.PatientID = appointment.AppointmentID
        left join profile on patient.ProfileID = profile.ProfileID
        where AppointmentID =' . $appointmentID ;
        $statement = $connection->prepare($sql);
        $statement->execute();
		$insertedResult  = $statement->fetch(PDO::FETCH_ASSOC);
        $successMessage = 'Date : ' . $insertedResult['Date'] . '<br/>' .
        'Start Time : ' .  $insertedResult['Time'] . '</br>' .
        'End Time : ' . $insertedResult['EndTime'] . '</br>' .
        'Patient Name : ' . $insertedResult['Name'] . '</br>'.
        $successMessage ;
    } catch(PDOException $error) {
        $dbAction = false;
        echo $sql . "<br>" . $error->getMessage();
    }
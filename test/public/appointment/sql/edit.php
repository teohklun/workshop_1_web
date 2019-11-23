<?php

try  {
    $inputDuration = $input['Duration'] * 15 .' minutes';
    $originalSlot = getAvailableSlotFromTwoDateTime($result['Date'] . " " . $result['Time'],
        $result['Date'] . " " . $result['EndTime']);
    
    $newObjectArray = [
        $input['Time'],
        date('H:i:s', strtotime('+ ' . $inputDuration, strtotime($input['Time']))) ,
        $input['Remark'],
        $input['TreatmentDesc'],
        $input['Price'],
        $input['PatientID'],
        $_SESSION['UserID']
    ];

    $sql = "UPDATE ". $from ." ". $from ."
    inner join patient on patient.PatientID = appointment.PatientID
    inner join profile on profile.ProfileID = patient.ProfileID
    inner join schedule on schedule.ScheduleID = appointment.ScheduleID
    SET 
      appointment.Time = ? ,
      appointment.EndTime = ?,
      appointment.Remark = ?,
      appointment.TreatmentDesc = ?,
      appointment.Price = ?,
      appointment.UpdatedAt = ?,
      appointment.UpdatedBy = ?
    WHERE ".$primaryKey." = ".$paramID."";

    $statement = $connection->prepare($sql);
    $statement->execute($newObjectArray);

    $input['EndTime'] = date('H:i:s', strtotime('+ ' . $inputDuration, strtotime($input['Time'])));
    $slotOfNewAppointment = getAvailableSlotFromTwoDateTime($result['Date'] . " " . $input['Time'],
        $result['Date'] . " " . $input['EndTime']);
    $newSlot = $originalSlot - $slotOfNewAppointment;
    if($newSlot == 0) {
        // ntg happen to slot
        $operator = '-'; // no diff with operator since -0 still no changes
    } elseif($newSlot > 0) {
        //add
        $operator = '+';

    } elseif($newSlot < 0) {
        //-
        $operator = '-';
        $newSlot *= -1;
    }

    $sql = 'update schedule 
    set schedule.SlotAvailable = SlotAvailable ';
    $sql .= ' '. $operator;
    $newObjectArray = [
        $newSlot,
        $result['ScheduleID']
    ];
    $sql .= ' ? where scheduleID = ?';
    $statement = $connection->prepare($sql);
    $statement->execute($newObjectArray);
    
} catch(PDOException $error) {
    $dbAction = false;
    echo $sql . "<br>" . $error->getMessage();
}
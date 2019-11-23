<?php include_once "../appointment/sql/getExistedAppointment.php"; ?>
<?php

try  {
    $sql = '
    select AppointmentID, appointment.EndTime, appointment.Time, profile.Name
    from appointment
    left join schedule on schedule.ScheduleID = appointment.ScheduleID
    left join patient on patient.PatientID = appointment.PatientID
    left join profile on patient.ProfileID = profile.ProfileID
    where schedule.ScheduleID = ?
    and appointment.Time > ?
    OR schedule.ScheduleID = ?
    and appointment.EndTime > ?
    ';
    $statement = $connection->prepare($sql);
    $statement->execute([
        $paramID,
        $input['StartTime'],
        $paramID,
        $input['EndTime'],
      ]);
    $crashedAppointments = $statement->fetchAll(PDO::FETCH_ASSOC);

    if(!$crashedAppointments) {

        $sql = "UPDATE ". $from ." ". $from ."
        inner join doctor doctor on doctor.DoctorID = schedule.DoctorID
        inner join profile profile on profile.ProfileID = doctor.ProfileID
        SET 
        StartTime = :StartTime,
        EndTime = :EndTime,
        Date = :Date,
        SlotAvailable = ". floor($slot) . ",
        schedule.DoctorID = :DoctorID,
        schedule.UpdatedAt = CURRENT_TIMESTAMP,
        schedule.UpdatedBy = :UpdatedBy
        WHERE ".$primaryKey." = ".$paramID."";

        $statement = $connection->prepare($sql);
        $input['UpdatedBy'] = $_SESSION['UserID'];
        $statement->execute($input);
    } else {
        $validation = false;
        $errMessage = 'Failed the update is terminated. The update of schedule will effect the following Appointments. <br/>';
        foreach ($crashedAppointments as $key => $value) {
            $errMessage .= 'AppointmentID : ' . $value['AppointmentID'] . '<br/>' .
            'StartTime : ' . $value['Time'] . '<br/>' .
            'EndTime : ' . $value['EndTime'] . '<br/>' .
            'Patient Name : ' . $value['Name'] . '<br/>';
        }
        include "../crudPhp/form/initFormField.php";
    }

} catch(PDOException $error) {
    $dbAction = false;
    echo $sql . "<br>" . $error->getMessage();
}
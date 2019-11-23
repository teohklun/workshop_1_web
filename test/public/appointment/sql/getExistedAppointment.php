<?php 
function getExistedAppointment ($date, $startTime, $endTime, $paramID = null, $all = false) {
    $sql = '
    select appointment.AppointmentID, schedule.Date, appointment.Time, appointment.EndTime, appointment.ScheduleID
    from appointment
    left join schedule on schedule.ScheduleID = appointment.ScheduleID
    left join patient on patient.PatientID = appointment.PatientID
    ';
    // 1.)                     
    // db   :   |-----|
    // input:      |------|
    // OR
    // db   :   |-------------|
    // input:      |------|

    // 2.)
    // db   :   |-------------|
    // input:      |-------|
    // OR
    // db   :       |----------|
    // input:    |----------|

    // 3.)
    // db   :       |------|
    // input:    |------------|
    $sql .= ' 
    where 
    schedule.Date = ?
    and appointment.Time <= ?
    and appointment.EndTime >= ?
    OR
    schedule.Date = ?
    and appointment.Time <= ?
    and appointment.EndTime >= ?
    OR 
    schedule.Date = ?
    and appointment.Time >= ?
    and appointment.EndTime <= ?
    ';

    if(isset($paramID) && $paramID != false) {
        $sql .= ' and AppointmentID != ' . $paramID;
    }
    $objectArray = [
        $date,
        $startTime,
        $startTime,
        $date,
        $endTime,
        $endTime,
        $date,
        $startTime,
        $endTime,
    ];
    global $connection;
    $statement = $connection->prepare($sql);
    $statement->execute($objectArray);
    if($all) {
        $resultAppointment = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultAppointment = $statement->fetch(PDO::FETCH_ASSOC);
    }
    return $resultAppointment;
}

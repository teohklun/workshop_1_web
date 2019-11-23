<?php include_once "../../init.php"; ?>
<?php include_once "sql/getExistedAppointment.php"; ?>
<?php
    $connection = new PDO($dsn, $dbUsername, $dbPassword, $options);
    $invalid = false;
    if($_GET) {
        $inputDate = $_GET['date'];
        $inputDate = date('Y-m-d', strtotime($inputDate));
        $inputTime = $_GET['time'];
        if(isset($_GET['duration']) && $_GET['duration'] !== 'null') {
            $inputDuration = $_GET['duration'] * 15;
            $inputDuration = $inputDuration . ' minutes';
        } else {
            $inputduration = '15 minutes';
        }
    }
    if(isset($inputTime)) {
        
        $inputDateTime = $inputDate . ' ' . $inputTime;
        // $timestampInputDatetime = date('Y-m-d H:i:s', strtotime($inputDateTime));
        $inputDateTimeAddDuration = strtotime("+ " . $inputDuration, strtotime($inputDateTime));
        $inputTimeAddDuration = date('H:i:s', $inputDateTimeAddDuration);
        $inputDateAddDuration = date('Y-m-d', $inputDateTimeAddDuration);
        
        if($inputDateAddDuration != $inputDate) {
            $invalid = true;
        }
    }

    $sql = '
    select ScheduleID, schedule.Date, StartTime, EndTime, profile.Name as Name, Professional, SlotAvailable
    from schedule
    left join doctor on schedule.DoctorID = doctor.DoctorID
    left join profile on doctor.ProfileID = profile.ProfileID
    ';

    if($_GET) {
        $sql.= ' 
        where Date = "'.$inputDate.'"
        and StartTime <= "'.$inputTime.'"
        and EndTime >= "'.$inputTime.'"
        and Endtime >= "'.$inputTimeAddDuration.'"
        ';
    }
    $statement = $connection->prepare($sql);
    $statement->execute();
    $resultSchedule = $statement->fetchAll(PDO::FETCH_ASSOC);

    $crashedAppointment = false;
    if($_GET) {
        $resultAppointments = getExistedAppointment($inputDate, $inputTime, $inputTimeAddDuration, true);
        $crashedScheduleWithTheTime = [];
        if($resultAppointments) {
            foreach ($resultAppointments as $column => $appointment) {
                if($column == 'ScheduleID') {
                    $crashedScheduleWithTheTime[] = $resultAppointments['ScheduleID'];
                }
            }
        }
    }
    ?>
<div id="scheduleList">

<?php if (!$crashedAppointment): ?>
<div style="overflow-x:auto;">
    <table class='grid-view'>
        <tbody>
        <tr>
            <th>Date</th>
            <th>StartTime</th>
            <th>EndTime</th>
            <th>Doctor Name</th>
            <th>Professional</th>
            <th>Check Time</th>
        </tr>
        <?php if(!$invalid):?>
            <?php foreach($resultSchedule as $index => $schedule): ?>
            <?php if(isset($inputDate) ? $inputDate === $schedule['Date'] : date('Y-m=d') == $schedule['Date']): ?>
                <tr>
                    <?php foreach($schedule as $index2 => $scheduleData): ?>
                    <?php if($index2 != 'ScheduleID' && $index2 != 'SlotAvailable'): ?>
                        <td><?= $scheduleData?></td>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <td>
                        <?php if($schedule['SlotAvailable'] >= $_GET['duration'] && in_array($schedule['ScheduleID'], $crashedScheduleWithTheTime)): ?>
                        <span>
                            The schedule is crashed with selected time
                        </span>
                        <?php elseif($schedule['SlotAvailable'] >= $_GET['duration']): ?>
                        <a class='btn btn-outline-info my-2 my-sm-0 width-100'href='createDetail.php?ScheduleID=<?= $schedule['ScheduleID'] ?>&Time=<?= $inputTime ?>&Duration=<?= $inputDuration ?>'   >
                            Make appointment
                        </a>
                        <?php else: ?>
                            <span>
                                Schedule full with appointment
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endif; ?>
            <?php endforeach; ?>
            <?php else: ?>
            not found
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
Date of this time and the duration is crashed.
<br/>
<?=
 'Appointment ID: ' . $resultAppointments['AppointmentID'] . '</br>' .
 'Date : ' . $resultAppointments['Date'] . '</br>' .
 'Time : ' . $resultAppointments['Time'] . '</br>' .
 'EndTime : ' . $resultAppointments['EndTime'] . '</br>';
?>
<?php endif;?>
</div>
<script>

</script>
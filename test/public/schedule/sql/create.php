<?php 
    try  {
        $newSchedule = [
            "Date" => $input['Date'],
            "StartTime" => $input['StartTime'],
            "EndTime" => $input['EndTime'],
            "DoctorID" => $input['DoctorID'],
            "slotAvailable" => $slot,
            'CreatedBy' => $_SESSION['UserID'],
            'UpdatedBy' => $_SESSION['UserID'],
        ];

        $sql = getSqlInsertQueryString($tableName[0], $newSchedule);
        $statement = $connection->prepare($sql);
        $statement->execute($newSchedule);
        $input = [];

    } catch(PDOException $error) {
        $dbAction = false;
        echo $sql . "<br>" . $error->getMessage();
    }
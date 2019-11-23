<?php include_once "../../init.php"; ?>
<?php
        include "sql/initSqlConnection.php";
		$actionName = basename(__FILE__, ".php");
		$baseName = basename(__DIR__);
        $allow = checkAccess();
        $subTittle = 'Date Report';
        $action = 'revenue';
        $filterInterval = 'DoctorID';
        $fixedGroup = 'Doctor';

        $sql = 'select doctor.DoctorID, profile.Name from 
        doctor
        left join profile on doctor.ProfileID = profile.ProfileID';
        $statement = $connection->prepare($sql);
		$statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $extraDropDown = [];
        $extraFilter = 'DoctorID';
        $extraFilterFor = 'doctor';

        $orderSum = 'ASC';

        $limitName = 'limit';
        $limit = 2;

        foreach ($result as $key => $value) {
            $extraDropDown[$value['Name'] . ' - ' . $value['DoctorID']] = $value['DoctorID'];
        }
        
        if(isset($_POST['submit'])) {
            include "../crudPhp/form/initFormField.php";
            if(isset($input)) {
                if(isset($input['Year']) && is_array($input['Year'])) {
                    if($input['Year'][0] !== '') {
                        $filterYear = $input['Year'];
                    }
                }
                if(isset($input['Month']) && is_array($input['Month'])) {
                    if($input['Month'][0] !== '') {
                        $filterMonth = $input['Month'];
                    }
                }
                if(isset($input['Day']) && is_array($input['Day'])) {
                    if($input['Day'][0] !== '') {
                    }
                }
                if(isset($input[$extraFilter]) && is_array($input[$extraFilter])) {
                    if($input[$extraFilter][0] !== '') {
                        $filterExtra = $input[$extraFilter];
                    }
                }
                if(isset($input[$limitName]) && $input[$limitName] !== '') {
                    $limit = $input[$limitName];
                }
                if(isset($input['orderSum']) && $input['orderSum'] !== '') {
                    $orderSum = $input['orderSum'];
                }
            }
        }

        $tableToGroupBy = "doctor.$filterInterval";
        $tableHeaderToGroupByIfNull = 'Total';
        $tableHeader = [ucfirst($filterInterval), 'Total Appointment', 'Total Price', 'Min Price', 'Max Price', 'Average Price'];

		$sql = "select 
        IFNULL($filterInterval, '".$tableHeaderToGroupByIfNull."'), count(*), sum(price) as 'sum', min(price) as 'min', max(price) as 'max', ROUND(avg(price),2) as 'avg'
        from 
        (
            select $tableToGroupBy as $filterInterval, price from
            appointment subAppointment
            left join schedule on schedule.ScheduleID = subAppointment.ScheduleID
            left join doctor on doctor.DoctorID = schedule.DoctorID
            left join patient on patient.PatientID = subAppointment.PatientID
            left join profile as profile_d on profile_d.ProfileID = doctor.ProfileID
            left join profile as profile_p on profile_p.ProfileID = patient.ProfileID
            left join address as address_d on address_d.AddressID = profile_d.AddressID
            left join address as address_p on address_p.AddressID = profile_p.AddressID
            where subAppointment.completed = 1
        ";
        $whereOnce =  false;
        if(isset($filterYear)) {
            $sql .= ' and Year(schedule.Date) in (' . implode(', ', $filterYear) .')';
            $whereOnce = true;
        }

        if(isset($filterMonth)) {
            $sql .= 'and' . ' ' . 'Month(schedule.Date) in (' . implode(', ', $filterMonth) .')';
        }

        if(isset($filterDay)) {
            $sql .= 'and' . ' ' . 'Day(schedule.Date) in (' . implode(', ', $filterDay) .')';
        }

        if(isset($filterExtra)) {
            $sql .= 'and' . ' ' . ''.$extraFilterFor. '.' .$extraFilter.' in (' . implode(', ', $filterExtra) .')';
        }

        // fill back the subQuery
        $sql .= ' )

        appointment';
        // alias of main query

        $sql .= "
        group by $filterInterval
        " ;
        $sql = '
            select * from (' . $sql . ') test 
            order by sum ' .$orderSum. '
            limit '. $limit . '
        ';
        $statement = $connection->prepare($sql);
		$statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if($result) {
            $result = createSummaryRowForSummaryResult($result);
        }
	?>,
<?php include_once "../templates/header.php"; ?>
<?php include_once "chart.php"; ?>

<?php include_once "../../init.php"; ?>
<?php
        include "sql/initSqlConnection.php";

		$actionName = basename(__FILE__, ".php");
		$baseName = basename(__DIR__);
        $allow = checkAccess();
        $subTittle = 'Date Report';
        $action = 'revenue';
        $filterInterval = 'year';
        
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
                        $filterDay = $input['Day'];
                    }
                }
                if(isset($input['Group']) && is_array($input['Group'])) {
                    if($input['Group'][0] !== '') {
                        $filterInterval = $input['Group'];
                    }
                } elseif(isset($input['Group']) && $input['Group'] !== '') {
                    $filterInterval = $input['Group'];
                }
            }
        }

        $tableToGroupBy = "$filterInterval(schedule.Date)";
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

        // fill back the subQuery
        $sql .= ' )

        appointment';
        // alias of main query

        $sql .= "
        group by $filterInterval
        WITH ROLLUP
        " ;
		$statement = $connection->prepare($sql);
		$statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
	?>
<?php include_once "../templates/header.php"; ?>
<?php include_once "chart.php"; ?>

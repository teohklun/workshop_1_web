<?php include_once "../../init.php"; ?>
<?php if(isset($_SESSION['UserID'])): ?>
	<?php
		$actionName = basename(__FILE__, ".php");
		$baseName = basename(__DIR__);
        $allow = checkAccess();
        $subTittle = 'Patient';
        $action = 'patient';
        $validation = true;
        $errMessage = '';
	?>
	<?php if($allow): ?>
        <?php include_once "../templates/header.php"; ?>
        
        <?php if (isset($_POST['submit'])) {
            do {
                include "../crudPhp/form/initFormField.php";
                //validation withouth database
                include "../templates/validation/validateClientInput.php";
                if($errMessage !== '') {
                    $validation = false;
                    produceSessionMessage();
                    break;
                }
                if($validation) {

                    include "sql/initSqlConnection.php";

                    try  {
                        $tableHeader = ['PatientID', 'Debt','UpdatedAt', 'CreatedAt', 'UpdatedBy', 'CreatedBy', 'ContactNo' , 'Name' ,'IC', 'Email'];

                        $createdAt =  explode(' - ', $input['CreatedAt']);
                        $sql = 'select patient.PatientID, patient.Debt, patient.UpdatedAt, patient.CreatedAt, patient.UpdatedBy, patient.CreatedBy, profile.ContactNo , profile.Name, profile.IC, profile.Email
                        from patient
                        left join profile on profile.ProfileID = patient.ProfileID
                        left join address on address.AddressID = profile.AddressID
                        ';
                        $first = true;
                        foreach ($input as $key => $value) {
                            if(!$first && $value != '') {
                                $sql .= 'and ';
                            } elseif($first && $value != '') {
                                $sql .= 'where ';
                                $first = false;
                            }
                            if($value != '') {
                                if($key === 'CreatedAt' || $key === 'UpdatedAt') {
                                    $string =  explode(' - ', $input[$key]);
                                    $sql .= "$key between  \"$string[0]\" and \"$string[1]\" ";
                                } else {
                                    $sql .= "$key like \"%$value%\"" ;
                                }
                            }
                        }
                        $statement = $connection->prepare($sql);
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        include_once "reportContent.php"; 
                
                    } catch(PDOException $error) {
                        $dbAction = false;
                        echo $sql . "<br>" . $error->getMessage();
                    }
                }
            }  while (0);
        }
            include_once "patientForm.php"; 
        ?>

	<?php else: ?>
		<?php include_once "../templates/permissionError.php"; ?>
	<?php endif; ?>
<?php else: ?>
	<script>
		window.location = ('<?= LOGIN ?>');
	</script>
<?php endif ?>
<?php include_once "../../init.php"; ?>
<?php if(isset($_SESSION['UserID'])): ?>
	<?php
		$actionName = basename(__FILE__, ".php");
		$baseName = basename(__DIR__);
		$allow = checkaccess();
	?>
<?php if($allow): ?>
    <?php
    include_once "../templates/header.php";
    include_once "../../sql.php";

    $selected = 'doctor.DoctorID, profile.Name, Professional ';
    $selected = '*';
    include "../doctor/sql/initSqlConnection.php";
    // $sql .= ' where '.$relationTable.'.'.$linkColumn.' = '.$paramID.'';
    $statement = $connection->prepare($sql);
    $statement->execute();
    $arrayResultDoctorWithName = $statement->fetchAll(PDO::FETCH_ASSOC);

    $baseName = basename(__DIR__);
    $subTittle = 'Add a ' . ucfirst($baseName);
    $action = 'create';
    $succesfulMessage = 'Successfully added a '. $baseName;

    if (isset($_POST['submit'])) {
        include_once "submit/submit.php";
    }
    ?>
<?php include "form.php" ?>
<?php else: ?>
    <?php include_once "../templates/permissionError.php"; ?>
<?php endif; ?>
<?php else: ?>
<script>
window.location = ('<?= LOGIN ?>');
</script>
<?php endif ?>

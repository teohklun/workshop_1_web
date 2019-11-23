<?php include_once "../../init.php"; ?>
<?php if(isset($_SESSION['UserID'])): ?>
	<?php
		$actionName = basename(__FILE__, ".php");
		$baseName = basename(__DIR__);
		$allow = checkAccess();
	?>
<?php if($allow): ?>
    <?php
        include "../templates/header.php";
        include "../../sql.php";

        $subTittle = 'Edit ' . ucfirst($baseName);
        $action = 'edit';
        $succesfulMessage = 'Successfully Updated a '. $baseName;

        if(isset($_GET)) {
            if(isset($_GET['id'])) {
                if (null !== ($paramID = filter_input(INPUT_GET, 'paramID', FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE))) {
                    $paramID = $_GET['id'];
                    $previousIncludeFilePath = __DIR__;
                    include "../crudPhp/form/sql/retrieveRecordWithPrimaryID.php";

                    if(count($result) == 0) {
                        $errMessage = 'The ID not exist in the database.';
                        include "../templates/error.php";
                    } else {
                        // return view
                        if (isset($_POST['submit'])) {
                            include "submit/submit.php";
                        } else {
                            include "../crudPhp/form/initFormField.php";
                            $input['Password'] = '';
                        }
                        include "form.php";
                    }
                }
            }
        }
    ?>
<?php else: ?>
    <?php include_once "../templates/permissionError.php"; ?>
<?php endif; ?>
<?php else: ?>
<script>
window.location = ('<?= LOGIN ?>');
</script>
<?php endif ?>
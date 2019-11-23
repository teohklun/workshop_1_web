<?php
    $selected = 'PatientID, profile.Name, profile.IC ';
    include "../patient/sql/initSqlConnection.php";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $arrayResultPatientWithIC = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<?php sessionMessage(); ?>
<script src="../assets/js/jquery-3.3.1.min.js"></script>
<script>
  $(".close").click(function() {
    this.closest('blockquote').remove();
  });
</script>

  <h2><?= $subTittle ?></h2>

  <script type="text/javascript" src="<?= ASSETS ?>/js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="<?= ASSETS ?>/plugins/select2/select2.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?= ASSETS ?>/plugins/select2/select2.min.css">
  
    <label for="notes"><span>*</span> means required field</label>
<div class='div-form'>
  <form id="crud-form" method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <input name="ScheduleID" type="hidden" value="<?= $_GET['ScheduleID'] ?>">
  <input name="Time" type="hidden" value="<?= $_GET['Time'] ?>">
  <input name="Duration" type="hidden" value="<?= $_GET['Duration'] ?>">

  <div class='form-row'>
    <div class="col-md-6 mb-3">
      <label for="Remark">Remark</label>
      <input type="text" class='form-control' name="Remark" id="Remark" value="<?= isset($input['Remark']) ? $input['Remark'] : '' ?>">
    </div>
    <div class="col-md-6 mb-3">
      <label for="TreatmentDesc">Treament Description</label>
      <input type="text" class='form-control' name="TreatmentDesc" id="TreatmentDesc" value="<?= isset($input['TreatmentDesc']) ? $input['TreatmentDesc'] : '' ?>">
    </div>
  </div>
  <div class='form-row'>
    <div class="col-md-6 mb-3">
      <label for="Price">Price</label>
      <input type="number" class='form-control' name="Price" id="Price" value="<?= isset($input['Price']) ? $input['Price'] : '' ?>">
    </div>

    <div class="col-md-6 mb-3">

      <label for="PatientID">PatientID</label>
      <select class="form-control select2-patient" name="PatientID" id="PatientID">
      <option readonly selected='<?= isset($input['PatientID']) ? '' : 'selected' ?>' value =''>--select a option--</option>
        <?php foreach($arrayResultPatientWithIC as $index => $resultPatientWithIC): ?>
            <option <?= isset($input['PatientID']) ? $input['PatientID'] : '' == $resultPatientWithIC['PatientID'] ?
            'selected' : '' ?> value="<?= $resultPatientWithIC['PatientID']; ?>">
            <?= $resultPatientWithIC['Name'] . ' - ' . $resultPatientWithIC['IC']; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <input class="btn btn-primary" type="submit" name="submit" value="Submit" >
  <a href="index.php" class="btn btn-warning">Back to index</a>
  </form>
</div>
<script>
$(document).ready(function() {
    $('.select2-patient').select2();
});
</script>
<?php include "../templates/footer.php"; ?>

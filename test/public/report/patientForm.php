<?php
  $connection = new PDO($dsn, $dbUsername, $dbPassword, $options);
  $sql = 'select UserID, users.Username from users';
  $statement = $connection->prepare($sql);
  $statement->execute();
  $arrayResultUser = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<?php sessionMessage(); ?>

<script src="../assets/js/jquery-3.3.1.min.js"></script>
<script>
  $(".close").click(function() {
    this.closest('blockquote').remove();
  });
</script>
<script type="text/javascript" src="<?= ASSETS ?>/js/moment.min.js"></script>

<div class="container-fluid">
  <label for="sub-title-label">Insert keyword about the data for filtering</label>
<div class="div-form">

  <form id="crud-form" method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">

      <div class="form-row">
        <div class="col-md-12 mb-3">
          <label for="Debt">Debt</label>
          <input class="form-control" type="text" name="Debt" id="Debt" value="<?= isset($input['Debt']) ? $input['Debt'] : '' ?>">
        </div>
      </div>

      <?php include 'sharedForm/profileForm.php' ?>
      <?php include 'sharedForm/addressForm.php' ?>

      <div class="form-row">
        <div class="col-md-3 mb-3">
          <label for="CreatedAt">CreatedAt</label>
          <input class="form-control date-time" type="text" name="CreatedAt" id="CreatedAt" value="<?= isset($input['CreatedAt']) ? $input['CreatedAt'] : null ?>">
        </div>
        <div class="col-md-3 mb-3">
          <label for="UpdatedAt">UpdateAt</label>
          <input class="form-control date-time" type="text" name="UpdatedAt" id="UpdatedAt" value="<?= isset($input['UpdatedAt']) ? $input['UpdatedAt'] : null ?>">
        </div>
        <div class="col-md-3 mb-3">
          <label for="CreatedBy">Created By<span><?= isFieldRequired('CreatedBy') == true ? ' *' : ''?></label>
          <select class="form-control select2"  name="CreatedBy" id="CreatedBy">
            <option readonly selected value=''> -- select an option -- </option>
            <?php foreach($arrayResultUser as $index => $resultUserWithName): ?>
                <option <?= (isset($input['CreatedBy']) ? $input['CreatedBy'] : '') == $resultUserWithName['UserID'] ?
                'selected' : '' ?> value="<?= $resultUserWithName['UserID']; ?>">
                <?= $resultUserWithName['Username'] . ' - ' . $resultUserWithName['UserID']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-3 mb-3">
          <label for="UpdatedBy">Updated By<span><?= isFieldRequired('UpdatedBy') == true ? ' *' : ''?></label>
          <select class="form-control select2"  name="UpdatedBy" id="UpdatedBy">
            <option readonly selected value=''> -- select an option -- </option>
            <?php foreach($arrayResultUser as $index => $resultUserWithName): ?>
                <option <?= (isset($input['UpdatedBy']) ? $input['UpdatedBy'] : '') == $resultUserWithName['UserID'] ?
                'selected' : '' ?> value="<?= $resultUserWithName['UserID']; ?>">
                <?= $resultUserWithName['Username'] . ' - ' . $resultUserWithName['UserID']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

    <input class="btn btn-primary" type="submit" name="submit" value="Submit" >
    <a href="index.php" class="btn btn-warning">Back to index</a>
  </form>
</div>

<script type="text/javascript" src="<?= PLUGINJS ?>/daterangepicker-master/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?= PLUGINJS ?>/daterangepicker-master/daterangepicker.css"" />
<script type="text/javascript" src="<?= ASSETS ?>/plugins/select2/select2.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= ASSETS ?>/plugins/select2/select2.min.css">
<script>
    $('.date-time').daterangepicker({
        singleDatePicker: false,
        showDropdowns: true,
        timePicker: true,
        locale: {
          format: 'YYYY-MM-DD HH:mm',
          cancelLabel: 'Clear'
      },
    ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
}, function(start, end, label) {
  console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
});
    $('input[name="CreatedAt"]').val('');
  $('input[name="CreatedAt"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });

  $('input[name="UpdatedAt"]').val('');
  $('input[name="UpdatedAt"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
</script>
<script>
$(document).ready(function() {
    $('.select2').select2();
});
</script>
<?php include "../templates/footer.php"; ?>
</div>
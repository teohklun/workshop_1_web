<?php
  $selected = 'DoctorID, profile.Name, Professional ';
  include "../doctor/sql/initSqlConnection.php";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $arrayResultDoctorWithName = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<?php sessionMessage(); ?>

<script src="../assets/js/jquery-3.3.1.min.js"></script>
<script>
  $(".close").click(function() {
    this.closest('blockquote').remove();
  });
</script>
<div class='container-fluid'>

  <h2><?= $subTittle ?></h2>

  <label for="notes"><span>*</span> means required field</label>
<div class="div-form">
  <form id="crud-form" method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <div class="form-row">
      <div class="col-md-6 mb-3">
        <label for="Date">Date<span><?= isFieldRequired('Date') == true ? ' *' : ''?></label>
        <input class="form-control date" type="text" name="Date" id="timepicker1"  value="<?= isset($input['Date']) ? $input['Date'] : '' ?>">
      </div>

      <div class="col-md-6 mb-3">
        <label for="DoctorID">Doctor<span><?= isFieldRequired('DoctorID') == true ? ' *' : ''?></label>
        <select class="form-control select2"  name="DoctorID" id="DoctorID">
          <option readonly selected value=''> -- select an option -- </option>
          <?php foreach($arrayResultDoctorWithName as $index => $resultDoctorWithName): ?>
              <option <?= (isset($input['DoctorID']) ? $input['DoctorID'] : '') == $resultDoctorWithName['DoctorID'] ?
              'selected' : '' ?> value="<?= $resultDoctorWithName['DoctorID']; ?>">
              <?= $resultDoctorWithName['Name'] . ' - ' . $resultDoctorWithName['Professional']; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="form-row">
      <div class="col-md-6 mb-3">
        <label for="StartTime">Start Time<span><?= isFieldRequired('StartTime') == true ? ' *' : ''?></label>
        <input class="form-control timepicker" type="text" name="StartTime" id="timepicker1"  value="<?= isset($input['StartTime']) ? $input['StartTime'] : '' ?>">
      </div>

      <div class="col-md-6 mb-3">
        <label for="EndTime">End Time<span><?= isFieldRequired('EndTime') == true ? ' *' : ''?></label>
        <input class="form-control timepicker" type="text" name="EndTime" id="EndTime"  value="<?= isset($input['EndTime']) ? $input['EndTime'] : '' ?>">
      </div>
    </div>

    <input class="btn btn-primary" type="submit" name="submit" value="Submit" >
    <a href="index.php" class="btn btn-warning">Back to index</a>
  </form>
  </div>
</div>

  <script type="text/javascript" src="<?= ASSETS ?>/js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="<?= ASSETS ?>/plugins/select2/select2.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?= ASSETS ?>/plugins/select2/select2.min.css">

<link href="<?= PLUGINJS ?>/material-time-picker/mdtimepicker.css" rel="stylesheet">
<script src="<?= PLUGINJS ?>/material-time-picker/mdtimepicker.js"></script>
<script>
$(document).ready(function() {
    $('.select2').select2();
});

$('.timepicker').mdtimepicker({
  // format of the time value (data-time attribute)
  timeFormat: 'hh:mm:ss.000',
  // format of the input value
  format: 'hh:mm:ss',     
  // theme of the timepicker
  // 'red', 'purple', 'indigo', 'teal', 'green'
  theme: 'indigo',       
  // determines if input is readonly
  readOnly: true,
  // determines if display value has zero padding for hour value less than 10 (i.e. 05:30 PM); 24-hour format has padding by default
  hourPadding: false    
});

</script>
<script type="text/javascript" src="<?= ASSETS ?>/js/moment.min.js"></script>
<script type="text/javascript" src="<?= PLUGINJS ?>/daterangepicker-master/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?= PLUGINJS ?>/daterangepicker-master/daterangepicker.css"" />
<script>
console.log('<?= isset($input['Date']) ? $input['Date'] : '' ?>');
    $('.date').daterangepicker({
    startDate: '<?= isset($input['Date']) ? $input['Date'] : date('Y-m-d') ?>',
    endDate: '<?= isset($input['Date']) ? $input['Date'] : date('Y-m-d') ?>',
    singleDatePicker: true,
    showDropdowns: true,
    locale: {
      format: 'YYYY-MM-DD'
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
</script>
<?php include "../templates/footer.php"; ?>

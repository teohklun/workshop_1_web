  <?php
    $selected = 'DoctorID, profile.Name, Professional ';
    include "../doctor/sql/initSqlConnection.php";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $arrayResultDoctorWithName = $statement->fetchAll(PDO::FETCH_ASSOC);

    $sql = '
    select Date, StartTime, EndTime, profile.Name as Name, doctor.Professional
    from schedule
    left join doctor on schedule.DoctorID = doctor.DoctorID
    left join profile on doctor.ProfileID = profile.ProfileID
    ';
    $statement = $connection->prepare($sql);
    $statement->execute();
    $resultSchedule = $statement->fetchAll(PDO::FETCH_ASSOC);
  ?>
  
  <?php if(isset($_POST['submit']) && !$validation):?>
      <blockquote class='error-message'> <?= $errMessage ?> </blockquote>
  <?php elseif (isset($dbAction) && $dbAction) : ?>
      <blockquote><?php ?> <?= $succesfulMessage ?></blockquote>
  <?php else: ?>
  <?php endif; ?>
<div class='container-fluid'>

  <h2><?= $subTittle ?></h2>

<label for="notes"><span>*</span> means required field</label>
  <div class='div-form'>
      <div class='form-row'>
          <div class="col-md-6 mb-3">
            <label for="Date">Date<span><?= isFieldRequired('Date') == true ? ' *' : ''?></label>
            <input type="text" name="Date" id="Date" class='form-control date' value=<?= isset($input) ? $input['Date'] : date('Y-m-d') ?>>
          </div>
          <div class="col-md-6 mb-3">
            <label for="time">Time<span><?= isFieldRequired('Time') == true ? ' *' : ''?></label>
            <input type="text" name="timepicker" id="timepicker" class='form-control timepicker' value=<?= isset($input) ? $input['Time'] : '' ?>>
          </div>
      </div>
      
      <div class='form-row'>
          <div class="col-md-12 mb-3">
          <label id="label-duration" class ="hidden" for="Duration">Duration<span><?= isFieldRequired('Duration') == true ? ' *' : ''?></label>
          <select class ="form-control hidden" disabled required name="Duration" id="duration">
            <option disabled selected value> -- select an option -- </option>
            <option value =1>15 minutes</option>
            <option value =2>30 minutes</option>
            <option value =4>1 hour</option>
          </select>
        </div>
      </div>

      <?php include '_scheduleList.php' ?>
    <br/>
    <a href="index.php" class="btn btn-warning">Back to index</a>
</div>

<script type="text/javascript" src="<?= ASSETS ?>/js/jquery-3.3.1.min.js"></script>


<link href="<?= PLUGINJS ?>/material-time-picker/mdtimepicker.css" rel="stylesheet">
<script src="<?= PLUGINJS ?>/material-time-picker/mdtimepicker.js"></script>
<script>

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
  $('.date').daterangepicker({
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
    "startDate": new Date(),
    "endDate": new Date(),
  }, function(start, end, label) {

    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
    if($("#duration").val() !== null) {
      triggerAjax();
    }
  });

  $('#timepicker').change(function(){
    $("#duration").attr("disabled", false);
    $("#label-duration").removeClass("hidden");
    $("#duration").removeClass("hidden");
    if($("#duration").val() !== null) {
      triggerAjax();
    }
  });

  $('#duration').change(function(){
    var duration = $("#duration").val();
    triggerAjax();
  });

  function triggerAjax() {
    var time = $("#timepicker").val();
    var duration = $("#duration").val();
    var date = $('.date').data('daterangepicker').startDate.format('YYYY-MM-DD');
    $.get("_scheduleList.php?date="+ date + '&time=' + time + '&duration=' + duration, function(data){
      $("#scheduleList").html(data)
    });
  }

</script>
</div>
<?php include "../templates/footer.php"; ?>

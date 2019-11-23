<?php
    $selected = 'PatientID, profile.Name, profile.IC ';
    include "../patient/sql/initSqlConnection.php";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $arrayResultPatientWithIC = $statement->fetchAll(PDO::FETCH_ASSOC);
    if($input['EndTime']) {
      $endTime = $input['EndTime'];
    } else {
      $endTime = $result['EndTime'];
    }
    $time = $result['Time'];
    $durationValue = floor((strtotime($endTime) - strtotime($time))/ 60 / 15);
  ?>
  <?php sessionMessage(); ?>
  <h2><?= $subTittle ?></h2>
<div class='div-form'>
  <form id="crud-form" method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <blockquote class='info-message'>
      <div style='color:grey;'>
          Schedule Date : <?= $result['Date'] ?>
          <br/>
          Schedule Start Time : <?= $result['SStartTime'] ?>
          <br/>
          Schedule End Time : <?= $result['SEndTime'] ?>
          <br/>
      </div>
    </blockquote>
    <script type="text/javascript" src="<?= ASSETS ?>/js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="<?= ASSETS ?>/plugins/select2/select2.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?= ASSETS ?>/plugins/select2/select2.min.css">

    <label for="notes"><span>*</span> means required field</label>
    <div class='form-row'>
      <div class="col-md-6 mb-3">
        <label for="Date">Date</label>
        <input disabled  type="text" name="Date" id="Date" class='form-control date' value=<?= isset($result) ? $result['Date'] : date('Y-m-d') ?>>
      </div>
      <div class="col-md-6 mb-3">
        <label for="EndTime">Time</label>
        <input disabled id='EndTime' type="text" name="EndTime" id="EndTime"  class='form-control timepicker' value=<?= isset($input) ? $input['EndTime'] : '' ?>>
      </div>
    </div>
    <div class='form-row'>
      <div class="col-md-6 mb-3">
        <label for="time">Time</label>
        <input  type="text" name="Time" id="StartTime" class='form-control timepicker' value=<?= isset($input) ? $input['Time'] : '' ?>>
      </div>

      <div class="col-md-6 mb-3">
        <label id="label-duration" class ="" for="Duration">Duration</label>
        <select class='form-control' date-id=0 class =""  name="Duration" id="Duration">
          <option disabled selected value> -- select an option -- </option>
          <option <?= $durationValue == 1 ? 'selected' : '' ?> value =1>15 minutes</option>
          <option <?= $durationValue == 2 ? 'selected' : '' ?> value =2>30 minutes</option>
          <option <?= $durationValue == 4 ? 'selected' : '' ?> value =4>1 hour</option>
        </select>
      </div>
    </div>
    <div class='form-row'>
      <div class="col-md-6 mb-3">
        <label for="Remark">Remark</label>
        <input class='form-control' type="text" name="Remark" id="Remark" value="<?= isset($input['Remark']) ? $input['Remark'] : '' ?>">
      </div>
      <div class="col-md-6 mb-3">
        <label for="TreatmentDesc">Treament Description</label>
        <input class='form-control' type="text" name="TreatmentDesc" id="TreatmentDesc"  value="<?= isset($input['TreatmentDesc']) ? $input['TreatmentDesc'] : '' ?>">
      </div>
    </div>
    <div class='form-row'>
      <div class="col-md-6 mb-3">
        <label for="Price">Price</label>
        <input class='form-control' type="number" name="Price" id="Price"  value="<?= isset($input['Price']) ? $input['Price'] : '' ?>">
      </div>

      <div class="col-md-6 mb-3">
        <label for="PatientID">PatientID</label>
        <select  class="form-control select2-patient" name="PatientID" id="PatientID">
        <option disabled selected='' value =''>--select a option--</option>
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
    <div class="btn btn-primary mark-complete <?= $result['Completed'] == 1 ? 'hidden' : '' ?>"
      data-id='<?= $result['AppointmentID'] ?>' 
      data-message='Are you sure want to mark this appointment as Complete ?'
      data-url='/test/public/appointment/markComplete.php'>
      Mark Complete
    </div>
    <div class="btn btn-primary mark-uncomplete <?= $result['Completed'] == 0 ? 'hidden' : '' ?>"
      data-id='<?= $result['AppointmentID'] ?>' 
      data-message='Are you sure want to mark this appointment as Uncomplete ?'
      data-url='/test/public/appointment/markUnComplete.php'>
      Mark Uncomplete
    </div>
    <div class='btn btn-info generate-report float-right' id='generate-receipt'>
        Print Receipt
    </div>
</div>
<script type="text/javascript" src="<?= PLUGINJS ?>/print-js/print.min.js"></script>
<link href="<?= PLUGINJS ?>/print-js/print.min.css" rel="stylesheet"></script>

<link href="<?= PLUGINJS ?>/material-time-picker/mdtimepicker.css" rel="stylesheet">
<script src="<?= PLUGINJS ?>/material-time-picker/mdtimepicker.js"></script>
<script src="<?= PLUGINJS ?>/material-time-picker/mdtimepicker.js"></script>
<script>
// import printJS from 'print-js';
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

  $(document).ready(function() {
      $(".select2-patient").select2();
  });
</script>
<script type="text/javascript" src="<?= ASSETS ?>/js/moment.min.js"></script>
<script type="text/javascript" src="<?= PLUGINJS ?>/daterangepicker-master/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?= PLUGINJS ?>/daterangepicker-master/daterangepicker.css"" />
<script>
var previous_value = 0;
$('#Duration').on('click', function(e){
  previous_value = $(this).val();
}).change(function(){
  var endTime = $('#EndTime').val();
  var date = $('#Date').val();
  var duration = $('#Duration').val();
  var now = moment(date + ' ' + endTime, 'YYYY-MM-DD hh:mm:ss');
  var future = now.add((duration - previous_value) * 15, 'minutes');
  $('#EndTime').val(future.format('HH:mm:ss'));
})

	$('#generate-receipt').click(function(){
		$.ajax({
			url: '/test/public/appointment/mdpf.php',
			method: 'post',
			data: {
				id: '<?= $result['AppointmentID'] ?>',
				author: '<?= 'UserID : ' . $_SESSION['UserID'] . ' - Username : ' . $_SESSION['Username'] ?>',
				title: '<?= 'Receipt' ?>'
			},
			dataType : 'json',
			success: function(response) {
				window.setTimeout(function(){
          printJS('/test/public/appointment/receipt.pdf');
				}, 1500);
			},
		});
  })
  
  $('.mark-complete').on('click', function () {
    var url = $(this).attr('data-url');
    var id = $(this).attr('data-id');
    var confirmMessage = $(this).attr('data-message');
    $.ajax({
      url: url,
      method: 'post',
      data: {
        id: id,
      },
      dataType : 'json',
      success: function(response) {
        if(response.status == true) {
          alert(response.message);
            $('.mark-uncomplete[data-id='+id+']').removeClass('hidden');
            $('.mark-complete[data-id='+id+']').addClass('hidden');
        } else {
          alert(response.message);
        }
      },
      beforeSend:function(){
        return confirm(confirmMessage);
      },
    });

  });
  $('.mark-uncomplete').on('click', function () {
    var url = $(this).attr('data-url');
    var id = $(this).attr('data-id');
    var confirmMessage = $(this).attr('data-message');
    $.ajax({
      url: url,
      method: 'post',
      data: {
        id: id,
      },
      dataType : 'json',
      success: function(response) {
        if(response.status == true) {
          alert(response.message);
            $('.mark-complete[data-id='+id+']').removeClass('hidden');
            $('.mark-uncomplete[data-id='+id+']').addClass('hidden');
        } else {
          alert(response.message);
        }
      },
      beforeSend:function(){
        return confirm(confirmMessage);
      },
    });

  });

</script>
<?php
?>
<?php include "../templates/footer.php"; ?>

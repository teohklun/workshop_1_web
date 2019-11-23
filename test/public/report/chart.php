<?php 
// a view file shared by doctor performance, revenue chart
// based on the setting to create the view file
?>
<script src="../assets/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="<?= ASSETS ?>/plugins/select2/select2.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= ASSETS ?>/plugins/select2/select2.min.css">

<?php 
if($result) {
	$tempArray = $result;
	$data = [];
	array_pop($tempArray);
	$indexInterval = "IFNULL(".(isset($input['Group']) ? $input['Group'] : $filterInterval).", '".$tableHeaderToGroupByIfNull."')";
	$dataPie = [];
	foreach ($tempArray as $index => $column) {
		foreach ($column as $key => $value) {
			$data[$key][] = $value;
			if($key === 'sum') {
				$dataPie[] = [
					'values' => [$value],
					'text' => $column[$indexInterval]
				];
			}
		}
	}
	$dataPrice = json_encode($data['sum'], JSON_NUMERIC_CHECK);
	$dataInterval = json_encode($data[$indexInterval],JSON_NUMERIC_CHECK);
	$dataLargest = 0;
	foreach ($data['sum'] as $key => $value) {
		if($value > $dataLargest) {
			$dataLargest = $value;
		}
	}
	unset($tempArray);
}
?>

<a class='btn btn-create' href="<?= PATH_PUBLIC . '/report/index.php'?>">
	Back to previous page
</a>

<br>
<label for="sub-title-label">Select the Month, year, date for filter</label>
<div class="div-form">
	<?php include '_form.php' ?>
</div>

<div class="div-form">
	<div class="form-row layout-summary-table">
		<div class="col-md-6 mb-3">
			<div class='form-row'>
			<div class='col-md-3 mb-3'></div>
			<div class='col-md-6 mb-3'>
				<div class='btn btn-primary generate-report width-100' id='generate-report'>
					Generate Report
				</div>
			</div>
			<div class='col-md-3 mb-3'></div>
		</div>

			<div style="overflow-x:auto;">
					<?php include '_table.php' ?>
				</div>
			</div>
		<?php if($result): ?>
			<div id="pie-donaut" class="col-md-6 mb-3"></div>
		<?php else: ?>
			no data to illustrate chart
		<?php endif; ?>

		</div>
</div>
	<div class="div-form">
		<?php if($result): ?>
			<div id="chartDiv" class="col-md-12 mb-3"></div>
		<?php else: ?>
			no data to illustrate chart
		<?php endif; ?>

	</div>
	<script type="text/javascript" src="<?= ASSETS ?>/js/moment.min.js"></script>
	<script>

		$('#previous-page').click(function(){
			location.href = document.referrer;
		})

		$('.form-control').change(function() {
			var form = $(this).closest('form');
			form.find('input[type=submit]').click();
		})
	</script>
	<script type="text/javascript" src="<?= ASSETS ?>/plugins/chart.js-master/zingchart.min.js"></script>
	<script>
		var chartData = {
			"type":"bar3d",
			"background-color":"#fff",
			"3d-aspect":{
				"true3d":0,
				"y-angle":10,
				"depth":30
			},
			title: {
				text: "Revenue",
				fontFamily: 'Lato',
				padding: "15",
				fontColor : "#1E5D9E",
			},
			"plotarea":{
				"margin":"95px 35px 50px 70px",
				"background-color":"#fff",
				"alpha":0.3
			},
			legend: {}, // Creates an interactive legend
			series: [  // Insert your series data here.
			{
				values: <?= json_encode($data['sum'],JSON_NUMERIC_CHECK) ?>
				,"text":"Total"
			},
			{
				values: <?= json_encode($data['min'],JSON_NUMERIC_CHECK) ?>
				,"text":"Min"
			},
			{ 
				values: <?= json_encode($data['max'],JSON_NUMERIC_CHECK) ?>
				,"text":"Max"
			},
			{ 
				values: <?= json_encode($data['avg'],JSON_NUMERIC_CHECK) ?>
				,"text":"Average"
			},
		],
			"scale-x": {
				"background-color":"#fff",
				"border-width":"1px",
				"border-color":"#333",
				"alpha":0.5,
				"tick":{
					"line-color":"#333",
					"alpha":0.2
				},
				"item":{
					"font-size":"11px",
					"font-color":"#333"
			},
			"labels": <?= $dataInterval ?>
			},
			"scale-y":{
				"values":"0:<?= $dataLargest ?>:<?= ceil($dataLargest/5) ?>",
				"background-color":"#fff",
				"border-width":"1px",
				"border-color":"#333",
				"alpha":0.5,
				"format":"RM %v",
				"guide":{
					"line-style":"solid",
					"line-color":"#333",
					"alpha":0.2
				},
				"tick":{
					"line-color":"#333",
					"alpha":0.2
				},
				"item":{
					"font-color":"#333",
					"padding-right":"6px"
				}
			}
		};

		var pieData = {
			type: "pie", 
			backgroundColor: "#2B313B",
			plot: {
				borderColor: "#2B313B",
				borderWidth: 5,
				// slice: 90,
				valueBox: {
					placement: 'out',
					text: '%t\n%npv%',
					fontFamily: "Open Sans"
				},
				tooltip:{
					fontSize: '18',
					fontFamily: "Open Sans",
					padding: "5 10",
					text: "%npv%"
				},
				animation:{
					effect: 2, 
					method: 5,
					speed: 500,
					sequence: 1
				}
			},
			title: {
				fontColor: "#fff",
				text: '% Contribute to total revenue',
				align: "center",
				offsetX: 10,
				fontFamily: "Open Sans",
				fontSize: 25
			},
			plotarea: {
				margin: "20 0 0 0"  
			},
			series: <?= json_encode($dataPie, JSON_NUMERIC_CHECK) ?>,
			// Insert your series data here.
		};

		zingchart.render({ // Render Method[3]
		id: 'chartDiv',
		data: chartData,
		height: 400,
		});
		
		zingchart.render({ // Render Method[3]
		id: 'pie-donaut',
		data: pieData,
		});

	function getReportDataFromTable() {

		var clone = $('div.content').clone();
		clone.find('button').remove();
		var clone = $('table').clone();
		$(clone).find('button').remove();
		var data = $(clone).prop('outerHTML');
		return data;
	}

	$('#generate-report').click(function(){
		$.ajax({
			url: '/test/public/report/mdpf.php',
			method: 'post',
			data: {
				data: getReportDataFromTable(),
				author: '<?= 'UserID : ' . $_SESSION['UserID'] . ' - Username : ' . $_SESSION['Username'] ?>',
				title: '<?= 'Report Of Index ' . $baseName ?>'
			},
			dataType : 'json',
			success: function(response) {
				window.setTimeout(function(){
					window.location = '/test/public/report/dMdpf.php';
				}, 1500);
			},
			beforeSend:function(){
			},
		});
	})
	</script>

<?php include "../templates/footer.php"; ?>

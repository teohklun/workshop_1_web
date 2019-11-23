<?php 
// a page currently use by patient
// it designed to be able to use by patient,doctor,schedule,appointment
?>
<button class='btn btn-create' id='previous-page'>
	Back to previous page
</button>

<button class='btn btn-primary generate-report' id='generate-report'>
	Generate Report
</button>

<div style="overflow-x:auto;">

    <table class="grid-view">
		<tr>
			<?php foreach($tableHeader as $indexArraySelected => $header): ?>
				<th><?= $header ?></th>
			<?php endforeach; ?>
		</tr>

		<?php if(!$result): ?>
			<tr>
				<td colspan=12> No result Found. </td>
			</tr>
		<?php else: ?>
			<?php foreach($result as $key => $value): ?>
				<tr>
					<?php foreach($value as $key2 => $value2): ?>
						<td>
							<?php if ($value2 == null ): ?> 
							    <span> <?= '(not set)' ?> </span>
							<?php else:?>
								<span> <?= $value2 ?> </span>
							<?php endif;?>
						</td>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</table>
</div>
<br>
<?php include "../templates/footer.php"; ?>
<script>
</script>
<script src="../assets/js/jquery-3.3.1.min.js"></script>
<script>

	function getReportDataFromTable() {

		var clone = $('div.content').clone();
		clone.find('button').remove();
		// var html = clone.html();

		var clone = $('table').clone();
		$(clone).find('button').remove();
		// var data = clone.find('table').prop('outerHTML');
		// var data = $('table').prop('outerHTML');

		var data = $(clone).prop('outerHTML');
		
		// console.log(data);
		console.log('<?=$_SESSION['UserID']?>');
		console.log('test');
		return data;
	}

	$('#generate-report').click(function(){
		$.ajax({
			url: '/test/public/report/mdpf.php',
			method: 'post',
			data: {
				data: getReportDataFromTable(),
				author: '<?= 'UserID : ' . $_SESSION['UserID'] . ' - Username : ' . $_SESSION['Username'] ?>',
				title: '<?= 'Report Of ' . $action ?>'

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

		$('#previous-page').click(function(){
			location.href = document.referrer;
		})

</script>


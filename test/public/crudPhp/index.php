<?php

//a powerful file shared by basic module index.php
//responsive for use the $result from sqlindex.php to do a view file as index.php

//check access based on nav bar
    $canView = checkAccess($baseName, 'detail');
    $canEdit = checkAccess($baseName, 'edit');
	$canDelete = checkAccess($baseName, 'delete');
	$canReport = checkAccess($baseName, 'mdpf');
	if(isset($extraButton)) {
		$canExtra = [];
		foreach ($extraButton as $key => $value) {
			$canExtra[$key] = checkAccess($value['baseName'], $value['action']);
		}
	}
?>

	<nav class="navbar navbar-light bg-light inline-block width-100 padding-0">
		<form class="search-form width-100" method="get" id='search-form'>
			<div class='form-row'>
				<div class='col-md-<?= $canReport ? '2' : '3'?>'>
					<a href="create.php" class='btn btn-create width-100'>Create</a>
				</div>
					<?php if($canReport): ?>
						<div class='col-md-2'>
							<div class='btn btn-primary generate-report width-100' id='generate-report'>
									Generate Report
							</div>
						</div>
					<?php endif; ?>
				<div class='col-md-<?= $canReport ? '2' : '3'?>'>
					<button id='submit' type="submit" class="btn btn-outline-info my-2 my-sm-0 width-100" name="submit" value='Search'>Search</button>
				</div>
				<div class='col-md-6'>
					<select class="form-control" id='limit-selection' name='limit'>
						<option <?= $limit == 25 ?'selected' : '' ?> value=25>25</option>
						<option <?= $limit == 50 ?'selected' : '' ?> value=50>50</option>
						<option <?= $limit == 100 ?'selected' : '' ?> value=100>100</option>
						<option <?= $limit == 250 ?'selected' : '' ?> value=250>250</option>
						<option <?= $limit == 500 ?'selected' : '' ?> value=500>500</option>
					</select>
				</div>
				<input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
				<input name="Keyword" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" value="<?= isset($_GET['Keyword']) ? $_GET['Keyword'] : ''?>">
			</div>
		
		</form>
	</nav>
	<div style="overflow-x:auto;">
    <table class="grid-view">
		<tr>
			<?php foreach($tableHeader as $indexArraySelected => $header): ?>
				<?php if($header !== 'Action'): ?>
					<th><?= $header ?></th>
					<?php else: ?>
					<th class='action'><?= $header ?></th>
					<?php endif; ?>
			<?php endforeach; ?>
		</tr>

		<?php if(!$result): ?>
			<tr>
				<td colspan=12> No result Found. </td>
			</tr>
		<?php else: ?>
			<?php foreach($result as $key => $value): ?>
				<tr>
					<?php foreach($value as $column => $value2): ?>
					<?php if (!isset($columnDoNotShowFroMSelected) || !in_array($column, $columnDoNotShowFroMSelected) ): ?> 
						<td>
							<?php if ($value2 == null ): ?> 
								<span> <?= '(not set)' ?> </span>
							<?php else:?>
								<span> <?= $value2 ?> </span>
							<?php endif;?>
						</td>
						<?php endif;?>
					<?php endforeach; ?>
					<td class='action'>
						<label for="notes">
						<div class='form-row width-100'>
							<?php if($canView):?>
								<div class='min-width'>
									<a href='detail.php?id=<?= $result[$key][$primaryKey] ?>'>
										<img src='../assets/images/view.png'> 
									<a/>
								</div>
							<?php endif; ?>
							<?php if($canEdit):?>
								<div>
									<a href='edit.php?id=<?=$result[$key][$primaryKey] ?>'>
										<img src='../assets/images/edit.png'> 
									<a/>
								</div>
							<?php endif; ?>
							<?php if($canDelete):?>
								<div class="delete-btn" 
								data-id='<?= $result[$key][$primaryKey] ?>' 
								data-url='delete.php'
								data-trigger='visualDeleteEffectRow'
								>
									<img src='../assets/images/delete.png'> 
								</div>
						</div>

						<?php endif; ?>
						<?php if(isset($extraButton)):?>
							<?php foreach($canExtra as $canExtraIndex => $can): ?>
								<?php if($can):?>
								<div class='form-row'>
									<div class="btn extra <?=  $extraButton[$canExtraIndex]['class'] ?> <?= $extraButton[$canExtraIndex]['showCondition'] == $result[$key][$extraButton[$canExtraIndex]['showVariable']] ? '' : 'hidden' ?>"
									data-id='<?= $result[$key][$primaryKey] ?>' 
									data-message='<?=  $extraButton[$canExtraIndex]['message'] ?>'
									data-url='<?= $extraButton[$canExtraIndex]['action']?>.php'>
									<?= $extraButton[$canExtraIndex]['label'] ?>
								</div>
							</div>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>
						</label>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</table>
	<div>

</div>
<?php  
$statement = $connection->prepare($sqlBeforeLimit);
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<nav>
	<ul class='pagination'>
		<?php for($i=1; $i<=ceil(count($result) / $limit); $i++): ?>
			<li class='page-item <?= ($page == $i ? 'active' : '') ?>'>
			<?php if(isset($_GET['page'])): ?>
				<a href='<?= preg_replace('/page=[\0-9]+$/', 'page='.$i, $_SERVER['REQUEST_URI']) ?>' class='page-link'><?= $i ?></a>
			<?php else: ?>
				<a href='index.php?page=<?= $i ?>' class='page-link'><?= $i ?></a>
			<?php endif;?>
			</li>
		<?php endfor;?>
	</ul>
</nav>
<script src="../assets/js/jquery-3.3.1.min.js"></script>
<script>
	$(function () {
		$('.delete-btn').on('click', function () {
			processAjax(this);
		});
	});

	function processAjax(dom) {
		var id = $(dom).attr("data-id");
		var url = $(dom).attr("data-url");
		var confirmMessage = $(dom).attr("data-message");
		var triggerSuccess = $(dom).attr("data-trigger");
		var domButton = $(dom);
		triggerAjax(url, id, domButton, confirmMessage);
	}

	function triggerAjax(url, id, domButton, confirmMessage = 'Are you sure want to delete this record ?') {
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
					visualDeleteEffectRow(domButton);
				} else {
					alert(response.message);
				}
			},
			beforeSend:function(){
				return confirm(confirmMessage);
			},
		});
	}

	function visualDeleteEffectRow(domButton) {
		domButton.closest('tr').remove();
	}

	function getReportDataFromTable() {
		var clone = $('div.content').clone();
		clone.find('button').remove();
		var clone = $('table').clone();
		$(clone).find('td.action').remove();
		$(clone).find('th.action').remove();
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

	$('#previous-page').click(function(){
		location.href = document.referrer;
	})
	$('select').change(function(){
		$("#submit").click();
	})

	//when submit, before it submit, add a value, input page to the form and submit to post data.
	$("#search-form").submit( function(eventObj) {
	//some browser maynot support
	// https://www.kevinleary.net/javascript-get-url-parameters/
	var urlParams = new URLSearchParams(window.location.search);
	var entries = urlParams.entries();
	for(pair of entries) { 
		if(pair[0] === 'page') {
			var page = pair[1];
		}
	}
	if(!page) {
		var page = 1;
	}
      $('<input />').attr('type', 'hidden')
          .attr('name', "page")
          .attr('value', page)
          .appendTo('#search-form');
      return true;
  });
  
</script>
<?php include "../templates/footer.php"; ?>


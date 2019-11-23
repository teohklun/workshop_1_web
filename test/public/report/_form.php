<form method="post">
	<input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">

	<div class="form-row">
		<div class="col-md-3 mb-3">
			<?php if(isset($limitName)): ?>
			<div class="form-row">
				<div class="col-md-6 mb-3">

					<?php
						$limitDropDown = [
							2 => 2,
							25 => 25,
							50 => 50,
							100 => 100,
							500 => 500,
						];
					?>
					<label>Filter With <?= $limitName ?></label>
					<select name='<?=$limitName?>' class='form-control select2'>
					<?php foreach($limitDropDown as $label => $value): ?>
						<option <?= isset($input[$limitName]) ? $input[$limitName] == $value ? 'selected' : '' : '' ?> value=<?= $value ?>><?= $label ?></option>
					<?php endforeach; ?>
				</div>
				</select>
			</div>
				<div class="col-md-6 mb-3">
				<label>Sum revenue by ASC or DESC</label>
				<select name='orderSum' class='form-control select2'>
					<option <?= isset($input['orderSum']) ? $input['orderSum'] === 'ASC' ? 'selected' : '' : 'selected' ?> value ='ASC' >ASC</option>
					<option <?= isset($input['orderSum']) ? $input['orderSum'] === 'DESC' ? 'selected' : '' : '' ?> value ='DESC' >DESC</option>
				</select>
				</div>
				</div>

			<?php else: ?>
			<?php endif; ?>
		</div>
			<div class="col-md-6 mb-3">
				<label>Group as</label>
				<select name='Group' class='form-control'>
					<?php if(!isset($fixedGroup)): ?>
						<option <?= isset($input['Group']) ? $input['Group'] === 'year' ? 'selected' : '' : 'selected' ?> value='year'>Year</option>
						<option <?= isset($input['Group']) ? $input['Group'] === 'quarter' ? 'selected' : '' : '' ?> value='quarter'>Quarter</option>
						<option <?= isset($input['Group']) ? $input['Group'] === 'month' ? 'selected' : '' : '' ?> value='month'>Month</option>
						<option <?= isset($input['Group']) ? $input['Group'] === 'day' ? 'selected' : '' : '' ?> value='day'>Day</option>
					<?php else: ?>
						<option disabled selected value=''><?= $fixedGroup ?></option>
					<?php endif; ?>
				</select>
			</div>
		<div class="col-md-3 mb-3">
			<?php if(isset($extraDropDown)): ?>
				<label>Filter With <?= $extraFilter ?></label>
				<select name='<?=$extraFilter?>[]' class='form-control select2' multiple="multiple"'>
				<?php foreach($extraDropDown as $label => $value): ?>
					<option <?= isset($input[$extraFilter]) ? in_array($value, $input[$extraFilter]) ? 'selected' : '' : '' ?> value=<?= $value ?>><?= $label ?></option>
				<?php endforeach; ?>
				</select>
			<?php else: ?>
			<?php endif; ?>
		</div>
	</div>

	<div class="form-row">
		<div class="col-md-4 mb-3">
			<label>Year</label>
			<select name='Year[]' class='form-control select2' multiple="multiple">
				<?php
					$createdYear = 2017;
				?>
				<?php for($year = date('Y'); $year >= $createdYear; $year--): ?>
					<option <?= isset($input['Year']) ? in_array($year, $input['Year']) ? 'selected' : '' : '' ?> value='<?= $year ?>'><?=$year?></option>
				<?php endfor; ?>
			</select>
		</div>
		<div class="col-md-4 mb-3">
			<label>Month</label>
			<select name='Month[]' class='select2 form-control ' multiple="multiple">
				<?php for($month = 12; $month >= 1; $month--): ?>
					<option <?= isset($input['Month']) ? in_array($month, $input['Month']) ? 'selected' : '' : '' ?> value='<?= $month ?>'><?=$month?></option>
				<?php endfor; ?>
			</select>
		</div>
		<div class="col-md-4 mb-3">
			<label>Day</label>
			<select name='Day[]' class='form-control select2' multiple="multiple">
				<?php for($day = 31; $day >= 1; $day--): ?>
					<option  <?= isset($input['Day']) ? in_array($day, $input['Day']) ? 'selected' : '' : '' ?> value='<?= $day ?>'><?=$day?></option>
				<?php endfor; ?>
			</select>
		</div>
	</div>
    <input class="hidden" type="submit" name="submit" value="Submit" >
</form>
<script>
$(document).ready(function() {
    $('.select2').select2({});
});
</script>
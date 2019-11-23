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

    <form id="crud-form" method="post" enctype="multipart/form-data" action=''>
      <input class="form-control" name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
      <div class="form-row">
        <div class="col-md-12 mb-3">
          <label for="Professional">Professional<span><?= isFieldRequired('Professional') == true ? ' *' : ''?></span></label>
          <input class="form-control" type="text" name="Professional" id="Professional" value="<?= isset($input['Professional']) ? $input['Professional'] : '' ?>">
        </div>
      </div>

      <?php include "../templates/profile/form.php" ?>
      <?php include "../templates/address/form.php" ?>

      <input class="btn btn-primary" type="submit" name="submit" value="Submit" >

      <a href="index.php" class="btn btn-warning">Back to index</a>
    </form>
</div>
<?php include "../templates/footer.php"; ?>

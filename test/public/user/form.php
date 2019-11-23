<?php sessionMessage(); ?>

<script src="../assets/js/jquery-3.3.1.min.js"></script>
<script>
  $(".close").click(function() {
    this.closest('blockquote').remove();
  });
</script>
  <h2><?= $subTittle ?></h2>
  <label for="notes"><span>*</span> means required field</label>
<div class="div-form">
  <form id="crud-form" method="post" enctype="multipart/form-data" action=''>
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">

    <div class="form-row">
      <div class="col-md-12 mb-3">
        <label for="Username">Username<span><?= isFieldRequired('Name') == true ? ' *' : ''?></span></label>
        <input class="form-control" type="text" name="Username" id="Username" value="<?= isset($input['Username']) ? $input['Username'] : '' ?>">
      </div>
    </div>
    
    <div class="form-row">
      <div class="col-md-6 mb-3">
        <label for="Password">Password<span><?= isFieldRequired('Name') == true ? ' *' : ''?></span></label>
        <input class="form-control" type="password" name="Password" id="Password" value="<?= isset($input['Password']) ? $input['Password'] : '' ?>">
        <label for="notes-input">Must be more than 6 characters</label>
      </div>

      <div class="col-md-6 mb-3">
        <label for="ConfirmPassword">ConfirmPassword<span><?= isFieldRequired('Name') == true ? ' *' : ''?></span></label>
        <input class="form-control" type="password" name="ConfirmPassword" id="ConfirmPassword" value="<?= isset($input['ConfirmPassword']) ? $input['ConfirmPassword'] : '' ?>">
        <label for="notes-input">Must be more than 6 characters</label>
      </div>
    </div>
    
    <?php include "../templates/profile/form.php" ?>
    <?php include "../templates/address/form.php" ?>
    
    <input class="btn btn-primary" type="submit" name="submit" value="Submit" >
    <a href="index.php" class="btn btn-warning">Back to index</a>
  </form>
</div>

<?php include "../templates/footer.php"; ?>

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

    <label for="Debt">Debt<span><?= isFieldRequired('Debt') == true ? ' *' : ''?></span></label>
    <input type="number" name="Debt" id="Debt" value="<?= isset($input['Debt']) ? $input['Debt'] : 0 ?>">

    <br/>
    <br/>

    <?php include "../templates/profile/form.php" ?>
    <?php include "../templates/address/form.php" ?>
    <input class="btn btn-primary" type="submit" name="submit" value="Submit" >
    <a href="index.php" class="btn btn-warning">Back to index</a>
  </form>
</div>

<?php include "../templates/footer.php"; ?>

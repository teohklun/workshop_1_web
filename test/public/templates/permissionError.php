<?php
// this file is responsive to create a page of error permission
?>
<?php include_once "header.php"; ?>
<style>
blockquote {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}

blockquote.error-message{

    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
}
</style>
<?php if(isset($errorMessageWithRbac)): ?>
    <blockquote class='error-message'><?= $errorMessageWithRbac ?></blockquote>
<?php else: ?>
    <blockquote class='error-message'><?= 'Sorry, Permission not allowed. Contact admin.' ?></blockquote>
<?php endif; ?>
<?php include_once "footer.php"; ?>

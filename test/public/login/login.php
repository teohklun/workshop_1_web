<?php include_once "../../init.php"; ?>
<?php include_once "../templates/header.php"; ?>
<?php if(!isset($_SESSION['UserID'])): ?>
<?php include_once "../../sql.php"; ?>
<link rel="stylesheet" href="../assets/css/login.css">
<link rel="stylesheet" href="../assets/plugins/bootstrap-3.3.7-dist/css/bootstrap.min.css">
<script src="../assets/js/jquery-3.3.1.min.js"></script>
<?php
  if (isset($_POST['submit']) && !isset($_SESSION['UserID'])) {
      $validation = true;
      $errMessage = ''; 
      $succesfulMessage = 'Will be redirect to user page after 5 secs';
      $action = 'login';

      include "../crudPhp/form/initFormField.php";
      $dbAction = true;
      try  {
        include "sql/initSqlConnection.php";
        $sql .= ' where Username=:Username';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':Username', $input['Username'], PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $valid = false;
        
        if($result) {
          $hashedPassword = $result['Password'];
          $valid = password_verify($input['Password'], $hashedPassword);
          // $valid = true;
          if($valid) {
            $_SESSION['UserID'] = $result['UserID'];
            $_SESSION['Username'] = $result['Username'];
          }
        }

      } catch(PDOException $error) {
          $dbAction = false;
          echo $sql . "<br>" . $error->getMessage();
      }
    }
  ?>

<form class="crud-form" method="post">
 <div class="container-fluid">
      <div class="row">
         <div class="well center-block">
            <?php if(isset($_POST['submit']) && !$valid): ?>
            <div class="alert alert-danger" role="alert">
               The username or password is invalid
               <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
            </div>
            <?php elseif(isset($_POST['submit']) && $valid):?>
               <div class="alert alert-success" role="alert">
                  Login Success. <?php echo escape('Welcome ' . $input['Username']);?>
                  <button type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">×</span>
                  </button>
               </div>
               <div class="alert alert-info" role="alert">
                  <span>Will be redirect to user page after <span id="time-out">5</span> secs Or</span>
                  <br/>
                  <a href='<?= HOME_URL ?>'>Click Here for manual redirect ... </a>
                  <button type="button" class="close" aria-label="Close">
                     <span aria-hidden="true">×</span>
                  </button>
               </div>
               <script>

                     var timeInterval = setInterval(myTimer, 1000);
                     var timesRun = 0;

                     setTimeout(function(){
                        window.location = ('<?= HOME_URL ?>');
                     }, 5000);

                     function myTimer() {
                        var text = $('#time-out').text();
                        text -=1 ;
                        $('#time-out').text(text);
                        timesRun += 1;
                        if(timesRun === 5){
                           clearInterval(timeInterval);
                        }
                     }
            
               </script>
            <?php elseif(isset($_POST['submit'])): ?>
               <blockquote><?php echo 'Database Error';?></blockquote>
            <?php else: ?>
               <script>

                  $(document).ready(function() 
                  {
                     $("#showhide").click(function() 
                     {
                        if ($(this).data('val') == "1") 
                        {
                           $("#pwd").prop('type','text');
                           $("#eye").attr("class","glyphicon glyphicon-eye-close");
                           $(this).data('val','0');
                        }
                        else
                        {
                           $("#pwd").prop('type', 'password');
                           $("#eye").attr("class","glyphicon glyphicon-eye-open");
                           $(this).data('val','1');
                        }
                     });
                     $("#remove").click(function()
                     {
                        $("#uname").val('');
                     });

                  });
               </script>
            <?php endif; ?>
            <div class="well-header">
               <center><img src="../assets/images/login-icon.png" class="img-thumbnail img-circle img-responsive" height="80px;" width="80px;"></center>
               <h1 class="text-center" style="color: White;">Treatment Booking System</h1>
               <h3 class="text-center" style="color: White;">Login</h3><hr>

            </div>
            <div class="row">
               <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="row">
                     <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                           <div class="input-group">
                              <div class="input-group-addon">
                                 <span class="glyphicon glyphicon-user"></span>
                              </div>
                           <input type="text" placeholder="User Name" id="uname" name="Username" class="form-control" value="<?= isset($input) ? isset($input['Username']) ? $input['Username'] : '' : '' ?>">
                            <div class="input-group-btn">

                              <button type="button" type="button" id="remove" data-val="1" class="btn btn-default btn-md"> <span class="glyphicon glyphicon-remove"></span></button>
                           </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                           <div class="input-group">
                              <div class="input-group-addon">
                                 <span class="glyphicon glyphicon-lock"></span>
                              </div>
                              <input type="password" id="pwd" class="form-control" placeholder="Password" name="Password" value="<?= isset($input) ? isset($input['Password']) ? $input['Password'] : '' : '' ?>">
                              <span class="input-group-btn">
                                 <button type="button" class="btn btn-default btn-md" id="showhide" data-val='1'><span id='eye' class="glyphicon glyphicon-eye-open"></span></button>
                              </span>
                           </div>
                        </div>
                     </div>
                  </div>

                  <br>
                  <div class="row">
                     <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="submit" name="submit" value="Submit" class="btn btn-lg btn1 btn-block"> Login</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</form>
<script>
$(".close").click(function() {
   this.closest('div').remove();
});
</script>
  <?php include_once "../templates/footer.php"; ?>
<?php else: ?>
 <script>
  window.location = ('<?= HOME_URL ?>');
 </script>
<?php endif; ?>


<?php
// this file is responsive to create nav bar in all page except login
?>
<?php 
  $canUser = checkAccess('user', 'index');
  $canPatient = checkAccess('patient', 'index');
  $canDoctor = checkAccess('doctor', 'index');
  $canSchedule = checkAccess('schedule', 'index');
  $canAppointment = checkAccess('appointment', 'index');
  $canReport = checkAccess('report', 'index');
?>
<ul class="nav-link">
  <li class="nav-link-li"><a class="<?= $baseName === 'home' ? 'active' : '' ?>"href="/test/public/home/index.php">Home</a></li>
<?php if($canUser): ?>
  <li class="nav-link-li"><a class="<?= $baseName === 'user' ? 'active' : '' ?>"href="/test/public/user/index.php">User</a></li>
<?php endif; ?>
<?php if($canPatient): ?>
  <li class="nav-link-li"><a class="<?= $baseName === 'patient' ? 'active' : '' ?>"href="/test/public/patient/index.php">Patient</a></li>
<?php endif; ?>
<?php if($canDoctor): ?>
  <li class="nav-link-li"><a class="<?= $baseName === 'doctor' ? 'active' : '' ?>"href="/test/public/doctor/index.php">Doctor</a></li>
<?php endif; ?>
<?php if($canSchedule): ?>
  <li class="nav-link-li"><a class="<?= $baseName === 'schedule' ? 'active' : '' ?>"href="/test/public/schedule/index.php">Schedule</a></li>
<?php endif; ?>
<?php if($canAppointment): ?>
  <li class="nav-link-li"><a class="<?= $baseName === 'appointment' ? 'active' : '' ?>"href="/test/public/appointment/index.php">Appointment</a></li>
<?php endif; ?>
<?php if($canReport): ?>
  <li class="nav-link-li"><a class="<?= $baseName === 'report' ? 'active' : '' ?>"href="/test/public/report/index.php">Report</a></li>
<?php endif; ?>
  <?php if(isset($_SESSION['UserID'])): ?>
    <div style='float:right'>
      <li class="nav-link-li li-username"><span> <?= $_SESSION['Username'] ?> </span> </li>
      <li class="nav-link-li li-logout"><a href='<?= PATH_PUBLIC ?>/login/logout.php'>Logout</a> </li>
    </div>
  <?php else: ?>
    <li class="nav-link-li li-login"><a href='<?= PATH_PUBLIC ?>/login/login.php'> Login </a> </li>
  <?php endif;?>
</ul>
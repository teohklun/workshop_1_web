<!doctype html>
<?php
// this file is responsive to create html header
?>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Treatment Booking System</title>

</head>

<body>

<?php if(isset($_SESSION['UserID'])): ?>

	<link rel="stylesheet" href="../assets/css/style.css">
	<div class='header'>

		<?php include "nav.php";?>
		<h1 class="h1-title">Treatment Booking System</h1>
		<h2 class="h2-sub-title"> <?= isset($baseName) ? $baseName : '' ?></h2>
	</div>
		<div class='container'>
<?php else: ?>
<?php endif; ?>

	
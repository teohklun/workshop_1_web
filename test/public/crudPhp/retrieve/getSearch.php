<?php

	//share by all basic module index.php to do single filter keyword

	$whereKeyword = '';
	if (isset($_GET['submit'])) {
		if (!hash_equals($_SESSION['csrf'], $_GET['csrf'])) die();
		$whereKeyword = $_GET['Keyword'];
	}
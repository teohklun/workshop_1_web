<?php

//sql code of select query
//it will get the define data in basic module index.php
// to retrieve all record from table

	try {
		$connection = new PDO($dsn, $dbUsername, $dbPassword, $options);

		$sql = getSelectQueryString($selected, $from, $join, $linkColumn, $relationTable, $tableName);
		if($whereKeyword) {
			$sql .= $sqlKeyword;
		}

		//this part is to set variable $page
		if (isset($_GET["page"])) {
			$page  = $_GET["page"]; 
		} else {
			$page = 1;
		};

		//filter result for the index.php
		//since records could be above 1000
		if (isset($_GET["limit"])) {
			$limit  = $_GET["limit"]; 
		} else {
			$limit = 25;
		};


		// a variable later will be going to use for calculate total page in pagiantion
		$sqlBeforeLimit = $sql;

		// based on page to tell the database limit from where to where
		$startFrom = ($page-1) * $limit;

		//extra query to do limit, get x (25,50,100 --- based on selection limit on index.php) records
		$sql .= ' group by ' . $primaryKey;
		$sql .= " LIMIT $startFrom, $limit";
		$statement = $connection->prepare($sql);
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);

	} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	}
<?php
	$uuid = $_POST["uuid"];
	
	include_once("config.php");
	
	/* check connection */
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	}else{
		//printf("Connected");
	}
	
	$query = "DELETE FROM orders WHERE uuid = '$uuid'";
	
	if ($result = $mysqli->query($query)) {
		
		echo("$(\"#submitMessage\").html(\"<div class='alert alert-danger' role='alert'><p align='center'><b>Good job, dingus</b>! The order was successfully deleted, you will be redirected to <a href='orderGrid.php'>Order History</a> in 4 seconds.</p></div>\");");
		echo("window.location.href = \"#submitMessage\";");
		echo("setTimeout(function(){window.location.href=\"orderGrid.php\";}, 4000);");
		
	}else{
		echo("$(\"#submitMessage\").html(\"<div class='alert alert-warning' role='alert'><p align='center'><b>Well shit</b>! I don't think that the order was successfully deleted.</p></div>\");");
	}
?>
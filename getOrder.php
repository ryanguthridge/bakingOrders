<?php
	include_once("config.php");
	
	$q = intval($_GET['q']);
	
	/* check connection */
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	}else{
		printf("Connected");
	}
	//MySQLi query
	$query = "SELECT id,name,phone,email,address,cost,contactDate,dueDate,orderItems,notes FROM orders WHERE id = '".$q."'";

	//$query = "SELECT dueDate,name,phone,cost,address,uuid FROM orders";
		
	if ($result = $mysqli->query($query)) {

		/* fetch associative array */
		while ($row = $result->fetch_assoc()) {
			printf("$('#name').val(%s),$row["name"]");
		}

		/* free result set */
		$result->free();
	}else{
		printf ("Database connect error");
	}
	//close db connection
	$mysqli->close();
?>
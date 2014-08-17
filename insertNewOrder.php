<?php
if($_POST){
	//include db configuration file
	include_once("config.php");

	   //Sanitize input data using PHP filter_var().
	    $uuid 			= $_POST["uuid"];
		$name 			= filter_var($_POST["name"],FILTER_SANITIZE_STRING);
		$phone			= filter_var($_POST["phone"],FILTER_SANITIZE_STRING);
		$email			= filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
		$address		= filter_var($_POST["address"],FILTER_SANITIZE_STRING);
		$cost			= filter_var($_POST["cost"],FILTER_SANITIZE_STRING);
		$contactDate	= $_POST["contactDate"];
		$dueDate		= $_POST["dueDate"];
		$orderItems		= filter_var($_POST["orderItems"],FILTER_SANITIZE_STRING);
		$notes			= filter_var($_POST["notes"],FILTER_SANITIZE_STRING);
		$paid			= filter_var($_POST["paid"],FILTER_SANITIZE_STRING);
	  
		// Insert sanitize string in record
		//$insert_row = $mysqli->query("INSERT INTO orders name, phone, $email, $address, $cost, $contactDate, $dueDate, $orderItems, $notes");
		
		$query = "INSERT INTO orders (uuid,name,phone,email,address,cost,contactDate,dueDate,orderItems,notes,paid) VALUES ('$uuid', '$name', '$phone','$email','$address','$cost','$contactDate','$dueDate','$orderItems','$notes','$paid');";
		$result = $mysqli->query($query);
		
		if(!$result){
			printf("Error: %s\n", $mysqli->error);
		}		
		$mysqli->close();
		
	}else{
		header('HTTP/1.1 500 .mysql error');
	}
?>
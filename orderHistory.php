<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <!-- jQuery Includes -->
    <script src="jquery-ui/external/jquery/jquery.js"></script>
    <script src="jquery-ui/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="jquery-ui/jquery-ui.min.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="jquery-ui/jquery-ui.theme.min.css" media="screen" />

    <!-- Bootstrap Includes -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" media="screen" />

    <!-- Custom JS -->
    <script src="js/custom.js"></script>
	
	<!-- Submit the form -->
	<script>
		function readOrder(opt){
			//Grabs the currently selected entry
			var selectBox = document.getElementById("orderSelect");
			var searchUUID = selectBox.options[selectBox.selectedIndex].value;
			window.location.href = "index.php?search=" + searchUUID;
		}
	</script>
	</head>
	<body>
	<?php 
		include_once("navbar.php");
	?>
	<br>

	<div class="container">
	
	<div style="background-color: #428bca" class="jumbotron">
            <h1 style="color: white">Fresh-Bakes Order Form</h1>
            <p style="color: white">Fill out all of the forms, ya dingus!</p>
    </div>

	<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Previous Orders</h3>
			</div>
			<div class="panel-body">
				<?php
					include_once("config.php");
					
					/* check connection */
					if ($mysqli->connect_errno) {
						printf("Connect failed: %s\n", $mysqli->connect_error);
						exit();
					}else{
						printf("Connected");
					}
					
					$query = "SELECT dueDate,name,phone,cost,address,uuid FROM orders";
						
					if ($result = $mysqli->query($query)) {

						/* fetch associative array */
						echo("<select id='orderSelect' class='form-control' onchange='readOrder(value);'>");
						echo("<option>Please click here to select an order to review</option>");
						while ($row = $result->fetch_assoc()) {
							printf("<option id=%s value=%s onchange='readOrder({\"orderId\":\"%s\"};)'>",$row["uuid"],$row["uuid"],$row["uuid"]);
							printf ("Delivery Date:%s / %s (%s) / Cost: $%s - UUID: %s\n",$row["dueDate"],$row["name"],$row["phone"],$row["cost"],$row["uuid"]);
							echo("</option>");
						}
						echo("</select>");

						/* free result set */
						$result->free();
					}else{
						printf ("Database connect error");
					}
					//close db connection
					$mysqli->close();
				?>
			</div>
	</div>
	</div>
</body>
</html>
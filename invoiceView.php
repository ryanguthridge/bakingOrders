<?php
include_once("config.php");
		
			/* check connection */
			if ($mysqli->connect_errno) {
				printf("Connect failed: %s\n", $mysqli->connect_error);
				exit();
			}else{
				//printf("Connected");
			}
			
			$query = 'SELECT uuid,name,phone,email,address,cost,contactDate,dueDate,orderItems,notes,deliveryFee,rentalFee,rentalItems,paid,totalCost FROM orders WHERE uuid = "'.$search.'"';
				
			if ($result = $mysqli->query($query)) {

				/* fetch associative array */
				while ($row = $result->fetch_assoc()) {
					printf("<script>$(\"#name\").val(\"%s\")</script>",$row["name"]);
					printf("<script>$(\"#phone\").val(\"%s\")</script>",$row["phone"]);
					printf("<script>$(\"#email\").val(\"%s\")</script>",$row["email"]);
					printf("<script>$(\"#address\").val(\"%s\")</script>",$row["address"]);
					printf("<script>$(\"#cost\").val(\"%s\")</script>",$row["cost"]);
					printf("<script>$(\"#uuid\").val(\"".$search."\")</script>");
					printf("<script>$(\"#contactDate\").val(\"%s\")</script>",$row["contactDate"]);
					printf("<script>$(\"#dueDate\").val(\"%s\")</script>",$row["dueDate"]);
					printf("<script>$(\"#orderItems\").val(\"%s\")</script>",$row["orderItems"]);
					printf("<script>$(\"#deliveryFee\").val(\"%s\")</script>",$row["deliveryFee"]);
					printf("<script>$(\"#rentalFee\").val(\"%s\")</script>",$row["rentalFee"]);
					printf("<script>$(\"#rentalItems\").val(\"%s\")</script>",$row["rentalItems"]);					
					printf("<script>$(\"#totalCost\").val(\"%s\")</script>",$row["totalCost"]);	
					printf("<script>$(\"#notes\").val(\"%s\")</script>",$row["notes"]);
					printf("<script>$(\"#paid\").val(\"%s\")</script>",$row["paid"]);
				}
				
				echo("<script>");
				echo("$(\"#submitMessage\").html(\"<div class='alert alert-success' role='alert'><p align='center'><b>Congratulations!</b> The order was successfully loaded.</p>\");");
				echo("orderUpdate = true;");
				echo("$(\"#submitButton\").text(\"Update Order\");");
				echo("</script>");

				/* free result set */
				$result->free();
			}else{
				printf ("Database connect error");
			}
			//close db connection	
			$mysqli->close();
?>
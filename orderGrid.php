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

	<!-- DataTables -->
	<script src="datatables/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="datatables/css/jquery.dataTables.min.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="datatables/css/jquery.dataTables_themeroller.css" media="screen" />

    <!-- Custom JS -->
    <script src="js/custom.js"></script>
	
	<!-- DataTable Instantiation -->
	<script>
	$(document).ready(function() {
		$('#orderGrid').dataTable();
	} );
	</script>
	
	<!-- Pull up selected file -->
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
						
					}
					
					$query = "SELECT uuid,name,phone,email,address,totalCost,contactDate,dueDate,orderItems,notes,paid FROM orders";
						
					if ($result = $mysqli->query($query)) {
						
						/* Data Table Code */
						echo("<table id=\"orderGrid\" class=\"display\" cellspacing=\"0\" width=\"100%\">");
						echo("<thead>");
						echo("<tr>");
						echo("<th>Name</th>");
						echo("<th>Order Delivery Date</th>");
						echo("<th>Phone Number</th>");
						echo("<th>Email</th>");
						//echo("<th>Address</th>");
						echo("<th>Cost</th>");
						//echo("<th>Contact Date</th>");
						//echo("<th>Order Delivery Date</th>");
						echo("<th>Order Items</th>");
						echo("<th>Notes</th>");
						echo("<th>Paid?</th>");
						//echo("<th>uuid</th>");
						echo("</tr>");
						echo("</thead>");	
						echo("<tbody>");
						
						/* fetch associative array */
						while ($row = $result->fetch_assoc()) {
						
						$orderItemList = $row[orderItems];
						$orderItemListArray = explode(",", $orderItemList);
						
							$tempTitle = $row[name];
							
							if($tempTitle[0] == "*"){
								printf("<tr style='background-color: #FFC8BB;'>");
							}else{
								printf("<tr>");
							}
							
							
							printf("<td><a href='index.php?search=%s'>%s</a></td>",$row["uuid"],$row["name"]);
							printf("<td>%s</td>",$row["dueDate"]);
							printf("<td>%s</td>",$row["phone"]);
							printf("<td><a href='mailto:%s'>%s</a></td>",$row["email"],$row["email"]);
							//printf("<td>%s</td>",$row["address"]);
							printf("<td>$%s</td>",$row["totalCost"]);
							//printf("<td>%s</td>",$row["contactDate"]);
							//printf("<td>%s</td>",$row["dueDate"]);
							
								//Adding a for loop for the display of items
								//printf("<td>%s</td>",$row["orderItems"]);
								printf("<td>");
								foreach ($orderItemListArray as $items) {
								   echo "<span style='color: #bf5c8d' class='glyphicon glyphicon-asterisk'></span> $items <br>";
								}
								printf("</td>");
								
							
							printf("<td>%s</td>",$row["notes"]);
							//printf("<td>%s</td>",$row["uuid"]);
							printf("<td>%s</td>",$row["paid"]);
						echo("</tr>");
						}									
						echo("</tbody>");
						echo("</table>");
						
						/* End Data Table Code */
						
						

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
	
	<script>
		$(function(){
			//Make this page active
			$("#newOrderListItem").removeClass("active");
			$("#orderGridListItem").addClass("active");
			$("#orderHistoryListItem").removeClass("active");					
		});
	</script>
	
</body>
</html>
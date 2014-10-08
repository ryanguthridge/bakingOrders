<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<!-- Moment.js -->
	<script src="calendar/moment.min.js"></script>
	
    <!-- jQuery Includes -->
    <script src="jquery-ui/external/jquery/jquery.js"></script>
    <script src="jquery-ui/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="jquery-ui/jquery-ui.min.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="jquery-ui/jquery-ui.theme.min.css" media="screen" />

    <!-- Bootstrap Includes -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" media="screen" />
		
	<!-- jQuery Full Calendar -->
	<script src="calendar/fullcalendar.min.js"></script>
    <link rel="stylesheet" type="text/css" href="calendar/fullcalendar.min.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="calendar/fullcalendar.print.css" media="print" />
	<link rel="stylesheet" type="text/css" href="calendar/gcal.js" media="screen" />
		
    <!-- Custom JS -->
    <script src="js/custom.js"></script>
	
	<script>
		$(document).ready(function() {
			
			$('#calendar').fullCalendar({
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				editable: true,
				eventLimit: true, // allow "more" link when too many events
				events: [
				
					<?php
						include_once("config.php");
						
						/* check connection */
						if ($mysqli->connect_errno) {
							printf("Connect failed: %s\n", $mysqli->connect_error);
							exit();
						}else{
							//printf("Connected");
						}
						
						$query = "SELECT dueDate,name,cost,uuid FROM orders";
							
						if ($result = $mysqli->query($query)) {

							/* fetch associative array */					
							while ($row = $result->fetch_assoc()) {
							
								$tempTitle = $row[name];
							
								
							
								printf("{");
								printf("title: \"%s - $%s\", ",$row["name"],$row["cost"]);
								printf("start: \"%s\", ",$row["dueDate"]);
								
									if($tempTitle[0] == "*"){
											printf("url: \"index.php?search=%s\", ",$row["uuid"]);
											printf("backgroundColor: \"#FFC8BB\",");
											printf("borderColor: \"#FFC8BB\"");
										}else{
											printf("url: \"index.php?search=%s\" ",$row["uuid"]);
										}
								
								printf("},");
							}

							/* free result set */
							$result->free();
						}else{
							printf ("Database connect error");
						}
						//close db connection
						$mysqli->close();
					?>					
					{
						title: 'Smooch-Town',
						url: 'http://google.com/',
						start: '2010-03-6'
					}
				]
			});
			
		});

	</script>

	</head>
	<body>
	<?php 
		include_once("navbar.php");
	?>
	<br>

	<div class="container">
		
		<div class="alert alert-success alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		  <strong>Hi Fresh!</strong> Click on a calendar item to view/edit it's details.
		</div>
	
		<div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title hidden-print"><span class="glyphicon glyphicon-calendar"></span> Order Calendar</h3>
            </div>
            <div class="panel-body">
				<br>
				<div class="well">
					<div class="row">						
						<div class="col-md-2"><span style="color: #428bca;" class="glyphicon glyphicon-asterisk"></span> Confirmed Order</div>
						<div class="col-md-2"><span style="color: #FFC8BB;" class="glyphicon glyphicon-asterisk"></span> Draft Order</div>
					</div>
				</div>
				<br><br>
				<div id="calendar"></div>
				<br>
			</div>
		</div>
		
		<div class="alert alert-info" role="alert"><p align='center'><strong>Sex, drugs, and insanity</strong> have always worked for me, but I wouldn't recommend them for everyone.<br>-Hunter S. Thompson</p></div>
		
	</div>
	
	<script>
		$(function(){					
			//Make this page active
			$("#newOrderListItem").removeClass("active");			
			$("#orderGridListItem").removeClass("active");
			$("#orderHistoryListItem").addClass("active");
		});
	</script>
	
</body>
</html>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <!-- jQuery Includes -->
    <script src="jquery-ui/external/jquery/jquery.js"></script>
    <script src="jquery-ui/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="jquery-ui/jquery-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="jquery-ui/jquery-ui.theme.min.css" />

    <!-- Bootstrap Includes -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
	
    <!-- Custom JS -->
    <script src="js/custom.js"></script>
	
	<!-- Submit the form -->
	<script>
		function readOrder(opt){
			//Grabs the currently selected entry
			var selectBox = document.getElementById("orderSelect");
			//alert(selectBox.options[selectBox.selectedIndex].value);
			
		}
	</script>
	<script>
		var orderUpdate = false;
		
        function submitForm(event){

            event.preventDefault();
			
			var uuid = $("#uuid").val();
			var name = $("#name").val();
			var phone = $("#phone").val();
			var email = $("#email").val();
			var address = $("#address").val();
			var cost = $("#cost").val();
			var contactDate = $("#contactDate").val();
			var dueDate = $("#dueDate").val();
			var orderItems = $("#orderItems").val();
			var notes = $("#notes").val();

			//var post_data = {'name':name,'phone':phone,'email':email,'address':address,'cost':cost,'contactDate':contactDate,'dueDate':dueDate,'orderItems':orderItems,'notes':notes};
			var post_data = $("#submitOrderForm").serializeArray();
			var ajaxURL;
			
			if(orderUpdate === false){
				ajaxURL = "insertNewOrder.php";
			}else{
				ajaxURL = "updateOrder.php";
			}
			
            $.ajax({
                    url: ajaxURL,
                    type: "POST",
					dataType: "text",
					data: post_data
                })
                .success(function(data){
                    $("#submitMessage").html("<div class='alert alert-success' role='alert'><b>Congratulations! The form was successfully submitted, <a href='orderGrid.php'>Click Here</a> to see history.</div>");
                    window.location.href = "#submitMessage";
                })
				.fail(function(data){
					$("#submitMessage").html("<div class='alert alert-danger' role='alert'><b>Uh oh! Their was a problem submitting the form</div>");
                    window.location.href = "#submitMessage";
				});
        };
        </script>
		<style>
			.ui-datepicker{ z-index: 9999 !important;}
		</style>
  </head>
<body>
<?php 
	include_once("navbar.php");
?>
<div class="container">

    <span id="submitMessage"></span>

    <div style="background-color: #428bca" class="jumbotron hidden-print">
            <h1 style="color: white" class="hidden-print">Fresh-Bakes Order Form</h1>
	</div>
		<script>
			function generateUUID(){
				var d = new Date().getTime();
				var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
					var r = (d + Math.random()*16)%16 | 0;
					d = Math.floor(d/16);
					return (c=='x' ? r : (r&0x7|0x8)).toString(16);
				});
				return uuid;
			};
		</script>
    
    <div class="page-header hidden-print">
        <h1>Order Form Information <small>Don't forget to save your work!</small></h1>
    </div>
    <form method="POST" id="submitOrderForm"  role="form">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title hidden-print">Customer Information</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label>Customer Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Customer Name">
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <div class="input-group">
                        <span class="input-group-addon">#</span>
                        <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone Number">
                    </div>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <div class="input-group">
                        <span class="input-group-addon">@</span>
                        <input type="text" id="email" name="email" class="form-control" placeholder="Email">
                    </div>
                </div>
                <div class="form-group">
                    <label>Home Address</label>
                    <div class="input-group">
                        <span class="input-group-addon">@</span>
                        <input type="text" id="address" name="address" class="form-control" placeholder="Address">
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title hidden-print">Order Information</h3>
            </div>
            <div class="panel-body">
				<div class="form-group hidden-print">
                    <label>Order Id</label>
                    <div class="input-group">
                        <span class="input-group-addon">#</span>
                        <input type="text" id="uuid" name="uuid" class="form-control" placeholder="UUID" value="">
                    </div>
					<script>
						//Set the unique ID
						$( document ).ready(function() {							
							var uuid;
							uuid = generateUUID();
							var currentUUID = $("#uuid").val();
		
							if(currentUUID == ""){
								$("#uuid").val(uuid);
							}
						});						
					</script>
                </div>
                <div class="form-group">
                    <label>Order Cost</label>
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input type="text" id="cost" name="cost" class="form-control" placeholder="Order Cost">
                    </div>
                </div>
                <div class="form-group">
                    <label>Contact Date</label>
                    <input type="text" id="contactDate" name="contactDate" class="form-control" placeholder="yy/mm/dd">
                </div>
                <div class="form-group">
                    <label>Order Due Date</label>
                    <input type="text" id="dueDate" name="dueDate" class="form-control" placeholder="yy/mm/dd">
                </div>
                <div class="form-group">
                    <label>Order Items</label>
                    <input id="orderItems" name="orderItems" class="form-control">
                </div>
                <div class="form-group">
                    <label>Notes</label>
                    <input id="notes" name="notes" class="form-control">
                </div>
				 <div class="form-group">
                    <label>Paid?</label>
                    <!-- <input id="paid" name="paid" class="form-control"> -->
					<select id="paid" name="paid" class="form-control">
						<option>False</option>
						<option>True</option>						
					</select>
                </div>
            </div>
        </div>
    </form>
    <button onclick="submitForm(event);" class="btn btn-primary hidden-print" id="submitButton"></button>
    <button class="btn btn-danger hidden-print" onclick="clearChanges();">Clear Changes</button>
    <br>
	<script>
		$(function() {
			$( "#contactDate" ).datepicker({ dateFormat: "yy-mm-dd" });
			$( "#dueDate" ).datepicker({ dateFormat: "yy-mm-dd" });
			
			var currentDate = $.datepicker.formatDate('yy-mm-dd', new Date());
			$("#contactDate").val(currentDate);
		});
	</script>
</div>
</body>
</html>
<?php
	include_once("config.php");
	$search = $_GET["search"];
		if($search != ""){
			/* check connection */
			if ($mysqli->connect_errno) {
				printf("Connect failed: %s\n", $mysqli->connect_error);
				exit();
			}else{
				//printf("Connected");
			}
			
			$query = 'SELECT uuid,name,phone,email,address,cost,contactDate,dueDate,orderItems,notes,paid FROM orders WHERE uuid = "'.$search.'"';
				
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
		}else{
			echo("<script>");
			echo("$(\"#submitButton\").text(\"Save Order\");");
			echo("</script>");
		}
?>
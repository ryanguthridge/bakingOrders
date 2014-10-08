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
		function deleteOrder(event){
			event.preventDefault();
			
			var currentUUIDToDelete = $("#uuid").val();

				$.post( "deleteOrder.php", { uuid: currentUUIDToDelete })
                .success(function(data){
				
					$("#submitMessage").html("<div class='alert alert-warning' role='alert'><p align='center'><b>Nice work, ya dingus</b>! The order was successfully deleted, you will be redirected to <a href='orderGrid.php'>Order History</a> in 4 seconds.</p></div>");
						window.location.href = "#submitMessage";
						
					setTimeout(function(){
						window.location.href= "orderGrid.php";
					}, 4000);
                    
                })
				.fail(function(data){
					$("#submitMessage").html("<div class='alert alert-danger' role='alert'><b>Uh oh</b>! Their was a problem deleting the thing!</div>");
                    window.location.href = "#submitMessage";
				});
        };
	</script>
	<script>
		function calculateTotalCost(event){
			
			event.preventDefault();
		
			var interCost = $("#cost").val();
			var interRentalFee = $("#rentalFee").val();
			var interDeliveryFee = $("#deliveryFee").val();
			
			finalCost = parseFloat(interCost);
			finalRentalFee = parseFloat(interRentalFee);
			finalDeliveryFee = parseFloat(interDeliveryFee);
			
			var finalTotalCost;
			var finalTotalCostDec;
			var finalTotalCostWithTax;
			
			finalTotalCost = (finalCost + finalRentalFee + finalDeliveryFee);
			
			var tax = (finalTotalCost * .06);
			var taxDecimal = tax.toFixed(2);
			$("#tax").val(taxDecimal);
			
			finalTotalCostWithTax = parseFloat(finalTotalCost) + parseFloat(taxDecimal);
			
			finalTotalCostDec = finalTotalCostWithTax.toFixed(2);
			
			$("#totalCost").val(finalTotalCostDec);
		};
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
			var totalCost = $("totalCost").val();
			var contactDate = $("#contactDate").val();
			var dueDate = $("#dueDate").val();
			var orderItems = $("orderItems").val();
			var notes = $("#notes").val();
			var deliveryFee = $("deliveryFee").val();
			var rentalFee = $("rentalFee").val();
			var rentalItems = $("rentalItems").val();					
			var paid = $("paid").val();

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
				
					$("#submitMessage").html("<div class='alert alert-success' role='alert'><p align='center'><b>Congratulations</b>! The form was successfully submitted, you will be redirected to <a href='orderGrid.php'>Order History</a> in 4 seconds.</p></div>");
						window.location.href = "#submitMessage";
						
					setTimeout(function(){
						window.location.href= "orderGrid.php";
					}, 4000);
                    
                })
				.fail(function(data){
					$("#submitMessage").html("<div class='alert alert-danger' role='alert'><b>Uh oh</b>! Their was a problem submitting the form</div>");
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
                <h3 class="panel-title hidden-print"><span class="glyphicon glyphicon-user"></span> Customer Information</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label>Customer Name - place an asterisk before the name to indicate a Draft order</label>
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
                <h3 class="panel-title hidden-print"><span class="glyphicon glyphicon-calendar"></span> Order Information</h3>
            </div>
            <div class="panel-body">
				<div class="form-group hidden-print">
                    <label>Order Id</label>
                    <div class="input-group">
                        <span class="input-group-addon">#</span>
                        <input type="text" id="uuid" name="uuid" class="form-control" placeholder="UUID" value="" readonly>
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
                    <label>Contact Date</label>
                    <input type="text" id="contactDate" name="contactDate" class="form-control" placeholder="yy/mm/dd">
                </div>
                <div class="form-group">
                    <label>Order Due Date</label>
                    <input type="text" id="dueDate" name="dueDate" class="form-control" placeholder="yy/mm/dd">
                </div>
                <div class="form-group">
                    <label>Order Items</label>
                    <input id="orderItems" name="orderItems" class="form-control" placeholder="Enter a comma separated list of items here">
                </div>			
				<div class="form-group">
                    <label>Rental Items</label>
                    <input id="rentalItems" name="rentalItems" class="form-control" placeholder="Enter a comma separated list of rental items here">
                </div>			
				<div class="form-group">
                    <label>Notes</label>
                    <input id="notes" name="notes" class="form-control" placeholder="Enter any notes about the order here">
                </div>
				
            </div>
        </div>
		<div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title hidden-print"><span class="glyphicon glyphicon-credit-card"></span> Pricing Information</h3>
            </div>
            <div class="panel-body">
				<div class="form-group">
                    <label>Order Cost</label>
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input type="text" id="cost" name="cost" class="form-control" placeholder="Order Cost">
                    </div>
                </div>
				<div class="form-group">
                    <label>Rental Fee</label>
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input type="text" id="rentalFee" name="rentalFee" class="form-control" placeholder="Rental Fee">
                    </div>
                </div>
				<div class="form-group">
                    <label>Delivery Fee</label>
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input type="text" id="deliveryFee" name="deliveryFee" class="form-control" placeholder="Delivery Fee">
                    </div>
                </div>
				<div class="form-group">
                    <label>Tax</label>
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input type="text" id="tax" name="tax" class="form-control" placeholder="taxes" readonly>
                    </div>
                </div>
				<div class="form-group">
                    <label>Total Cost</label>
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input type="text" id="totalCost" name="totalCost" class="form-control" placeholder="Total Cost">
                    </div>
                </div>
				<button onclick="calculateTotalCost(event);" class="btn btn-success"><span class="glyphicon glyphicon-retweet"></span> Re-calcuate Total & Taxes</button>
				<br>
			</div>
		</div>
		<div id="paidOrNotContainer" class="panel">
            <div class="panel-heading">
                <h3 class="panel-title hidden-print"><span class="glyphicon glyphicon-warning-sign"></span> Payment Received</h3>
            </div>
            <div class="panel-body">
				<div class="form-group">
                    <label>Paid?</label>
                    <!-- <input id="paid" name="paid" class="form-control"> -->
					<select id="paid" name="paid" class="form-control">
						<option>False</option>
						<option>True</option>						
					</select>
                </div>
			</div>
			<script>
				$(function(){
					var paidOrNot = $("#paid").val();
						
					if(paidOrNot === "False"){
						$("#paidOrNotContainer").removeClass("panel-primary");
						$("#paidOrNotContainer").addClass("panel-danger");
					}else{
						$("#paidOrNotContainer").removeClass("panel-danger");
						$("#paidOrNotContainer").addClass("panel-primary");
					}
					
					//Make this page active
					$("#newOrderListItem").addClass("active");
					$("#orderGridListItem").removeClass("active");
					$("#orderHistoryListItem").removeClass("active");					
				});
			</script>
		</div>
    </form>
    <button onclick="submitForm(event);" class="btn btn-primary hidden-print" id="submitButton"></button>
    <button class="btn btn-warning hidden-print" onclick="clearChanges();">Clear Changes</button>
	<button class="btn btn-danger hidden-print" onclick="deleteOrder(event);"><span class="glyphicon glyphicon-trash"></span></button>
    <br><br class="hidden-print">
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
	$search = $_GET["search"];
		if($search != ""){
		
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
		}else{
			echo("<script>");			
			echo("$(\"#submitButton\").text(\"Save Order\");");
			echo("</script>");
		}
?>
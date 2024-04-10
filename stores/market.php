<?php 
session_start();
require "../action.php"; $action = new Action();
$username = $_SESSION["username"];
$clientID = $action->clientID($username);
if($action->isUser($clientID) == 0) {
    $action->redirect_to("../login");
}
else if($action->bankAccount_row($clientID) == 0) {
    $action->redirect_to("bankAccount");
}
else if($action->isMember_ban($clientID) != 2) {
    ?>
    <script>
        alert("You are banned");
        window.location = "../login";
    </script>
<?php }

$sms_username = 'toprate247';
$sms_password = 'pelumi';

$senderid = "toprate247";
$mobile = $action->adminGSM();

?>
<!doctype html>
<html class="no-js h-100" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Market Place - Toprate 247</title>
    <meta name="description" content="A high-quality &amp; free Bootstrap admin dashboard template pack that comes with lots of templates and components.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="styles/shards-dashboards.1.1.0.min.css">
    <link rel="stylesheet" href="styles/extras.1.1.0.min.css">
    <link rel="stylesheet" href="styles/styles.css">
	
	<link rel="stylesheet" href="https://use.fontawesome.com/0acf54d04e.css">

    <style>
        .progress {
            height: 20px;
            margin-bottom: 20px;
            overflow: hidden;
            background-color: #f5f5f5;
            border-radius: 4px;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);
        }
        .progress-bar.active {
        	animation: progress-bar-stripes 2s linear infinite;
        }
        .progress-bar {
            font-size: 18px;
            font-weight: bolder;
        	float: left;
            height: 100%;
            line-height: 20px;
            color: #fff;
            text-align: center;
            background-color: #428bca;
            box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .15);
            transition: width .6s ease;
        }
        
        .progress-bar-striped {
        	background-size: 40px 40px;
        	background-image: linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        }
		.list-group-item {
			font-weight: 300;
			font-family: times;
		}
		
        .img_card_procedure {
            background: url(../images/cardLc.png) no-repeat;
            margin-top: 10px;
            cursor: pointer;
            height: 320px;
        }
		
		#preview {
            border: 1px solid #F1F1F1; margin-top: 10px; height: 250px; padding: 10px; overflow-y: scroll;
        }
		#head {
            <!--background: #007bff;-->
        }
        th{
            vertical-align: bottom;
            font-size: 10px;
        }
        .table-striped > tbody > tr:nth-child(2n) {
            background: #3C3C3C;
            color: #fff;
        }
    </style>
	
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
	
	<script>
	$(document).ready(function() {
		$('#example').DataTable();
		
		$("#reset").click(function(e){
			e.preventDefault();
			$("#preview").find('img').not().remove();
			$("#file-input").val("");
			$('#preview').hide();
		});

		$("#cardType").on('change', function () {
			var fetchVal = $("#fetchVal");
		   if($(this).val() == "") {
			   alert("Please select card type");
			   fetchVal.html("");
		   } else {
			   var data = "fetchVal="+$(this).val();
			   $.ajax({
				   url: "../actionHandler?fetchCardType",
				   data: data,
				   type: "post",
				   beforeSend: function(){
					   fetchVal.html("<div style='font-weight: bold'><br>Please wait <i class='fa fa-spinner fa-spin'></i></div>");
				   },
				   success: function (msg) {
					   setTimeout(function () {
						   fetchVal.html(msg);
					   }, 2000);
				   }
			   })
		   }
		});

		$("#cardType").on('change', function () {
			var cardPricediv = $("#cardPricediv");
		   if($(this).val() == "") {
			   cardPricediv.html("");
		   } else {
			   var data = "fetchVal="+$(this).val();
			   $.ajax({
				   url: "../actionHandler?cardPrice",
				   data: data,
				   type: "post",
				   beforeSend: function(){
					   cardPricediv.html("<div style='font-weight: bold'><br>Please wait <i class='fa fa-spinner fa-spin'></i></div>");
				   },
				   success: function (msg) {
					   setTimeout(function () {
						   cardPricediv.html(msg);
					   }, 2000);
				   }
			   })
		   }
		});
	});

	//Function for returning cost of each itunes card
	function getitunesCost() {
		var sumOFArray = 0;
		var prevalue = 0;
		var itunesSum = $("#itunesSum");
		var prevalue = $("#itunesValue").val(); //<-- Iteration 1 prevalue is an array
		prevalue = prevalue.replace("$", "");
		var temp = new Array(); // Convert it to array
		temp = prevalue.split(",");
		// $("#priceNaira").val(temp);
		for (i = 0; i < temp.length; i++) { //iteration1 : it looks for array.length
			sumOFArray += parseInt(temp[i]); //Changes the variable shared by the loop to string from array and string also has its length. And next time onwards it adds to itself a char from the string and length increases and loop goes infinitely.
		}

		var amount_sum = sumOFArray;
		if(amount_sum == 0 ||  amount_sum < 10) {
			itunesSum.html("");
			$("#ituneNaira").val("");
		} else if(prevalue == ""){
			itunesSum.html("");
			$("#ituneNaira").val("");
		} else {
			var itunecost = 1;
			<?php
			$currency = "&#8358;";
			$costTable2 = $action->itunesPrice();
			$searchKeys = array('\r\n','\n',"\n","\r\n");
			$costTable2 = str_replace( $searchKeys , '<br />' , $costTable2);
			$costTable = explode("<br />",$costTable2);
			$z = array();
			$costTable2 = array();
			for($i=0; $i<count($costTable); $i++){
				$x=explode("=",$costTable[$i]);
				$y=explode("=",$x[1]);
				$z[] = "if(amount_sum >= ".$x[0].") unitcost = ".$y[0].";";
				$costTable2[] = number_format($x[0],0).' - '.number_format($y[0],0).' = '.$currency.$y[1].' per unit';
			}
			$costTable2 = implode('<br />',$costTable2);
			echo implode(" ",$z);
			?>
			itunesSum.html('<?php echo $currency; ?>'+transMoney(unitcost*100, 0)+"/$100"+'<br><?php echo "Total: ".$currency; ?>'+transMoney(Math.ceil(amount_sum*unitcost),0));
			//Save the value in an input field
			$("#ituneNaira").val(Math.ceil(amount_sum*unitcost));
			return true;
		}
	}

	//Function for returning cost of each itunes card
	function get200Cost() {
		var sumOFArray = 0;
		var prevalue = 0;
		var itunesSum = $("#itunesSum");
		var prevalue = $("#single200Value").val(); //<-- Iteration 1 prevalue is an array
		prevalue = prevalue.replace("$", "");
		var temp = new Array(); // Convert it to array
		temp = prevalue.split(",");
		// $("#priceNaira").val(temp);
		for (i = 0; i < temp.length; i++) { //iteration1 : it looks for array.length
			sumOFArray += parseInt(temp[i]); //Changes the variable shared by the loop to string from array and string also has its length. And next time onwards it adds to itself a char from the string and length increases and loop goes infinitely.
		}

		var amount_sum = sumOFArray;
		if(amount_sum == 0 ||  amount_sum < 10) {
			itunesSum.html("");
			$("#ituneNaira").val("");
		} else if(prevalue == ""){
			itunesSum.html("");
			$("#ituneNaira").val("");
		} else {
			var itunecost = 1;
			<?php
			$currency = "&#8358;";
			$costTable2 = $action->singlecardPrice();
			$searchKeys = array('\r\n','\n',"\n","\r\n");
			$costTable2 = str_replace( $searchKeys , '<br />' , $costTable2);
			$costTable = explode("<br />",$costTable2);
			$z = array();
			$costTable2 = array();
			for($i=0; $i<count($costTable); $i++){
				$x=explode("=",$costTable[$i]);
				$y=explode("=",$x[1]);
				$z[] = "if(amount_sum >= ".$x[0].") unitcost = ".$y[0].";";
				$costTable2[] = number_format($x[0],0).' - '.number_format($y[0],0).' = '.$currency.$y[1].' per unit';
			}
			$costTable2 = implode('<br />',$costTable2);
			echo implode(" ",$z);
			?>
			itunesSum.html('<?php echo $currency; ?>'+transMoney(unitcost*100, 0)+"/$100"+'<br><?php echo "Total: ".$currency; ?>'+transMoney(Math.ceil(amount_sum*unitcost),0));
			//Save the value in an input field
			$("#ituneNaira").val(Math.ceil(amount_sum*unitcost));
			return true;
		}
	}

	//Function for returning cost of each itunes card
	function getAustraliaCost() {
		var sumOFArray = 0;
		var prevalue = 0;
		var itunesSum = $("#itunesSum");
		var prevalue = $("#austriaValue").val(); //<-- Iteration 1 prevalue is an array
		prevalue = prevalue.replace("$", "");
		var temp = new Array(); // Convert it to array
		temp = prevalue.split(",");
		// $("#priceNaira").val(temp);
		for (i = 0; i < temp.length; i++) { //iteration1 : it looks for array.length
			sumOFArray += parseInt(temp[i]); //Changes the variable shared by the loop to string from array and string also has its length. And next time onwards it adds to itself a char from the string and length increases and loop goes infinitely.
		}

		var amount_sum = sumOFArray;
		if(amount_sum == 0 ||  amount_sum < 10) {
			itunesSum.html("");
			$("#ituneNaira").val("");
		} else if(prevalue == ""){
			itunesSum.html("");
			$("#ituneNaira").val("");
		} else {
			var itunecost = 1;
			<?php
			$currency = "&#8358;";
			$costTable2 = $action->australiaPrice();
			$searchKeys = array('\r\n','\n',"\n","\r\n");
			$costTable2 = str_replace( $searchKeys , '<br />' , $costTable2);
			$costTable = explode("<br />",$costTable2);
			$z = array();
			$costTable2 = array();
			for($i=0; $i<count($costTable); $i++){
				$x=explode("=",$costTable[$i]);
				$y=explode("=",$x[1]);
				$z[] = "if(amount_sum >= ".$x[0].") unitcost = ".$y[0].";";
				$costTable2[] = number_format($x[0],0).' - '.number_format($y[0],0).' = '.$currency.$y[1].' per unit';
			}
			$costTable2 = implode('<br />',$costTable2);
			echo implode(" ",$z);
			?>
			itunesSum.html('<?php echo $currency; ?>'+transMoney(unitcost*100, 0)+"/$100"+'<br><?php echo "Total: ".$currency; ?>'+transMoney(Math.ceil(amount_sum*unitcost),0));
			//Save the value in an input field
			$("#ituneNaira").val(Math.ceil(amount_sum*unitcost));
			return true;
		}
	}

	//Function for returning cost of each itunes card
	function getCanadaCost() {
		var sumOFArray = 0;
		var prevalue = 0;
		var itunesSum = $("#itunesSum");
		var prevalue = $("#canadaValue").val(); //<-- Iteration 1 prevalue is an array
		prevalue = prevalue.replace("$", "");
		var temp = new Array(); // Convert it to array
		temp = prevalue.split(",");
		// $("#priceNaira").val(temp);
		for (i = 0; i < temp.length; i++) { //iteration1 : it looks for array.length
			sumOFArray += parseInt(temp[i]); //Changes the variable shared by the loop to string from array and string also has its length. And next time onwards it adds to itself a char from the string and length increases and loop goes infinitely.
		}

		var amount_sum = sumOFArray;
		if(amount_sum == 0 ||  amount_sum < 10) {
			itunesSum.html("");
			$("#ituneNaira").val("");
		} else if(prevalue == ""){
			itunesSum.html("");
			$("#ituneNaira").val("");
		} else {
			var itunecost = 1;
			<?php
			$currency = "&#8358;";
			$costTable2 = $action->canadianPrice();
			$searchKeys = array('\r\n','\n',"\n","\r\n");
			$costTable2 = str_replace( $searchKeys , '<br />' , $costTable2);
			$costTable = explode("<br />",$costTable2);
			$z = array();
			$costTable2 = array();
			for($i=0; $i<count($costTable); $i++){
				$x=explode("=",$costTable[$i]);
				$y=explode("=",$x[1]);
				$z[] = "if(amount_sum >= ".$x[0].") unitcost = ".$y[0].";";
				$costTable2[] = number_format($x[0],0).' - '.number_format($y[0],0).' = '.$currency.$y[1].' per unit';
			}
			$costTable2 = implode('<br />',$costTable2);
			echo implode(" ",$z);
			?>
			itunesSum.html('<?php echo $currency; ?>'+transMoney(unitcost*100, 0)+"/$100"+'<br><?php echo "Total: ".$currency; ?>'+transMoney(Math.ceil(amount_sum*unitcost),0));
			//Save the value in an input field
			$("#ituneNaira").val(Math.ceil(amount_sum*unitcost));
			return true;
		}
	}

	//Function for returning cost of each itunes card
	function getSteamCost() {
		var sumOFArray = 0;
		var prevalue = 0;
		var itunesSum = $("#steamSum");
		var prevalue = $("#steamValue").val(); //<-- Iteration 1 prevalue is an array
		prevalue = prevalue.replace("$", "");
		var temp = new Array(); // Convert it to array
		temp = prevalue.split(",");
		// $("#priceNaira").val(temp);
		for (i = 0; i < temp.length; i++) { //iteration1 : it looks for array.length
			sumOFArray += parseInt(temp[i]); //Changes the variable shared by the loop to string from array and string also has its length. And next time onwards it adds to itself a char from the string and length increases and loop goes infinitely.
		}

		var amount_sum = sumOFArray;
		if(amount_sum == 0 ||  amount_sum < 10) {
			itunesSum.html("");
			$("#steamNaira").val("");
		} else if(prevalue == ""){
			itunesSum.html("");
			$("#steamNaira").val("");
		} else {
			var itunecost = 1;
			<?php
			$currency = "&#8358;";
			$costTable2 = $action->steamPrice();
			$searchKeys = array('\r\n','\n',"\n","\r\n");
			$costTable2 = str_replace( $searchKeys , '<br />' , $costTable2);
			$costTable = explode("<br />",$costTable2);
			$z = array();
			$costTable2 = array();
			for($i=0; $i<count($costTable); $i++){
				$x=explode("=",$costTable[$i]);
				$y=explode("=",$x[1]);
				$z[] = "if(amount_sum >= ".$x[0].") unitcost = ".$y[0].";";
				$costTable2[] = number_format($x[0],0).' - '.number_format($y[0],0).' = '.$currency.$y[1].' per unit';
			}
			$costTable2 = implode('<br />',$costTable2);
			echo implode(" ",$z);
			?>
			itunesSum.html('<?php echo $currency; ?>'+transMoney(unitcost*100, 0)+"/$100"+'<br><?php echo "Total: ".$currency; ?>'+transMoney(Math.ceil(amount_sum*unitcost),0));
			//Save the value in an input field
			$("#steamNaira").val(Math.ceil(amount_sum*unitcost));
			return true;
		}
	}

	//Function for returning cost of each itunes card
	function getGooglePlayCost() {
		var sumOFArray = 0;
		var prevalue = 0;
		var itunesSum = $("#steamSum");
		var prevalue = $("#gplayValue").val(); //<-- Iteration 1 prevalue is an array
		prevalue = prevalue.replace("$", "");
		var temp = new Array(); // Convert it to array
		temp = prevalue.split(",");
		// $("#priceNaira").val(temp);
		for (i = 0; i < temp.length; i++) { //iteration1 : it looks for array.length
			sumOFArray += parseInt(temp[i]); //Changes the variable shared by the loop to string from array and string also has its length. And next time onwards it adds to itself a char from the string and length increases and loop goes infinitely.
		}

		var amount_sum = sumOFArray;
		if(amount_sum == 0 ||  amount_sum < 10) {
			itunesSum.html("");
			$("#steamNaira").val("");
		} else if(prevalue == ""){
			itunesSum.html("");
			$("#steamNaira").val("");
		} else {
			var itunecost = 1;
			<?php
			$currency = "&#8358;";
			$costTable2 = $action->googlePlayPrice();
			$searchKeys = array('\r\n','\n',"\n","\r\n");
			$costTable2 = str_replace( $searchKeys , '<br />' , $costTable2);
			$costTable = explode("<br />",$costTable2);
			$z = array();
			$costTable2 = array();
			for($i=0; $i<count($costTable); $i++){
				$x=explode("=",$costTable[$i]);
				$y=explode("=",$x[1]);
				$z[] = "if(amount_sum >= ".$x[0].") unitcost = ".$y[0].";";
				$costTable2[] = number_format($x[0],0).' - '.number_format($y[0],0).' = '.$currency.$y[1].' per unit';
			}
			$costTable2 = implode('<br />',$costTable2);
			echo implode(" ",$z);
			?>
			itunesSum.html('<?php echo $currency; ?>'+transMoney(unitcost*100, 0)+"/$100"+'<br><?php echo "Total: ".$currency; ?>'+transMoney(Math.ceil(amount_sum*unitcost),0));
			//Save the value in an input field
			$("#steamNaira").val(Math.ceil(amount_sum*unitcost));
			return true;
		}
	}


	//Function for returning cost of each amazon card
	function getamazonCost() {
		var amazonSum = $("#amazonSum");
		var sumOFArray = 0;
		var prevalue = 0;
		var prevalue = $("#amazonValue").val(); //<-- Iteration 1 prevalue is an array
		prevalue = prevalue.replace("$", "");
		var temp = new Array(); // Convert it to array
		temp = prevalue.split(",");
		// $("#priceNaira").val(temp);
		for (i = 0; i < temp.length; i++) { //iteration1 : it looks for array.length
			sumOFArray += parseInt(temp[i]); //Changes the variable shared by the loop to string from array and string also has its length. And next time onwards it adds to itself a char from the string and length increases and loop goes infinitely.
		}


		var amount_sum = sumOFArray;
		if(amount_sum == 0 ||  amount_sum < 10) {
			amazonSum.html("");
			$("#amazonNaira").val("");
		} else if(prevalue == ""){
			amazonSum.html("");
			$("#amazonNaira").val("");
		} else {
			var itunecost = 1;
			<?php
			$currency = "&#8358;";
			$costTable2 = $action->amazonPrice();
			$searchKeys = array('\r\n','\n',"\n","\r\n");
			$costTable2 = str_replace( $searchKeys , '<br />' , $costTable2);
			$costTable = explode("<br />",$costTable2);
			$z = array();
			$costTable2 = array();
			for($i=0; $i<count($costTable); $i++){
				$x=explode("=",$costTable[$i]);
				$y=explode("=",$x[1]);
				$z[] = "if(amount_sum >= ".$x[0].") unitcost = ".$y[0].";";
				$costTable2[] = number_format($x[0],0).' - '.number_format($y[0],0).' = '.$currency.$y[1].' per unit';
			}
			$costTable2 = implode('<br />',$costTable2);
			echo implode(" ",$z);
			?>
			amazonSum.html('<?php echo $currency; ?>'+transMoney(unitcost*100, 0)+"/$100"+'<br><?php echo "Total: ".$currency; ?>'+transMoney(Math.ceil(amount_sum*unitcost),0));
			//Save the value in an input field
			$("#amazonNaira").val(Math.ceil(amount_sum*unitcost));
			return true;
		}
	}


	//Function for returning cost of each amazon card
	function getamazonNoReceiptCost() {
		var amazonSum = $("#amazonSum");
		var sumOFArray = 0;
		var prevalue = 0;
		var prevalue = $("#amazonValue").val(); //<-- Iteration 1 prevalue is an array
		prevalue = prevalue.replace("$", "");
		var temp = new Array(); // Convert it to array
		temp = prevalue.split(",");
		// $("#priceNaira").val(temp);
		for (i = 0; i < temp.length; i++) { //iteration1 : it looks for array.length
			sumOFArray += parseInt(temp[i]); //Changes the variable shared by the loop to string from array and string also has its length. And next time onwards it adds to itself a char from the string and length increases and loop goes infinitely.
		}


		var amount_sum = sumOFArray;
		if(amount_sum == 0 ||  amount_sum < 10) {
			amazonSum.html("");
			$("#amazonNaira").val("");
		} else if(prevalue == ""){
			amazonSum.html("");
			$("#amazonNaira").val("");
		} else {
			var itunecost = 1;
			<?php
			$currency = "&#8358;";
			$costTable2 = $action->amazonNoReceiptPrice();
			$searchKeys = array('\r\n','\n',"\n","\r\n");
			$costTable2 = str_replace( $searchKeys , '<br />' , $costTable2);
			$costTable = explode("<br />",$costTable2);
			$z = array();
			$costTable2 = array();
			for($i=0; $i<count($costTable); $i++){
				$x=explode("=",$costTable[$i]);
				$y=explode("=",$x[1]);
				$z[] = "if(amount_sum >= ".$x[0].") unitcost = ".$y[0].";";
				$costTable2[] = number_format($x[0],0).' - '.number_format($y[0],0).' = '.$currency.$y[1].' per unit';
			}
			$costTable2 = implode('<br />',$costTable2);
			echo implode(" ",$z);
			?>
			amazonSum.html('<?php echo $currency; ?>'+transMoney(unitcost*100, 0)+"/$100"+'<br><?php echo "Total: ".$currency; ?>'+transMoney(Math.ceil(amount_sum*unitcost),0));
			//Save the value in an input field
			$("#amazonNaira").val(Math.ceil(amount_sum*unitcost));
			return true;
		}
	}


	//Function for returning bitcoin
	function getbitcoinCost() {
		var priceNairaInput = $("#priceNairaInput");
		var priceNaira = $("#priceNaira");
		var sumOFArray = 0;
		var prevalue = 0;
		var prevalue = $("#bitcoinAmount").val(); //<-- Iteration 1 prevalue is an array
		prevalue = prevalue.replace("$","");

		var temp = new Array(); // Convert it to array
		temp = prevalue.split(",");
		// $("#priceNaira").val(temp);
		for (i = 0; i < temp.length; i++) { //iteration1 : it looks for array.length
			sumOFArray += parseInt(temp[i]); //Changes the variable shared by the loop to string from array and string also has its length. And next time onwards it adds to itself a char from the string and length increases and loop goes infinitely.
		}
		var amount_sum = sumOFArray;


		if(amount_sum == 0 ||  amount_sum < 1) {
			priceNaira.val("");
			priceNairaInput.val("");
		} else if(prevalue == ""){
			$("#priceNaira").val("");
			$("#priceNairaInput").val("");
		} else {
			<?php
			$costTable2 = $action->btcPrice();
			$searchKeys = array('\r\n','\n',"\n","\r\n");
			$costTable2 = str_replace( $searchKeys , '<br />' , $costTable2);
			$costTable = explode("<br />",$costTable2);
			$z = array();
			$costTable2 = array();
			for($i=0; $i<count($costTable); $i++){
				$x=explode("=",$costTable[$i]);
				$y=explode("=",$x[1]);
				$z[] = "if(amount_sum >= ".$x[0].") unitcost = ".$y[0].";";
				$costTable2[] = number_format($x[0],0).' - '.number_format($y[0],0).' = '.$y[1].' per unit';
			}
			$costTable2 = implode('<br />',$costTable2);
			echo implode(" ",$z);

			$costTable2 = implode('<br />',$costTable2);
			?>
			priceNaira.val(Math.ceil(amount_sum*unitcost));
			priceNairaInput.val(Math.ceil(amount_sum*unitcost));
		}
	}

	//Function for returning itunes ecode
	function getitunesEcodeCost() {
		var priceNairaInput = $("#priceNairaInput");
		var priceNaira = $("#priceNaira");
		var sumOFArray = 0;
		var prevalue = 0;
		var prevalue = $("#bitcoinAmount").val(); //<-- Iteration 1 prevalue is an array
		prevalue = prevalue.replace("$","");

		var temp = new Array(); // Convert it to array
		temp = prevalue.split(",");
		// $("#priceNaira").val(temp);
		for (i = 0; i < temp.length; i++) { //iteration1 : it looks for array.length
			sumOFArray += parseInt(temp[i]); //Changes the variable shared by the loop to string from array and string also has its length. And next time onwards it adds to itself a char from the string and length increases and loop goes infinitely.
		}
		var amount_sum = sumOFArray;

		if(amount_sum == 0 ||  amount_sum < 1) {
			priceNaira.val("");
			priceNairaInput.val("");
		} else if(prevalue == ""){
			$("#priceNaira").val("");
			$("#priceNairaInput").val("");
		} else {
			<?php
			$costTable2 = $action->ecodePrice();
			$searchKeys = array('\r\n','\n',"\n","\r\n");
			$costTable2 = str_replace( $searchKeys , '<br />' , $costTable2);
			$costTable = explode("<br />",$costTable2);
			$z = array();
			$costTable2 = array();
			for($i=0; $i<count($costTable); $i++){
				$x=explode("=",$costTable[$i]);
				$y=explode("=",$x[1]);
				$z[] = "if(amount_sum >= ".$x[0].") unitcost = ".$y[0].";";
				$costTable2[] = number_format($x[0],0).' - '.number_format($y[0],0).' = '.$y[1].' per unit';
			}
			$costTable2 = implode('<br />',$costTable2);
			echo implode(" ",$z);

			$costTable2 = implode('<br />',$costTable2);
			?>
			priceNaira.val(Math.ceil(amount_sum*unitcost));
			priceNairaInput.val(Math.ceil(amount_sum*unitcost));
		}
	}


	//Function for returning cost of each itunes card
	function getNoAmntItunesCost() {
		var sumOFArray = 0;
		var prevalue = 0;
		var itunesSum = $("#itunesSum");
		var prevalue = $("#itunesValue").val(); //<-- Iteration 1 prevalue is an array
		prevalue = prevalue.replace("$","");
		var temp = new Array(); // Convert it to array
		temp = prevalue.split(",");
		// $("#priceNaira").val(temp);
		for (i = 0; i < temp.length; i++) { //iteration1 : it looks for array.length
			sumOFArray += parseInt(temp[i]); //Changes the variable shared by the loop to string from array and string also has its length. And next time onwards it adds to itself a char from the string and length increases and loop goes infinitely.
		}

		var amount_sum = sumOFArray;
		if(amount_sum == 0 ||  amount_sum < 10) {
			itunesSum.html("");
			$("#ituneNaira").val("");
		} else if(prevalue == ""){
			itunesSum.html("");
			$("#ituneNaira").val("");
		} else {
			var itunecost = 1;
			<?php
			$currency = "&#8358;";
			$costTable2 = $action->no_amountItunes();
			$searchKeys = array('\r\n','\n',"\n","\r\n");
			$costTable2 = str_replace( $searchKeys , '<br />' , $costTable2);
			$costTable = explode("<br />",$costTable2);
			$z = array();
			$costTable2 = array();
			for($i=0; $i<count($costTable); $i++){
				$x=explode("=",$costTable[$i]);
				$y=explode("=",$x[1]);
				$z[] = "if(amount_sum >= ".$x[0].") unitcost = ".$y[0].";";
				$costTable2[] = number_format($x[0],0).' - '.number_format($y[0],0).' = '.$currency.$y[1].' per unit';
			}
			$costTable2 = implode('<br />',$costTable2);
			echo implode(" ",$z);
			?>
			itunesSum.html('<?php echo $currency; ?>'+transMoney(unitcost*100, 0)+"/$100"+'<br><?php echo "Total: ".$currency; ?>'+transMoney(Math.ceil(amount_sum*unitcost),0));
			//Save the value in an input field
			$("#ituneNaira").val(Math.ceil(amount_sum*unitcost));
			return true;
		}
	}
	
	function transMoney(s, n) {
		n = n >= 0 && n <= 20 ? n : 2;
		s = parseFloat((s + "").replace(/[^\d\.-]/g, "")).toFixed(n) + "";
		var l = s.split(".")[0].split("").reverse(), r = s.split(".")[1];
		t = "";
		for (i = 0; i < l.length; i++) {
			t += l[i] + ((i + 1) % 3 == 0 && (i + 1) != l.length ? "," : "");
		}
		if(r){
			return t.split("").reverse().join("") + "." + r;
		}else {
			return t.split("").reverse().join("")
		}
	}
	
    </script>
  </head>
  <body class="h-100">
    <div class="container-fluid">
      <div class="row">
        <!-- Main Sidebar -->
        <aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
          <div class="main-navbar">
            <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
              <a class="navbar-brand w-100 mr-0" href="dashboard" style="line-height: 25px;">
                <div class="d-table m-auto">
                  <img id="main-logo" class="d-inline-block align-top mr-1" style="max-width: 25px;" src="images/shards-dashboards-logo.svg" alt="Shards Dashboard">
                  <span class="d-none d-md-inline ml-1">Toprate 247</span>
                </div>
              </a>
              <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                <i class="material-icons">&#xE5C4;</i>
              </a>
            </nav>
          </div>
		  
			<div class="nav-wrapper"> 
		  
				<ul class="nav flex-column">
				  <li class="nav-item">
					<a class="nav-link" href="dashboard">
					  <i class="material-icons">home</i>
					  <span>Dashboard</span>
					</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" href="userAccount">
					  <i class="fa fa-user"></i>
					  <span>My Account</span>
					</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" href="wallet">
					  <i class="fa fa-money"></i>
					  <span>My Wallet</span>
					</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link active" href="market">
					  <i class="material-icons">shop</i>
					  <span>Sell Gift Card</span>
					</a>
				  </li>
				  
				  <?php if($action->userType($clientID) == 2 || $action->userType($clientID) == 3) { ?>
					  <li class="nav-item">
						<a class="nav-link " href="store">
						  <i class="fa fa-dashboard"></i>
						  <span>Admin Panel</span>
						</a>
					  </li>
				  <?php } ?>
				  <li class="nav-item">
					<a class="nav-link " href="logout">
					  <i class="fa fa-sign-out"></i>
					  <span>Log Out</span>
					</a>
				  </li>
				</ul>
			</div>
        </aside>
        <!-- End Main Sidebar -->
        <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3" style="background: #fff">
          <div class="main-navbar sticky-top bg-white">
            <!-- Main Navbar -->
            <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
              <form action="#" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex" style="visibility: hidden">
                <div class="input-group input-group-seamless ml-3">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fas fa-search"></i>
                    </div>
                  </div>
                  <input class="navbar-search form-control" type="text" placeholder="Search for something..." aria-label="Search"> </div>
              </form>
              <ul class="navbar-nav border-left flex-row ">
                
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img class="user-avatar rounded-circle mr-2" src="images/avatars/0.jpg" alt="User Avatar">
                    <span class="d-none d-md-inline-block"><?php echo ucfirst($username);?></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-small">
                    <a class="dropdown-item" href="wallet">
                      <i class="material-icons">&#xE7FD;</i> My Wallet</a>
                    <a class="dropdown-item" href="userAccount">
                      <i class="fa fa-user"></i> Edit Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="logout">
                      <i class="fa fa-sign-out text-danger"></i> Logout </a>
                  </div>
                </li>
              </ul>
              <nav class="nav">
                <a href="#" class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left" data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
                  <i class="material-icons">&#xE5D2;</i>
                </a>
              </nav>
            </nav>
          </div>
          <!-- / .main-navbar -->
          <div class="main-content-container container-fluid px-4">
            <?php require "userhead.php";
			if($action->isClient_Blocked4Trans($clientID) == 1) {
				echo $action->error("You currently have a pending transaction awaiting confirmation");
			} else if(isset($_REQUEST["sell_itunes"])){
				
				if(isset($_POST["upload_itunes"])) {
					$cardAmount = str_replace("$", "", str_replace(array(" ","  "), ",",$_POST["cardAmount"]));
					$ituneNaira = $_POST["ituneNaira"];
					$userRemark = $_POST["userRemark"];
					//echo $cardAmount;
					//die();
					if(empty($cardAmount)) {
						echo $action->error("Enter card value");
					} else if($cardAmount < 10) {
						echo $action->error("Minimum card value is &#36;5");
					} else {
						$fileinput_name = $_FILES["file-input"]["name"];
						$fileinput_tmpname = $_FILES["file-input"]["tmp_name"];
						// count the total number of files that was selected by the user.
						$count_file_num = count($fileinput_name);

						//Declare a variable to hold invalid file number count...
						$invalid = 0;
						$i = 1;
						$allowed = array("jpg", "jpeg", "png", "gif", "bmp");

						foreach ($fileinput_name as $fileName) {
							$rand = rand(111, 987);
							$pathinfo = pathinfo($fileName);
							$extension_file = strtolower($pathinfo["extension"]);
							if (!in_array($extension_file, $allowed)) {
								$invalid++;
								// echo $extension_file . "<br>";
							} else {
								$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
								$charactersLength = strlen($characters);
								$randomString = '';
								for ($i = 0; $i < 1; $i++) {
									$randomString .= strtoupper($characters[rand(0, $charactersLength - 1)]);
								}
								$string = strtolower(str_replace(array("I", "O"), "P", $randomString));
								if (is_numeric(substr(sha1(md5($rand)), 0, 1))) {
									$value = $string . substr(sha1(md5($rand)), 1, 7) . ".jpg";
									// echo substr(sha1(md5($rand)), 0,1). " || ". substr(sha1(md5($rand)), 0,7) . " || " . $i++ . " || " . $value . "<br>";
								} else {
									$value = substr(sha1(md5($rand)), 0, 7) . ".jpg";
								}
								$combineFiles[] = $value;
								// echo strlen($value) . "<br>";
							}
						}
						$leftFiles = $count_file_num - $invalid;
						if ($leftFiles == 0) {
							echo $action->error("Invalid file was selected");
						} else {
							$moveFileCount = 0;
							if ($leftFiles != 0 && $invalid != 0) {

								foreach ($combineFiles as $key => $val) {
									$joinfile = "../images/market/" . $val;
									if (move_uploaded_file($fileinput_tmpname[$key], $joinfile)) {
										$moveFileCount++;
									}
								}
							} else if ($leftFiles != 0 && $invalid == 0) {
								foreach ($combineFiles as $key => $val) {
									$joinfile = "../images/market/" . $val;
									if (move_uploaded_file($fileinput_tmpname[$key], $joinfile)) {
										$moveFileCount++;
									}
								}
							}
							if ($moveFileCount > 0) {

								$jCard = explode(",", $cardAmount);
								$totalCardAmnt = array_sum($jCard);

								//Mail Admins...
								$admins_mail[] = "toprate247247@gmail.com";
								$admins_mail[] = "oluwatayoadeyemi@yahoo.com";


								// set content type header for html email
								$headers = 'MIME-Version: 1.0' . "\r\n";
								$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
								// set additional headers
								$headers .= 'From:  noreply@toprate247.com <noreply@toprate247.com>' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
								$subject = $_POST["cardType"] . " Order";
								$body = "<html>
				<head>
				<title>ORDER NOTIFICATION</title>
				</head>
				<body><div>
				<div style='font-family:arial;border:1px solid #c0c0c0;padding:15px;border-radius:5px;'>
				<div style='font-size:40px;color:darkblue;font-weight:bold;'>iTunes Order</div>
				A client just submitted an " . $_POST["cardType"] . " card worth usd" . $totalCardAmnt . " which is equivalent to NGN" . number_format($ituneNaira) . ".
				<br><br>
				Kindly check the order asap.
				</div></div></body></html>";

								$message = "Dear Admin, you have a new order, Kindly check the order asap.";

								$file = "http://connectsms.net/components/com_smsreseller/smsapi.php?";
								$data = "username=" . $sms_username . "&password=" . $sms_password . "&sender=" . $senderid . "&recipient=" . $mobile . "&message=" . $message;
								$joinfiledata = $file . $data;
								$ch = curl_init($file);
								curl_setopt($ch, CURLOPT_POST, 1);
								curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								$data = curl_exec($ch);
								curl_close($ch);
								foreach ($admins_mail as $adminsmail) {
									mail($adminsmail, $subject, $body, $headers);
								}

								//Responses....
								$response["txid"] = substr(md5(rand(111, 987)), 0, 10);
								$response["amountDollar"] = $totalCardAmnt;
								$response["cardNo"] = $leftFiles;
								$response["amountNaira"] = $ituneNaira;
								$response["userRemark"] = $userRemark;
								// $jsonResponse = json_encode($response);
								$jsonResponse = addslashes(json_encode($response));
								$response = $jsonResponse;

								$images = implode(",", $combineFiles);
								$type = $_POST["cardType"];
								if ($action->saveCardUpload($clientID, $images, $cardAmount, $type, $response)) {
									if ($invalid > 0) {
										echo $action->success("order received, Goto dashboard to check your card status. " . $invalid . " card(s) was removed");
									} else if ($invalid == 0) {
										echo $action->success("Order received, Goto dashboard to check your card status");
									}
								} else {
									echo $action->error("We're unable to process your request");
								}
								//We need to mail user that card was received.

							} else {
								echo $action->error("Error uploading card");
							}
						}
					}
				} ?>
				
				<div align='center' style="margin-bottom: 2%; margin-top: 2%;">
					<h3 style="font-size: 2.5rem; font-weight: 900">iTunes Market Place</h3>
				</div>
				
				<div class="row">
					<div class="col-lg-4">
						<p class="img_card_procedure"></p>
					</div>
					<div class="col-lg-8">
						<h2 class="yellowColor"><strong><i>Instructions</i></strong></h2>

						<p><i class="fa fa-check" style="color: #F9B016"></i> USA iTunes Gift Card ONLY. Not Apple Music Card</p>
						<p><i class="fa fa-check" style="color: #F9B016"></i> Upload clearly picture. Complete picture.</p>
						<p><i class="fa fa-check" style="color: #F9B016"></i> Physical card only. not E- code picture or Code.</p>
						<p><i class="fa fa-check" style="color: #F9B016"></i> Card verification, usually takes 3-5 minutes.</p>
						<p><i class="fa fa-check" style="color: #F9B016"></i> $10, $15, $25, $50, $100 face value needed. We do not accept $101-$1000 Denomination.</p>
						<p><i class="fa fa-check" style="color: #F9B016"></i> You should make sure the value of the every single card is within $10 to 100$. We do not accept if the value of any single card exceed $100.We won't pay for the whole order if any of the cards is higher than $100 denomination.</p>

					</div>
				</div>
				
				<div class="row" style="margin-bottom: 5%">
					<div class="col-lg-4">
						<div id="cardPricediv"></div>
					</div>
					
					<div class="col-lg-8">
						<form enctype="multipart/form-data" method="post" autocomplete="off">
							<label for="file-input">Select File:</label><br>
							<input id="file-input" name="file-input[]" class="form-control input-lg" type="file" multiple="multiple" accept="image/jpg, image/jpeg, image/png, image/gif"required><br />

							<label>Select Card Type:</label>
							<select required class="form-control input-lg" id="cardType" name="cardType">
								<option value="">Please select card type</option>
								<option value="itunes">USA ITUNES</option>
								<option value="200 SINGLE CARD">200 SINGLE CARD</option>
								<option value="AUSTRALIA ITUNES CARD">AUSTRALIA ITUNES CARD</option>
								<option value="CANADIAN ITUNES CARD">CANADIAN ITUNES CARD</option>
							</select>
							<!--I need a js work here..-->
								<div id="fetchVal"></div>
							<!--I need a js work here..-->

							<br><label>User Remarks (<i>Optional</i>)</label>
							<textarea class="form-control input-lg" name="userRemark" placeholder="You can fill in some of the things you want to let us know about the order or not"></textarea>
							<br>

							<div id="preview" style="display: none"></div>
							<br>
							<font color="red"><b>NOTE: </b></font> We won't pay if any of your single card exceed <b>$100 (100 usd)</b><br><br>
							<button type="submit" class="btn btn-success" name="upload_itunes"><b><i class="fa fa-cloud-upload"></i> Upload Files</b></button>
							<button type="reset" id="reset" class="btn btn-warning"><b><i class="fa fa-refresh"></i> Reset</b></button>
						</form>
					</div>
				</div>
				
			<?php } else if(isset($_REQUEST["sell_no_amnt_itunes"])){ 

					if(isset($_POST["upload_NoAmntitunes"])) {
						$cardAmount = str_replace("$","", str_replace(array(" ","  "), ",",$_POST["cardAmount"]));
						$ituneNaira = $_POST["ituneNaira"];
						$userRemark = addslashes($_POST["userRemark"]);
						// echo $ituneNaira;
						// die();
						$fileinput_name = $_FILES["file-input"]["name"];
						$fileinput_tmpname = $_FILES["file-input"]["tmp_name"];
						// count the total number of files that was selected by the user.
						$count_file_num = count($fileinput_name);

						//Declare a variable to hold invalid file number count...
						$invalid = 0;
						$i = 1;
						$allowed = array("jpg", "jpeg", "png", "gif", "bmp");

						foreach($fileinput_name as $fileName){
							$rand = rand(111, 987);
							$pathinfo = pathinfo($fileName);
							$extension_file = strtolower($pathinfo["extension"]);
							if(!in_array($extension_file , $allowed)) {
								$invalid++;
								// echo $extension_file . "<br>";
							} else {
								$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
								$charactersLength = strlen($characters);
								$randomString = '';
								for ($i = 0; $i < 1; $i++) {
									$randomString .= strtoupper($characters[rand(0, $charactersLength - 1)]);
								}
								$string = strtolower(str_replace(array("I", "O"), "P", $randomString));
								if(is_numeric(substr(sha1(md5($rand)), 0,1))) {
									$value = $string . substr(sha1(md5($rand)), 1,7).".jpg";
									// echo substr(sha1(md5($rand)), 0,1). " || ". substr(sha1(md5($rand)), 0,7) . " || " . $i++ . " || " . $value . "<br>";
								} else {
									$value = substr(sha1(md5($rand)), 0,7).".jpg";
								}
								$combineFiles[] = $value;
								// echo strlen($value) . "<br>";
							}
						}
						$leftFiles = $count_file_num - $invalid;
						if($leftFiles == 0) {
							echo $action->error("Invalid file was selected");
						} else {
							$moveFileCount = 0;
							if($leftFiles != 0 && $invalid != 0) {

								foreach($combineFiles as $key=>$val) {
									$joinfile = "../images/market/".$val;
									if(move_uploaded_file($fileinput_tmpname[$key], $joinfile)){
										$moveFileCount++;
									}
								}
							} else if($leftFiles != 0 && $invalid == 0){
								foreach($combineFiles as $key=>$val) {
									$joinfile = "../images/market/".$val;
									if(move_uploaded_file($fileinput_tmpname[$key], $joinfile)){
										$moveFileCount++;
									}
								}
							}
							if($moveFileCount > 0) {

								$jCard = explode(",", $cardAmount);
								$totalCardAmnt = array_sum($jCard);

								//Mail Admins...
								$admins_mail[] = "odeniyipelumi@gmail.com";
								$admins_mail[] = "oluwatayoadeyemi@yahoo.com";


								// set content type header for html email
								$headers  = 'MIME-Version: 1.0' . "\r\n";
								$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
								// set additional headers
								$headers .= 'From:  noreply@toprate247.com <noreply@toprate247.com>' . "\r\n".'X-Mailer: PHP/' . phpversion();
								$subject = "iTunes Order";
								$body= "<html>
	<head>
	<title>ORDER NOTIFICATION</title>
	</head>
	<body><div>
	<div style='font-family:arial;border:1px solid #c0c0c0;padding:15px;border-radius:5px;'>
	<div style='font-size:40px;color:darkblue;font-weight:bold;'>iTunes Order</div>
	A client just submitted No Amount iTunes card worth usd".$totalCardAmnt." which is equivalent to NGN".number_format($ituneNaira).".
	<br><br>
	Kindly check the order asap.
	</div></div></body></html>";

								$message = "Dear Admin, you have a new order, Kindly check the order asap.";

								$file = "http://connectsms.net/components/com_smsreseller/smsapi.php?";
								$data = "username=".$sms_username ."&password=".$sms_password ."&sender=".$senderid."&recipient=".$mobile."&message=".$message;
								$joinfiledata = $file.$data;
								$ch = curl_init($file);
								curl_setopt($ch, CURLOPT_POST, 1);
								curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
								$data = curl_exec($ch);
								curl_close($ch);

								foreach($admins_mail as $adminsmail) {
									mail($adminsmail, $subject, $body, $headers);
								}

								//Responses....
								$response["txid"] = substr(md5(rand(111, 987)), 0, 10);
								$response["amountDollar"] = $totalCardAmnt;
								$response["cardNo"] = $leftFiles;
								$response["amountNaira"] = $ituneNaira;
								$response["userRemark"] = $userRemark;
								// $jsonResponse = json_encode($response);
								$jsonResponse = addslashes(json_encode($response));
								$response = $jsonResponse;

								$images = implode(",", $combineFiles);
								$type = "no amount itunes";
								if($action->saveCardUpload($clientID, $images, $cardAmount, $type, $response)) {
									if($invalid > 0) {
										echo $action->success("order received, Goto dashboard to check your card status. " . $invalid . " card(s) was removed");
									}
									else if($invalid == 0) {
										echo $action->success("Order received, Goto dashboard to check your card status");
									}
								} else {
									echo $action->error("We're unable to process your request");
								}
								//We need to mail user that card was received.

							} else {
								echo $action->error("Error uploading card");
							}
						}
					}
			
			?>
				
				<div align='center' style="margin-bottom: 2%; margin-top: 2%;">
					<h3 style="font-size: 2.5rem; font-weight: 900">No Amount iTunes</h3>
				</div>
				
				<div class="row">
					<div class="col-lg-4">
						<p class="img_card_procedure"></p>
					</div>
					<div class="col-lg-8">
						<h2 class="yellowColor"><strong><i>Instructions</i></strong></h2>

						<p><i class="fa fa-check" style="color: #F9B016"></i> USA No Amount iTunes Gift Card ONLY. Not Apple Music Card</p>
						<p><i class="fa fa-check" style="color: #F9B016"></i> Upload clearly picture. Complete picture.</p>
						<p><i class="fa fa-check" style="color: #F9B016"></i> Physical card only. not E- code picture or Code.</p>
						<p><i class="fa fa-check" style="color: #F9B016"></i> Card verification, usually takes 3-5 minutes.</p>
						<p><i class="fa fa-check" style="color: #F9B016"></i> $10, $15, $25, $50, $100 face value needed. We do not accept $101-$1000 Denomination.</p>
						<p><i class="fa fa-check" style="color: #F9B016"></i> You should make sure the value of the every single card is within $10 to 100$. We do not accept if the value of any single card exceed $100.We won't pay for the whole order if any of the cards is higher than $100 denomination.</p>

					</div>
				</div>
				
				<div class="row" style="margin-bottom: 5%">
					<div class="col-lg-4">
						
						<table class="table table-responsive table-striped" style="margin-bottom:5%">
							<tr id="head">
								<th>Total Amount</th>
								<th>Price (per 100$)</th>
								<th></th>
							</tr>
							<tr>

								<?php
								$replace = str_replace(array('\r\n','\n',"\n","\r\n"), "<br>", $action->no_amountItunes());
								$cost2 = explode("<br>", $replace);
								for($i=0; $i<count($cost2); $i++){
									$x=explode("=",$cost2[$i]);
									$y= implode(",", explode("=",$x[1]));
									$price_perVal[] = $y;
									$lowMin[] = $x[0];
								}
								//Array Combine...
								$arrPush = array_combine($lowMin, $price_perVal);

								foreach($arrPush as $amount=>$pricePerDollar){
								?>
								<td>≥ $<?php echo $amount;?></td>
								<td>&#8358;<?php echo number_format($pricePerDollar);?></td>
								<td>$<?php echo $amount;?> = &#8358;<?php echo number_format($pricePerDollar*$amount);?></td>
							</tr>
							<?php
							}
							?>
						</table>

					</div>
					
					<div class="col-lg-8">
						<form enctype="multipart/form-data" method="post" autocomplete="off">
							<label for="file-input">Select File:</label><br>
							<input id="file-input" name="file-input[]" class="form-control input-lg" type="file" multiple="multiple" accept="image/jpg, image/jpeg, image/png, image/gif"required><br />

			
							<div class="row">
								<div class="col-md-5">
									<label for="itunesValue">
										Enter amount <font size="3px">(Separate multiple card amount value with comma):</font>
									</label><br>
									<input type="text" placeholder="Card Value" name="cardAmount" id="itunesValue" onKeyUp="getNoAmntItunesCost();" class="form-control input-lg" required>
									<input id="ituneNaira" name="ituneNaira" type="hidden">
								</div>
								<div class="col-md-7"><br>
									<div id="itunesSum" style="font-size: 26px"></div>
								</div>
							</div>
							
							<br><label>User Remarks (<i>Optional</i>)</label>
							<textarea class="form-control input-lg" name="userRemark" placeholder="You can fill in some of the things you want to let us know about the order or not"></textarea>

							<br><label>Accepted Country Card </label>
							<input class="form-control input-lg" value="US" disabled>
							<br>

							<div id="preview" style="display: none"></div>
							<br>
							<font color="red"><b>NOTE: </b></font> We won't pay if any of your single card exceed <b>$100 (100 usd)</b><br><br>
							<button type="submit" class="btn btn-success" name="upload_NoAmntitunes"><b><i class="fa fa-cloud-upload"></i> Upload Files</b></button>
							<button type="reset" id="reset" class="btn btn-warning"><b><i class="fa fa-refresh"></i> Reset</b></button>
						</form>
					</div>
				</div>
				
				
			<?php } else if(isset($_REQUEST["sell_ecode"])){

					if(isset($_POST["upload_ecode"])) {
						$itunesEcode = $_POST["itunesEcode"];
						$cardAmount = str_replace("$", "", $_POST["cardAmount"]);
						$priceNairaInput = $_POST["priceNairaInput"];
						$userRemark = $_POST["userRemark"];
						$type = "itunes ecode";
						if(strlen($itunesEcode) < 13 ||strlen($itunesEcode) > 16){
							echo $action->error("invalid itunes ecode supplied");
						} else if($cardAmount < 50){
							echo $action->error("Card amount is lesser than usd50 ($50)");
						} else {
							//Responses....
							$response["txid"] = substr(md5(rand(111, 987)), 0, 10);
							$response["amountDollar"] = $cardAmount;
							$response["amountNaira"] = $priceNairaInput;
							$amount = $_POST["priceNairaInput"];
							$response["userRemark"] = $userRemark;
							$response["itunesEcode"] = $itunesEcode;
							$jsonResponse = addslashes(json_encode($response));
							$response = $jsonResponse;
							$images = "";
							if($action->saveCardUpload($clientID, $images, $cardAmount, $type, $response)) {


								//Mail Admins...
								$admins_mail[] = "odeniyipelumi@gmail.com";
								$admins_mail[] = "oluwatayoadeyemi@yahoo.com";

								// set content type header for html email
								$headers  = 'MIME-Version: 1.0' . "\r\n";
								$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
								// set additional headers
								$headers .= 'From:  noreply@toprate247.com <noreply@toprate247.com>' . "\r\n".'X-Mailer: PHP/' . phpversion();
								$subject = "ITUNES ECODE Order";
								$body= "<html>
<head>
<title>ORDER NOTIFICATION</title>
</head>
<body><div>
<div style='font-family:arial;border:1px solid #c0c0c0;padding:15px;border-radius:5px;'>
<div style='font-size:40px;color:darkblue;font-weight:bold;'>ITUNES ECODE Order</div>
A client just submitted ITUNES ECODE worth usd".$cardAmount." which is equivalent to NGN".number_format($priceNairaInput).".
<br><br>
Kindly check the order asap.
</div></div></body></html>";


//Sms parameter
								$message = "Dear Admin, you have a new order, Kindly check the order asap.";

								$file = "http://connectsms.net/components/com_smsreseller/smsapi.php?";
								$data = "username=".$sms_username ."&password=".$sms_password ."&sender=".$senderid."&recipient=".$mobile."&message=".$message;
								$joinfiledata = $file.$data;
								$ch = curl_init($file);
								curl_setopt($ch, CURLOPT_POST, 1);
								curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
								$data = curl_exec($ch);
								curl_close($ch);


								foreach($admins_mail as $adminsmail) {
									mail($adminsmail, $subject, $body, $headers);
								}
								echo $action->success("Order received, Goto dashboard to check your card status. ");
							} else {
								echo $action->error("Error submitting request");
							}

						}
					}

				?>
				
				<div align='center' style="margin-bottom: 2%; margin-top: 2%;">
					<h3 style="font-size: 2.5rem; font-weight: 900">iTunes Ecode Market Place</h3>
				</div>
			
				<div class="row" style="margin-bottom: 5%">
					<div class="col-lg-5">
						<p><i class="fa fa-copy" style="color: #F9B016"></i> Paste the iTunes Ecode in the box provided</p>
						<p><i class="fa fa-check" style="color: #F9B016"></i> Enter amount, we do not accept multiple iTunes Ecode.</p>
						<p><i class="fa fa-upload" style="color: #F9B016"></i> Submit Ecode.</p>
						<p><i class="fa fa-refresh" style="color: #F9B016"></i> Waiting for verification.</p>
						<p><i class="fa fa-check" style="color: #F9B016"></i> Get payment instantly.</p>



						<table class="table table-responsive table-striped" style="margin-bottom:5%">
							<tr id="head">
								<th>Total Amount</th>
								<th>Price (per $)</th>
								<th></th>
							</tr>
							<tr>

								<?php
								$replace = str_replace(array('\r\n','\n',"\n","\r\n"), "<br>", $action->ecodePrice());
								$cost2 = explode("<br>", $replace);
								for($i=0; $i<count($cost2); $i++){
									$x=explode("=",$cost2[$i]);
									$y= implode(",", explode("=",$x[1]));
									$price_perVal[] = $y;
									$lowMin[] = $x[0];
								}
								//Array Combine...
								$arrPush = array_combine($lowMin, $price_perVal);

								foreach($arrPush as $amount=>$pricePerDollar){
								?>
								<td>≥ $<?php echo $amount;?></td>
								<td>&#8358;<?php echo number_format($pricePerDollar);?></td>
								<td>$<?php echo $amount;?> = &#8358;<?php echo number_format($pricePerDollar*$amount);?></td>
							</tr>
							<?php
							}
							?>
						</table>
					</div>
					
					<div class="col-lg-7">
						<form method="post" autocomplete="off">
							<label>Provide iTune Ecode</label>
							<input type="text" class="form-control input-lg" name="itunesEcode" id="itunesEcode" maxlength="16"><br>
							<label>Enter Ecode value</label>
							<input type="text" placeholder="Enter iTunes Ecode value eg 50" name="cardAmount" id="bitcoinAmount" onKeyUp="getitunesEcodeCost();" class="form-control input-lg" required>
							<br><label>Price in Naira</label>
							<input type="text" id="priceNaira" class="form-control input-lg" readonly>
							<br><label>User Remarks (<i>Optional</i>)</label>
							<textarea class="form-control input-lg" name="userRemark" placeholder="You can fill in some of the things you want to let us know about the order or not"></textarea>
							<input name="priceNairaInput" id="priceNairaInput" type="hidden">
							<br>
							<font color="red"><b>NOTE: </b></font> We do not accept multiple iTunes Ecode i.e. Single iTunes Ecode per transaction</b><br><br>
							<center>
								<button type="submit" class="btn btn-success" name="upload_ecode"><b><i class="fa fa-cloud-upload"></i> Submit Ecode</b></button>
							</center>
						</form>
					</div>
				</div>
				
			<?php } else if(isset($_REQUEST["sell_steam"])){ 
			
					if(isset($_POST["upload_steam"])) {
						$cardAmount = str_replace("$","", str_replace(array(" ","  "), ",",$_POST["cardAmount"]));
						$ituneNaira = $_POST["steamNaira"];
						$userRemark = addslashes($_POST["userRemark"]);
						// echo $ituneNaira;
						// die();
						$fileinput_name = $_FILES["file-input"]["name"];
						$fileinput_tmpname = $_FILES["file-input"]["tmp_name"];
						// count the total number of files that was selected by the user.
						$count_file_num = count($fileinput_name);

						//Declare a variable to hold invalid file number count...
						$invalid = 0;
						$i = 1;
						$allowed = array("jpg", "jpeg", "png", "gif", "bmp");

						foreach($fileinput_name as $fileName){
							$rand = rand(111, 987);
							$pathinfo = pathinfo($fileName);
							$extension_file = strtolower($pathinfo["extension"]);
							if(!in_array($extension_file , $allowed)) {
								$invalid++;
								// echo $extension_file . "<br>";
							} else {
								$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
								$charactersLength = strlen($characters);
								$randomString = '';
								for ($i = 0; $i < 1; $i++) {
									$randomString .= strtoupper($characters[rand(0, $charactersLength - 1)]);
								}
								$string = strtolower(str_replace(array("I", "O"), "P", $randomString));
								if(is_numeric(substr(sha1(md5($rand)), 0,1))) {
									$value = $string . substr(sha1(md5($rand)), 1,7).".jpg";
									// echo substr(sha1(md5($rand)), 0,1). " || ". substr(sha1(md5($rand)), 0,7) . " || " . $i++ . " || " . $value . "<br>";
								} else {
									$value = substr(sha1(md5($rand)), 0,7).".jpg";
								}
								$combineFiles[] = $value;
								// echo strlen($value) . "<br>";
							}
						}
						$leftFiles = $count_file_num - $invalid;
						if($leftFiles == 0) {
							echo $action->error("Invalid file was selected");
						} else {
							$moveFileCount = 0;
							if($leftFiles != 0 && $invalid != 0) {

								foreach($combineFiles as $key=>$val) {
									$joinfile = "../images/market/".$val;
									if(move_uploaded_file($fileinput_tmpname[$key], $joinfile)){
										$moveFileCount++;
									}
								}
							} else if($leftFiles != 0 && $invalid == 0){
								foreach($combineFiles as $key=>$val) {
									$joinfile = "../images/market/".$val;
									if(move_uploaded_file($fileinput_tmpname[$key], $joinfile)){
										$moveFileCount++;
									}
								}
							}
							if($moveFileCount > 0) {

								$jCard = explode(",", $cardAmount);
								$totalCardAmnt = array_sum($jCard);

								//Mail Admins...
								$admins_mail[] = "odeniyipelumi@gmail.com";
								$admins_mail[] = "oluwatayoadeyemi@yahoo.com";


								// set content type header for html email
								$headers  = 'MIME-Version: 1.0' . "\r\n";
								$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
								// set additional headers
								$headers .= 'From:  noreply@toprate247.com <noreply@toprate247.com>' . "\r\n".'X-Mailer: PHP/' . phpversion();
								$subject = "Steam Order";
								$body= "<html>
	<head>
	<title>ORDER NOTIFICATION</title>
	</head>
	<body><div>
	<div style='font-family:arial;border:1px solid #c0c0c0;padding:15px;border-radius:5px;'>
	<div style='font-size:40px;color:darkblue;font-weight:bold;'>iTunes Order</div>
	A client just submitted steam card worth usd".$totalCardAmnt." which is equivalent to NGN".number_format($ituneNaira).".
	<br><br>
	Kindly check the order asap.
	</div></div></body></html>";

								$message = "Dear Admin, you have a new order, Kindly check the order asap.";

								$file = "http://connectsms.net/components/com_smsreseller/smsapi.php?";
								$data = "username=".$sms_username ."&password=".$sms_password ."&sender=".$senderid."&recipient=".$mobile."&message=".$message;
								$joinfiledata = $file.$data;
								$ch = curl_init($file);
								curl_setopt($ch, CURLOPT_POST, 1);
								curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
								$data = curl_exec($ch);
								curl_close($ch);

								foreach($admins_mail as $adminsmail) {
									mail($adminsmail, $subject, $body, $headers);
								}

								//Responses....
								$response["txid"] = substr(md5(rand(111, 987)), 0, 10);
								$response["amountDollar"] = $totalCardAmnt;
								$response["cardNo"] = $leftFiles;
								$response["amountNaira"] = $ituneNaira;
								$response["userRemark"] = $userRemark;
								// $jsonResponse = json_encode($response);
								$jsonResponse = addslashes(json_encode($response));
								$response = $jsonResponse;

								$images = implode(",", $combineFiles);
								$type = "steam";
								if($action->saveCardUpload($clientID, $images, $cardAmount, $type, $response)) {
									if($invalid > 0) {
										echo $action->success("order received, Goto dashboard to check your card status. " . $invalid . " card(s) was removed");
									}
									else if($invalid == 0) {
										echo $action->success("Order received, Goto dashboard to check your card status");
									}
								} else {
									echo $action->error("We're unable to process your request");
								}
								//We need to mail user that card was received.

							} else {
								echo $action->error("Error uploading card");
							}
						}
					}
			?>
					
					<div align='center' style="margin-bottom: 2%; margin-top: 2%;">
						<h3 style="font-size: 2.5rem; font-weight: 900">Steam Market Place</h3>
					</div>

					<div class="row" style="margin-bottom: 5%">
						<div class="col-lg-4" style="margin-top: 2%">
							<p class="img_card_procedure"></p>
						</div>
						<div class="col-lg-8" style="text-align: justify; margin-top: 2%">

							<h2 class="yellowColor"><strong>Things you need to know</strong></h2>

							<p><i class="fa fa-check" style="color: #F9B016"></i> USA Steam Gift Card ONLY. Not Apple Music Card</p>
							<p><i class="fa fa-check" style="color: #F9B016"></i> Upload clearly picture. Complete picture.</p>
							<p><i class="fa fa-check" style="color: #F9B016"></i> Physical card only. not E- code picture or Code.</p>
							<p><i class="fa fa-check" style="color: #F9B016"></i> Card verification, usually takes 3-5 minutes.</p>
							<p><i class="fa fa-check" style="color: #F9B016"></i> $10, $15, $25, $50, $100 face value needed. We do not accept $101-$1000 Denomination.</p>
							<p><i class="fa fa-check" style="color: #F9B016"></i> You should make sure the value of the every single card is within $10 to 100$. We do not accept if the value of any single card exceed $100.We won't pay for the whole order if any of the cards is higher than $100 denomination.</p>

						</div>
					</div>

					<div class="row" style="margin-bottom: 10%">
						<div class="col-lg-4" style="">
							<table class="table table-responsive table-striped" style="margin-bottom:5%">
								<tr id="head">
									<th>Total Amount</th>
									<th>Price (per 100$)</th>
									<th></th>
								</tr>
								<tr>

									<?php
									$replace = str_replace(array('\r\n','\n',"\n","\r\n"), "<br>", $action->steamPrice());
									$cost2 = explode("<br>", $replace);
									for($i=0; $i<count($cost2); $i++){
										$x=explode("=",$cost2[$i]);
										$y= implode(",", explode("=",$x[1]));
										$price_perVal[] = $y;
										$lowMin[] = $x[0];
									}
									//Array Combine...
									$arrPush = array_combine($lowMin, $price_perVal);

									foreach($arrPush as $amount=>$pricePerDollar){
									?>
									<td>≥ $<?php echo $amount;?></td>
									<td>&#8358;<?php echo number_format($pricePerDollar);?></td>
									<td>$<?php echo $amount;?> = &#8358;<?php echo number_format($pricePerDollar*$amount);?></td>
								</tr>
								<?php
								}
								?>
							</table>

						</div>
						<div class="col-lg-8" style="text-align: justify;">
							<form enctype="multipart/form-data" method="post" autocomplete="off">
								<label for="file-input">Select File:</label><br>
								<input id="file-input" name="file-input[]" class="form-control input-lg" type="file" multiple="multiple" accept="image/jpg, image/jpeg, image/png, image/gif"required><br />

								<div class="row">
									<div class="col-md-5">
										<label for="itunesValue">Enter amount <font size="3px">(Separate multiple card amount value with comma):</font></label><br>
										<input type="text" placeholder="Card Value" name="cardAmount" id="steamValue" onKeyUp="getSteamCost();" class="form-control input-lg" required>
										<input id="steamNaira" name="steamNaira" type="hidden">
									</div>
									<div class="col-md-7"><br>
										<div id="steamSum" style="font-size: 26px"></div>
									</div>
								</div>
								<br><label>User Remarks (<i>Optional</i>)</label>
								<textarea class="form-control input-lg" name="userRemark" placeholder="You can fill in some of the things you want to let us know about the order or not"></textarea>


								<div id="preview" style="display: none"></div>
								<br>
								<font color="red"><b>NOTE: </b></font> We won't pay if any of your single card exceed <b>$100 (100 usd)</b><br><br>
								<button type="submit" class="btn btn-success" name="upload_steam"><b><i class="fa fa-cloud-upload"></i> Upload Files</b></button>
								<button type="reset" id="reset" class="btn btn-warning"><b><i class="fa fa-refresh"></i> Reset</b></button>
							</form>
						</div>
					</div>
					
			<?php } else if(isset($_REQUEST["sell_amazon"])){ 
			
					if(isset($_POST["upload_amazon"])) {
						$cardAmount = str_replace("$", "", str_replace(array(" ","  "), ",",$_POST["cardAmount"]));
						$amazonNaira = $_POST["amazonNaira"];
						$userRemark = $_POST["userRemark"];
						$fileinput_name = $_FILES["file-input"]["name"];
						$fileinput_tmpname = $_FILES["file-input"]["tmp_name"];
						// count the total number of files that was selected by the user.
						$count_file_num = count($fileinput_name);

						//Declare a variable to hold invalid file number count...
						$invalid = 0;
						$i = 1;
						$allowed = array("jpg", "jpeg", "png", "gif", "bmp");

						foreach($fileinput_name as $fileName){
							$rand = rand(111, 987);
							$pathinfo = pathinfo($fileName);
							$extension_file = strtolower($pathinfo["extension"]);
							if(!in_array($extension_file , $allowed)) {
								$invalid++;
								// echo $extension_file . "<br>";
							} else {
								$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
								$charactersLength = strlen($characters);
								$randomString = '';
								for ($i = 0; $i < 1; $i++) {
									$randomString .= strtoupper($characters[rand(0, $charactersLength - 1)]);
								}
								$string = strtolower(str_replace(array("I", "O"), "P", $randomString));
								if(is_numeric(substr(sha1(md5($rand)), 0,1))) {
									$value = $string . substr(sha1(md5($rand)), 1,7).".jpg";
									// echo substr(sha1(md5($rand)), 0,1). " || ". substr(sha1(md5($rand)), 0,7) . " || " . $i++ . " || " . $value . "<br>";
								} else {
									$value = substr(sha1(md5($rand)), 0,7).".jpg";
								}
								$combineFiles[] = $value;
								// echo strlen($value) . "<br>";
							}
						}
						$leftFiles = $count_file_num - $invalid;
						if($leftFiles == 0) {
							echo $action->error("Invalid file was selected");
						} else {
							$moveFileCount = 0;
							if($leftFiles != 0 && $invalid != 0) {

								foreach($combineFiles as $key=>$val) {
									$joinfile = "../images/market/".$val;
									if(move_uploaded_file($fileinput_tmpname[$key], $joinfile)){
										$moveFileCount++;
									}
								}
							} else if($leftFiles != 0 && $invalid == 0){
								foreach($combineFiles as $key=>$val) {
									$joinfile = "../images/market/".$val;
									if(move_uploaded_file($fileinput_tmpname[$key], $joinfile)){
										$moveFileCount++;
									}
								}
							}
							if($moveFileCount > 0) {

								$jCard = explode(",", $cardAmount);
								$totalCardAmnt = array_sum($jCard);

								//Mail Admins...
								$admins_mail[] = "odeniyipelumi@gmail.com";
								$admins_mail[] = "oluwatayoadeyemi@yahoo.com";

								// set content type header for html email
								$headers  = 'MIME-Version: 1.0' . "\r\n";
								$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
								// set additional headers
								$headers .= 'From:  noreply@niratrade.com <noreply@niratrade.com>' . "\r\n".'X-Mailer: PHP/' . phpversion();
								$subject = "Amazon Order";
								$body= "<html>
<head>
<title>ORDER NOTIFICATION</title>
</head>
<body><div>
<div style='font-family:arial;border:1px solid #c0c0c0;padding:15px;border-radius:5px;'>
<div style='font-size:40px;color:darkblue;font-weight:bold;'>Amazon Order</div>
A client just submitted an amazon card worth usd".$totalCardAmnt." which is equivalent to NGN".number_format($amazonNaira).".
<br><br>
Kindly check the order asap.
</div></div></body></html>";

								$message = "Dear Admin, you have a new order, Kindly check the order asap.";

								$file = "http://connectsms.net/components/com_smsreseller/smsapi.php?";
								$data = "username=".$sms_username ."&password=".$sms_password ."&sender=".$senderid."&recipient=".$mobile."&message=".$message;
								$joinfiledata = $file.$data;
								$ch = curl_init($file);
								curl_setopt($ch, CURLOPT_POST, 1);
								curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
								$data = curl_exec($ch);
								curl_close($ch);

								foreach($admins_mail as $adminsmail) {
									mail($adminsmail, $subject, $body, $headers);
								}

								//Responses....
								$response["txid"] = substr(md5(rand(111, 987)), 0, 10);
								$response["amountDollar"] = $totalCardAmnt;
								$response["cardNo"] = $leftFiles;
								$response["amountNaira"] = $amazonNaira;
								$response["userRemark"] = $userRemark;
								// $jsonResponse = json_encode($response);
								$jsonResponse = addslashes(json_encode($response));
								$response = $jsonResponse;

								$images = implode(",", $combineFiles);
								$type = "amazon";
								if($action->saveCardUpload($clientID, $images, $cardAmount, $type, $response)) {
									if($invalid > 0) {
										echo $action->success("Order received, Goto dashboard to check your card status. " . $invalid . " card(s) was removed");
									}
									else if($invalid == 0) {
										echo $action->success("Order received, Goto dashboard to check your card status");
									}
								} else {
									echo $action->error("We're unable to process your request");
								}
								//We need to mail user that card was received.

							} else {
								echo $action->error("Error uploading card");
							}
						}
					}
			?>

					<div align='center' style="margin-bottom: 2%; margin-top: 2%;">
						<h3 style="font-size: 2.5rem; font-weight: 900">Amazon Market Place</h3>
					</div>
					
					<div class="row">
						<div class="col-md-4">
							<p class="img_card_procedure"></p>
						</div>
						<div class="col-md-8" style="text-align: justify">
							<p><i class="fa fa-info" style="color: #F9B016"></i> Only physical Amazon Gift Card (not e-code). Physical card paid with cash needs a cash receipt.</p>
							<p><i class="fa fa-check" style="color: #F9B016"></i> We only accept $25 - $100 face value gift cards.</p>
							<p><i class="fa fa-remove" style="color: #F9B016"></i> Cash receipt and gift card number should match; (Refusal to trade if the receipt and gift card don't match )</p>
							<p><i class="fa fa-eye" style="color: #F9B016"></i> The gift card and receipt Pictures must be clearly visible</p>
							<p><i class="fa fa-refresh" style="color: #F9B016"></i> Waiting for verification.</p>
							<p><i class="fa fa-check" style="color: #F9B016"></i> Get payment instantly.</p>
						</div>
					</div>
					
					<div class="row" style="margin-bottom: 10%">
						<div class="col-md-4">
							
							<table class="table table-responsive table-striped" style="margin-bottom:5%">
								<tr id="head">
									<th>Total Amount</th>
									<th>Price (per 100$)</th>
									<th></th>
								</tr>
								<tr>

									<?php
									$replace = str_replace(array('\r\n','\n',"\n","\r\n"), "<br>", $action->amazonPrice());
									$cost2 = explode("<br>", $replace);
									for($i=0; $i<count($cost2); $i++){
										$x=explode("=",$cost2[$i]);
										$y= implode(",", explode("=",$x[1]));
										$price_perVal[] = $y;
										$lowMin[] = $x[0];
									}
									//Array Combine...
									$arrPush = array_combine($lowMin, $price_perVal);

									foreach($arrPush as $amount=>$pricePerDollar){
									?>
									<td>≥ $<?php echo $amount;?></td>
									<td>&#8358;<?php echo number_format($pricePerDollar*100);?></td>
									<td>$<?php echo $amount;?> = &#8358;<?php echo number_format($pricePerDollar*$amount);?></td>
								</tr>
								<?php
								}
								?>
							</table>
						</div>
						<div class="col-md-8" style="text-align: justify">
							
							<form enctype="multipart/form-data" method="post" autocomplete="off">
								<label for="itunesValue">Select File</label><br>
								<input id="file-input" name="file-input[]" class="form-control input-lg" type="file" multiple="multiple" accept="image/jpg, image/jpeg, image/png, image/gif"required><br />

								<div class="row">
									<div class="col-md-5">
										<label for="itunesValue">Enter amount <font size="3px">(Separate multiple card amount value with comma):</font></label><br>
										<input type="text" placeholder="Enter amount of each card separated by comma respectively" name="cardAmount" id="amazonValue" onKeyUp="getamazonCost();" class="form-control input-lg" required>
										<input id="amazonNaira" name="amazonNaira" type="hidden">
									</div>
									
									<div class="col-md-7"><br>
										<div id="amazonSum" style="font-size: 26px"></div>
									</div>
								</div>
								
								<br><label>User Remarks (<i>Optional</i>)</label>
								<textarea class="form-control input-lg" name="userRemark" placeholder="You can fill in some of the things you want to let us know about the order or not"></textarea>
								<br>
								<div id="preview" style="display: none"></div>
								<br>
								<font color="red"><b>NOTE: </b></font> ALL PHOTO MUST BE CLEAR, NO SCAN COPY</b><br><br>
								<button type="submit" class="btn btn-success" name="upload_amazon"><b><i class="fa fa-cloud-upload"></i> Upload Files</b></button>
								<button type="reset" id="reset" class="btn btn-warning"><b><i class="fa fa-refresh"></i> Reset</b></button>
							</form>
						</div>
					</div>
					
			<?php } else if(isset($_REQUEST["sell_amazon_no_receipt"])){
					
				if(isset($_POST["upload_amazon_NoRcp"])) {
					$cardAmount = str_replace("$", "", str_replace(array(" ","  "), ",",$_POST["cardAmount"]));
					$amazonNaira = $_POST["amazonNaira"];
					$amazonCode = $_POST["amazonCode"];
					$userRemark = $_POST["userRemark"];
					$fileinput_name = $_FILES["file-input"]["name"];
					$fileinput_tmpname = $_FILES["file-input"]["tmp_name"];
					// count the total number of files that was selected by the user.
					$count_file_num = count($fileinput_name);

					//Declare a variable to hold invalid file number count...
					$invalid = 0;
					$i = 1;
					$allowed = array("jpg", "jpeg", "png", "gif", "bmp");

					foreach($fileinput_name as $fileName){
						$rand = rand(111, 987);
						$pathinfo = pathinfo($fileName);
						$extension_file = strtolower($pathinfo["extension"]);
						if(!in_array($extension_file , $allowed)) {
							$invalid++;
							// echo $extension_file . "<br>";
						} else {
							$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
							$charactersLength = strlen($characters);
							$randomString = '';
							for ($i = 0; $i < 1; $i++) {
								$randomString .= strtoupper($characters[rand(0, $charactersLength - 1)]);
							}
							$string = strtolower(str_replace(array("I", "O"), "P", $randomString));
							if(is_numeric(substr(sha1(md5($rand)), 0,1))) {
								$value = $string . substr(sha1(md5($rand)), 1,7).".jpg";
								// echo substr(sha1(md5($rand)), 0,1). " || ". substr(sha1(md5($rand)), 0,7) . " || " . $i++ . " || " . $value . "<br>";
							} else {
								$value = substr(sha1(md5($rand)), 0,7).".jpg";
							}
							$combineFiles[] = $value;
							// echo strlen($value) . "<br>";
						}
					}
					$leftFiles = $count_file_num - $invalid;
					if($leftFiles == 0) {
						echo $action->error("Invalid file was selected");
					} else {
						$moveFileCount = 0;
						if($leftFiles != 0 && $invalid != 0) {

							foreach($combineFiles as $key=>$val) {
								$joinfile = "../images/market/".$val;
								if(move_uploaded_file($fileinput_tmpname[$key], $joinfile)){
									$moveFileCount++;
								}
							}
						} else if($leftFiles != 0 && $invalid == 0){
							foreach($combineFiles as $key=>$val) {
								$joinfile = "../images/market/".$val;
								if(move_uploaded_file($fileinput_tmpname[$key], $joinfile)){
									$moveFileCount++;
								}
							}
						}
						if($moveFileCount > 0) {

							$jCard = explode(",", $cardAmount);
							$totalCardAmnt = array_sum($jCard);

							//Mail Admins...
							$admins_mail[] = "odeniyipelumi@gmail.com";
							$admins_mail[] = "oluwatayoadeyemi@yahoo.com";

							// set content type header for html email
							$headers  = 'MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
							// set additional headers
							$headers .= 'From:  noreply@niratrade.com <noreply@niratrade.com>' . "\r\n".'X-Mailer: PHP/' . phpversion();
							$subject = "Amazon No Receipt Order";
							$body= "<html>
<head>
<title>ORDER NOTIFICATION</title>
</head>
<body><div>
<div style='font-family:arial;border:1px solid #c0c0c0;padding:15px;border-radius:5px;'>
<div style='font-size:40px;color:darkblue;font-weight:bold;'>Amazon Order</div>
A client just submitted amazon no receipt card worth usd".$totalCardAmnt." which is equivalent to NGN".number_format($amazonNaira).".
<br><br>
Kindly check the order asap.
</div></div></body></html>";

							$message = "Dear Admin, you have a new order, Kindly check the order asap.";

							$file = "http://connectsms.net/components/com_smsreseller/smsapi.php?";
							$data = "username=".$sms_username ."&password=".$sms_password ."&sender=".$senderid."&recipient=".$mobile."&message=".$message;
							$joinfiledata = $file.$data;
							$ch = curl_init($file);
							curl_setopt($ch, CURLOPT_POST, 1);
							curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
							$data = curl_exec($ch);
							curl_close($ch);

							foreach($admins_mail as $adminsmail) {
								mail($adminsmail, $subject, $body, $headers);
							}

							//Responses....
							$response["txid"] = substr(md5(rand(111, 987)), 0, 10);
							$response["amountDollar"] = $totalCardAmnt;
							$response["cardNo"] = $leftFiles;
							$response["amountNaira"] = $amazonNaira;
							$response["userRemark"] = $userRemark;
							$response["amazonCode"] = $amazonCode;
							// $jsonResponse = json_encode($response);
							$jsonResponse = addslashes(json_encode($response));
							$response = $jsonResponse;

							$images = implode(",", $combineFiles);
							$type = "amazon no receipt";
							if($action->saveCardUpload($clientID, $images, $cardAmount, $type, $response)) {
								if($invalid > 0) {
									echo $action->success("Order received, Goto dashboard to check your card status. " . $invalid . " card(s) was removed");
								}
								else if($invalid == 0) {
									echo $action->success("Order received, Goto dashboard to check your card status");
								}
							} else {
								echo $action->error("We're unable to process your request");
							}
							//We need to mail user that card was received.

						} else {
							echo $action->error("Error uploading card");
						}
					}
				}
			?>
			
				<div align='center' style="margin-bottom: 2%; margin-top: 2%;">
					<h3 style="font-size: 2.5rem; font-weight: 900">Amazon No Receipt</h3>
				</div>
				
				<div class="row">
					<div class="col-md-4">
						<p class="img_card_procedure"></p>
					</div>
					<div class="col-md-8" style="text-align: justify">
						<p><i class="fa fa-info" style="color: #F9B016"></i> Upload the physical Amazon Gift Card and type the code</p>
						<p><i class="fa fa-check" style="color: #F9B016"></i> We only accept $25 - $100 face value gift cards.</p>
						<p><i class="fa fa-eye" style="color: #F9B016"></i> Gift Card must be clear and not blur</p>
						<p><i class="fa fa-refresh" style="color: #F9B016"></i> Waiting for verification.</p>
						<p><i class="fa fa-check" style="color: #F9B016"></i> Get payment instantly.</p>
					</div>
				</div>
			
				<div class="row" style="margin-bottom: 10%">
					<div class="col-md-4">
						<table class="table table-responsive table-striped" style="margin-bottom:5%">
							<tr id="head">
								<th>Total Amount</th>
								<th>Price (per 100$)</th>
								<th></th>
							</tr>
							<tr>

								<?php
								$replace = str_replace(array('\r\n','\n',"\n","\r\n"), "<br>", $action->amazonNoReceiptPrice());
								$cost2 = explode("<br>", $replace);
								for($i=0; $i<count($cost2); $i++){
									$x=explode("=",$cost2[$i]);
									$y= implode(",", explode("=",$x[1]));
									$price_perVal[] = $y;
									$lowMin[] = $x[0];
								}
								//Array Combine...
								$arrPush = array_combine($lowMin, $price_perVal);

								foreach($arrPush as $amount=>$pricePerDollar){
								?>
								<td>≥ $<?php echo $amount;?></td>
								<td>&#8358;<?php echo number_format($pricePerDollar*100);?></td>
								<td>$<?php echo $amount;?> = &#8358;<?php echo number_format($pricePerDollar*$amount);?></td>
							</tr>
							<?php
							}
							?>
						</table>
					</div>
					<div class="col-md-8">
						<form enctype="multipart/form-data" method="post" autocomplete="off">
							<label for="itunesValue">Select File</label><br>
							<input id="file-input" name="file-input[]" class="form-control input-lg" type="file" multiple="multiple" accept="image/jpg, image/jpeg, image/png, image/gif"required><br />

							<label for="itunesValue">Enter Amazon Code: </label><br>
							<textarea name="amazonCode" class="form-control input-lg" required></textarea><br />
							
							<div class="row">
								<div class="col-md-5">
									<label for="itunesValue">Enter amount <font size="3px">(Separate multiple card amount value with comma):</font></label><br>

									<input type="text" placeholder="Enter amount of each card separated by comma respectively" name="cardAmount" id="amazonValue" onKeyUp="getamazonNoReceiptCost();" class="form-control input-lg" required>
									<input id="amazonNaira" name="amazonNaira" type="hidden">
								</div>
								<div class="col-md-7"> <br>
									<div id="amazonSum" style="font-size: 26px"></div>
								</div>
							</div>
							<br><label>User Remarks (<i>Optional</i>)</label>
							<textarea class="form-control input-lg" name="userRemark" placeholder="You can fill in some of the things you want to let us know about the order or not"></textarea>
							<br>
							<div id="preview" style="display: none"></div>
							<br>
							<font color="red"><b>NOTE: </b></font> ALL PHOTO MUST BE CLEAR, NO SCAN COPY</b><br><br>
							<button type="submit" class="btn btn-success" name="upload_amazon_NoRcp"><b><i class="fa fa-cloud-upload"></i> Upload Files</b></button>
							<button type="reset" id="reset" class="btn btn-warning"><b><i class="fa fa-refresh"></i> Reset</b></button>
						</form>
					</div>
				</div>
			<?php } else if(isset($_REQUEST["sell_btc"])){

					if(isset($_POST["upload_btc"])) {
						$cardAmount = str_replace("$", "", str_replace(array(" ","  "), ",",$_POST["cardAmount"]));
						$priceNairaInput = $_POST["priceNairaInput"];
						$userRemark = $_POST["userRemark"];
						$fileinput_name = $_FILES["file-input"]["name"];
						$fileinput_tmpname = $_FILES["file-input"]["tmp_name"];
						// count the total number of files that was selected by the user.
						$count_file_num = count($fileinput_name);

						//Declare a variable to hold invalid file number count...
						$invalid = 0;
						$i = 1;
						$allowed = array("jpg", "jpeg", "png", "gif", "bmp");

						if($priceNairaInput == 0 || empty($priceNairaInput)) {
							echo $action->error("<i class='fa fa-info'></i> Please specify amount");
						} else{

							foreach($fileinput_name as $fileName){
								$rand = rand(111, 987);
								$pathinfo = pathinfo($fileName);
								$extension_file = strtolower($pathinfo["extension"]);
								if(!in_array($extension_file , $allowed)) {
									$invalid++;
									// echo $extension_file . "<br>";
								} else {
									$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
									$charactersLength = strlen($characters);
									$randomString = '';
									for ($i = 0; $i < 1; $i++) {
										$randomString .= strtoupper($characters[rand(0, $charactersLength - 1)]);
									}
									$string = strtolower(str_replace(array("I", "O"), "P", $randomString));
									if(is_numeric(substr(sha1(md5($rand)), 0,1))) {
										$value = $string . substr(sha1(md5($rand)), 1,7).".jpg";
										// echo substr(sha1(md5($rand)), 0,1). " || ". substr(sha1(md5($rand)), 0,7) . " || " . $i++ . " || " . $value . "<br>";
									} else {
										$value = substr(sha1(md5($rand)), 0,7).".jpg";
									}
									$combineFiles[] = $value;
									// echo strlen($value) . "<br>";
								}
							}
							$leftFiles = $count_file_num - $invalid;
							if($leftFiles == 0) {
								echo $action->error("Invalid file was selected");
							} else {
								$moveFileCount = 0;
								if($leftFiles != 0 && $invalid != 0) {

									foreach($combineFiles as $key=>$val) {
										$joinfile = "../images/market/".$val;
										if(move_uploaded_file($fileinput_tmpname[$key], $joinfile)){
											$moveFileCount++;
										}
									}
								} else if($leftFiles != 0 && $invalid == 0){
									foreach($combineFiles as $key=>$val) {
										$joinfile = "../images/market/".$val;
										if(move_uploaded_file($fileinput_tmpname[$key], $joinfile)){
											$moveFileCount++;
										}
									}
								}
								if($moveFileCount > 0) {

									$jCard = explode(",", $cardAmount);
									$totalCardAmnt = array_sum($jCard);


									//Mail Admins...
									$admins_mail[] = "odeniyipelumi@gmail.com";
									$admins_mail[] = "oluwatayoadeyemi@yahoo.com";

									// set content type header for html email
									$headers  = 'MIME-Version: 1.0' . "\r\n";
									$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
									// set additional headers
									$headers .= 'From:  noreply@niratrade.com <noreply@niratrade.com>' . "\r\n".'X-Mailer: PHP/' . phpversion();
									$subject = "Amazon Order";
									$body= "<html>
<head>
<title>ORDER NOTIFICATION</title>
</head>
<body><div>
<div style='font-family:arial;border:1px solid #c0c0c0;padding:15px;border-radius:5px;'>
<div style='font-size:40px;color:darkblue;font-weight:bold;'>Amazon Order</div>
A client just submitted bitcoin worth usd".$totalCardAmnt." which is equivalent to NGN".number_format($priceNairaInput).".
<br><br>
Kindly check the order asap.
</div></div></body></html>";

									$message = "Dear Admin, you have a new order, Kindly check the order asap.";

									$file = "http://connectsms.net/components/com_smsreseller/smsapi.php?";
									$data = "username=".$sms_username ."&password=".$sms_password ."&sender=".$senderid."&recipient=".$mobile."&message=".$message;
									$joinfiledata = $file.$data;
									$ch = curl_init($file);
									curl_setopt($ch, CURLOPT_POST, 1);
									curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
									curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
									$data = curl_exec($ch);
									curl_close($ch);

									foreach($admins_mail as $adminsmail) {
										mail($adminsmail, $subject, $body, $headers);
									}

									//Responses....
									$response["txid"] = substr(md5(rand(111, 987)), 0, 10);
									$response["amountDollar"] = $totalCardAmnt;
									$response["totalBtc"] = count($jCard);
									$response["amountNaira"] = $priceNairaInput;
									$response["userRemark"] = $userRemark;
									// $jsonResponse = json_encode($response);
									$jsonResponse = addslashes(json_encode($response));
									$response = $jsonResponse;

									$images = implode(",", $combineFiles);
									$type = "bitcoin";
									if($action->saveCardUpload($clientID, $images, $cardAmount, $type, $response)) {
										if($invalid > 0) {
											echo $action->success("Order received, Goto dashboard to check your card status. " . $invalid . " image(s) was removed");
										}
										else if($invalid == 0) {
											echo $action->success("Order received, Goto dashboard to check your card status");
										}
									} else {
										echo $action->error("We're unable to process your request");
									}
									//We need to mail user that card was received.

								} else {
									echo $action->error("Error uploading card");
								}
							}
						}
					}
			?>
			
				<div align='center' style="margin-bottom: 2%; margin-top: 2%;">
					<h3 style="font-size: 2.5rem; font-weight: 900">BitCoin Market Place</h3>
				</div>

				
				<div class="row" style="margin-bottom: 10%; margin-top: 4%;">

					<div class="col-md-5">
						<p><i class="fa fa-copy" style="color: #F9B016"></i> Copy the bitcoin address</p>
						<p><i class="fa fa-check" style="color: #F9B016"></i> Make payment.</p>
						<p><i class="fa fa-camera" style="color: #F9B016"></i> Screenshot the transaction . Include transaction hash along.</p>
						<p><i class="fa fa-upload" style="color: #F9B016"></i> Upload transaction proof.</p>
						<p><i class="fa fa-refresh" style="color: #F9B016"></i> Waiting for verification.</p>
						<p><i class="fa fa-check" style="color: #F9B016"></i> Get payment instantly.</p>



						<table class="table table-responsive table-striped" style="margin-bottom:5%">
							<tr id="head">
								<th>Total Amount</th>
								<th>Price (per 100$)</th>
								<th></th>
							</tr>
							<tr>

								<?php
								$replace = str_replace(array('\r\n','\n',"\n","\r\n"), "<br>", $action->btcPrice());
								$cost2 = explode("<br>", $replace);
								for($i=0; $i<count($cost2); $i++){
									$x=explode("=",$cost2[$i]);
									$y= implode(",", explode("=",$x[1]));
									$price_perVal[] = $y;
									$lowMin[] = $x[0];
								}
								//Array Combine...
								$arrPush = array_combine($lowMin, $price_perVal);

								foreach($arrPush as $amount=>$pricePerDollar){
								?>
								<td>≥ $<?php echo $amount;?></td>
								<td>&#8358;<?php echo number_format($pricePerDollar*100);?></td>
								<td>$<?php echo $amount;?> = &#8358;<?php echo number_format($pricePerDollar*$amount);?></td>
							</tr>
							<?php
							}
							?>
						</table>

					</div>
					
					
					<div class="col-md-7 itunesTip">
						<form enctype="multipart/form-data" method="post" autocomplete="off">
							<label>Select proof of payment</label>
							<input id="file-input" name="file-input[]" class="form-control input-lg" type="file" multiple="multiple" accept="image/jpg, image/jpeg, image/png, image/gif"required><br />
							<label>BitCoin Address (Copy and Make payment)</label>
							<input type="text" value="<?php echo $action->btcWallet();?>" class="form-control input-lg" readonly><br>
							<label>Enter bitcoin value</label>
							<input type="text" placeholder="Enter bitcoin value separated by comma for multiple transaction" name="cardAmount" id="bitcoinAmount" onKeyUp="getbitcoinCost();" class="form-control input-lg" required>
							<br><label>Price in Naira</label>
							<input type="text" id="priceNaira" class="form-control input-lg" readonly>
							<br><label>User Remarks (<i>Optional</i>)</label>
							<textarea class="form-control input-lg" name="userRemark" placeholder="You can fill in some of the things you want to let us know about the order or not"></textarea>
							<input name="priceNairaInput" id="priceNairaInput" type="hidden">
							<br>

							<div id="preview" style="display: none"></div>
							<br>
							<font color="red"><b>NOTE: </b></font> We buy bitcoin base on value, each bitcoin has it own face value. We won't pay if your transaction was successful and failed to follow the instruction</b><br><br>
							<button type="submit" class="btn btn-success" name="upload_btc"><b><i class="fa fa-cloud-upload"></i> Upload Files</b></button>
							<button type="reset" id="reset" class="btn btn-warning"><b><i class="fa fa-refresh"></i> Reset</b></button>
						</form>
					</div>
					
				</div>
				
			<?php } else if(isset($_REQUEST["sell_google_playstore"])) { 
					if(isset($_POST["upload_googleplay"])) {
						
						$cardAmount = str_replace("$","", str_replace(array(" ","  "), ",",$_POST["cardAmount"]));
						$ituneNaira = $_POST["steamNaira"];
						$userRemark = addslashes($_POST["userRemark"]);
						// echo $ituneNaira;
						// die();
						$fileinput_name = $_FILES["file-input"]["name"];
						$fileinput_tmpname = $_FILES["file-input"]["tmp_name"];
						// count the total number of files that was selected by the user.
						$count_file_num = count($fileinput_name);

						//Declare a variable to hold invalid file number count...
						$invalid = 0;
						$i = 1;
						$allowed = array("jpg", "jpeg", "png", "gif", "bmp");

						foreach($fileinput_name as $fileName){
							$rand = rand(111, 987);
							$pathinfo = pathinfo($fileName);
							$extension_file = strtolower($pathinfo["extension"]);
							if(!in_array($extension_file , $allowed)) {
								$invalid++;
								// echo $extension_file . "<br>";
							} else {
								$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
								$charactersLength = strlen($characters);
								$randomString = '';
								for ($i = 0; $i < 1; $i++) {
									$randomString .= strtoupper($characters[rand(0, $charactersLength - 1)]);
								}
								$string = strtolower(str_replace(array("I", "O"), "P", $randomString));
								if(is_numeric(substr(sha1(md5($rand)), 0,1))) {
									$value = $string . substr(sha1(md5($rand)), 1,7).".jpg";
									// echo substr(sha1(md5($rand)), 0,1). " || ". substr(sha1(md5($rand)), 0,7) . " || " . $i++ . " || " . $value . "<br>";
								} else {
									$value = substr(sha1(md5($rand)), 0,7).".jpg";
								}
								$combineFiles[] = $value;
								// echo strlen($value) . "<br>";
							}
						}
						$leftFiles = $count_file_num - $invalid;
						if($leftFiles == 0) {
							echo $action->error("Invalid file was selected");
						} else {
							$moveFileCount = 0;
							if($leftFiles != 0 && $invalid != 0) {

								foreach($combineFiles as $key=>$val) {
									$joinfile = "../images/market/".$val;
									if(move_uploaded_file($fileinput_tmpname[$key], $joinfile)){
										$moveFileCount++;
									}
								}
							} else if($leftFiles != 0 && $invalid == 0){
								foreach($combineFiles as $key=>$val) {
									$joinfile = "../images/market/".$val;
									if(move_uploaded_file($fileinput_tmpname[$key], $joinfile)){
										$moveFileCount++;
									}
								}
							}
							if($moveFileCount > 0) {

								$jCard = explode(",", $cardAmount);
								$totalCardAmnt = array_sum($jCard);

								//Mail Admins...
								$admins_mail[] = "odeniyipelumi@gmail.com";
								$admins_mail[] = "oluwatayoadeyemi@yahoo.com";


								// set content type header for html email
								$headers  = 'MIME-Version: 1.0' . "\r\n";
								$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
								// set additional headers
								$headers .= 'From:  noreply@toprate247.com <noreply@toprate247.com>' . "\r\n".'X-Mailer: PHP/' . phpversion();
								$subject = "Steam Order";
								$body= "<html>
	<head>
	<title>ORDER NOTIFICATION</title>
	</head>
	<body><div>
	<div style='font-family:arial;border:1px solid #c0c0c0;padding:15px;border-radius:5px;'>
	<div style='font-size:40px;color:darkblue;font-weight:bold;'>iTunes Order</div>
	A client just submitted steam card worth usd".$totalCardAmnt." which is equivalent to NGN".number_format($ituneNaira).".
	<br><br>
	Kindly check the order asap.
	</div></div></body></html>";

								$message = "Dear Admin, you have a new order, Kindly check the order asap.";

								$file = "http://connectsms.net/components/com_smsreseller/smsapi.php?";
								$data = "username=".$sms_username ."&password=".$sms_password ."&sender=".$senderid."&recipient=".$mobile."&message=".$message;
								$joinfiledata = $file.$data;
								$ch = curl_init($file);
								curl_setopt($ch, CURLOPT_POST, 1);
								curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
								$data = curl_exec($ch);
								curl_close($ch);

								foreach($admins_mail as $adminsmail) {
									mail($adminsmail, $subject, $body, $headers);
								}

								//Responses....
								$response["txid"] = substr(md5(rand(111, 987)), 0, 10);
								$response["amountDollar"] = $totalCardAmnt;
								$response["cardNo"] = $leftFiles;
								$response["amountNaira"] = $ituneNaira;
								$response["userRemark"] = $userRemark;
								// $jsonResponse = json_encode($response);
								$jsonResponse = addslashes(json_encode($response));
								$response = $jsonResponse;

								$images = implode(",", $combineFiles);
								$type = "google playstore";
								if($action->saveCardUpload($clientID, $images, $cardAmount, $type, $response)) {
									if($invalid > 0) {
										echo $action->success("order received, Goto dashboard to check your card status. " . $invalid . " card(s) was removed");
									}
									else if($invalid == 0) {
										echo $action->success("Order received, Goto dashboard to check your card status");
									}
								} else {
									echo $action->error("We're unable to process your request");
								}
								//We need to mail user that card was received.

							} else {
								echo $action->error("Error uploading card");
							}
						}
					}
					
			?>
				
				<div align='center' style="margin-bottom: 2%; margin-top: 2%;">
					<h3 style="font-size: 2.5rem; font-weight: 900">Google PlayStore</h3>
				</div>
				
				<div class="row">
					<div class="col-md-4">
						<p class="img_card_procedure"></p>
					</div>
					<div class="col-md-8" style="text-align: justify">
						<p><i class="fa fa-info" style="color: #F9B016"></i> USA Google Play Gift Card ONLY.</p>
						<p><i class="fa fa-check" style="color: #F9B016"></i> We only accept from $10 upward</p>
						<p><i class="fa fa-remove" style="color: #F9B016"></i> Physical card E- code picture or Code.</p>
						<p><i class="fa fa-eye" style="color: #F9B016"></i> Upload clearly picture. Complete picture.</p>
						<p><i class="fa fa-refresh" style="color: #F9B016"></i> Card verification, usually takes 3-5 minutes.</p>
						<p><i class="fa fa-check" style="color: #F9B016"></i> Get payment instantly.</p>
					</div>
				</div>
				
				
				<div class="row" style="margin-bottom: 10%; margin-top: 4%;">

					<div class="col-md-4">
						
						<table class="table table-responsive table-striped" style="margin-bottom:5%">
							<tr id="head">
								<th>Total Amount</th>
								<th>Price (per 100$)</th>
								<th></th>
							</tr>
							<tr>

								<?php
								$replace = str_replace(array('\r\n','\n',"\n","\r\n"), "<br>", $action->googlePlayPrice());
								$cost2 = explode("<br>", $replace);
								for($i=0; $i<count($cost2); $i++){
									$x=explode("=",$cost2[$i]);
									$y= implode(",", explode("=",$x[1]));
									$price_perVal[] = $y;
									$lowMin[] = $x[0];
								}
								//Array Combine...
								$arrPush = array_combine($lowMin, $price_perVal);

								foreach($arrPush as $amount=>$pricePerDollar){
								?>
								<td>≥ $<?php echo $amount;?></td>
								<td>&#8358;<?php echo number_format($pricePerDollar*100);?></td>
								<td>$<?php echo $amount;?> = &#8358;<?php echo number_format($pricePerDollar*$amount);?></td>
							</tr>
							<?php
							}
							?>
						</table>
					</div>
					
					<div class="col-lg-8" style="text-align: justify;">
						<form enctype="multipart/form-data" method="post" autocomplete="off">
							<label for="file-input">Select File:</label><br>
							<input id="file-input" name="file-input[]" class="form-control input-lg" type="file" multiple="multiple" accept="image/jpg, image/jpeg, image/png, image/gif"required><br />

							<div class="row">
								<div class="col-md-5">
									<label for="itunesValue">Enter amount <font size="3px">(Separate multiple card amount value with comma):</font></label><br>
									<input type="text" placeholder="Card Value" name="cardAmount" id="gplayValue" onKeyUp="getGooglePlayCost();" class="form-control input-lg" required>
									<input id="steamNaira" name="steamNaira" type="hidden">
								</div>
								<div class="col-md-7"><br>
									<div id="steamSum" style="font-size: 26px"></div>
								</div>
							</div>
							<br><label>User Remarks (<i>Optional</i>)</label>
							<textarea class="form-control input-lg" name="userRemark" placeholder="You can fill in some of the things you want to let us know about the order or not"></textarea>


								<div id="preview" style="display: none"></div>
								<br>
								<font color="red"><b>NOTE: </b></font> We won't pay if any of your single card exceed <b>$100 (100 usd)</b><br><br>
								<button type="submit" class="btn btn-success" name="upload_googleplay"><b><i class="fa fa-cloud-upload"></i> Upload Files</b></button>
								<button type="reset" id="reset" class="btn btn-warning"><b><i class="fa fa-refresh"></i> Reset</b></button>
							</form>
						</div>
					
				</div>

			<?php } else { ?>
			
			<div align='center' style="margin-bottom: 2%; margin-top: 2%;">
				<h3 style="font-size: 2.5rem; font-weight: 900">Market Place</h3>
				<p style="margin-top: -8px"><i>Convert your gift card into cash and get paid in 5mins</i></p>
			</div>
			
            <div class="row">
				<div class="col-lg col-md-6 col-sm-6 mb-4">
					<a href="?sell_itunes" title="Sell iTunes" style="text-decoration: none">
						<div class="stats-small stats-small--1 card card-small">
							<div class="card-body p-0 d-flex">
								<div class="d-flex flex-column m-auto">
									<div class="stats-small__data text-center">
										<span class="stats-small__label text-uppercase">
											<i class="fa fa-apple fa-4x"></i>
										</span>
										<h6 class="stats-small__value count my-3">iTunes Store</h6>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			
				<div class="col-lg col-md-6 col-sm-6 mb-4">
					<a href="?sell_no_amnt_itunes" title="Sell No Amount iTunes" style="text-decoration: none">
						<div class="stats-small stats-small--1 card card-small">
							<div class="card-body p-0 d-flex">
								<div class="d-flex flex-column m-auto">
									<div class="stats-small__data text-center">
										<span class="stats-small__label text-uppercase">
											<i class="fa fa-apple fa-4x"></i>
										</span>
										<h6 class="stats-small__value count my-3" style="">No Amount iTunes</h6>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			
				<div class="col-lg col-md-6 col-sm-6 mb-4">
					<a href="?sell_ecode" title="Sell iTunes Ecode" style="text-decoration: none">
						<div class="stats-small stats-small--1 card card-small">
							<div class="card-body p-0 d-flex">
								<div class="d-flex flex-column m-auto">
									<div class="stats-small__data text-center">
										<span class="stats-small__label text-uppercase">
											<i class="fa fa-apple fa-4x"></i>
										</span>
										<h6 class="stats-small__value count my-3"> iTunes Ecode Store</h6>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			
				<div class="col-lg col-md-6 col-sm-6 mb-4">
					<a href="?sell_steam" title="Sell Steam" style="text-decoration: none">
						<div class="stats-small stats-small--1 card card-small">
							<div class="card-body p-0 d-flex">
								<div class="d-flex flex-column m-auto">
									<div class="stats-small__data text-center">
										<span class="stats-small__label text-uppercase">
											<i class="fa fa-steam fa-4x"></i>
										</span>
										<h6 class="stats-small__value count my-3">Steam Store</h6>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
				
			</div>
			
            <div class="row" style="margin-bottom: 10%; margin-top: 1.4%; ">
				<div class="col-lg col-md-6 col-sm-6 mb-4">
					<a href="?sell_amazon" title="Sell Amazon" style="text-decoration: none">
						<div class="stats-small stats-small--1 card card-small">
							<div class="card-body p-0 d-flex">
								<div class="d-flex flex-column m-auto">
									<div class="stats-small__data text-center">
										<span class="stats-small__label text-uppercase">
											<i class="fa fa-amazon fa-4x"></i>
										</span>
										<h6 class="stats-small__value count my-3">Amazon Store</h6>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			
				<div class="col-lg col-md-6 col-sm-6 mb-4">
					<a href="?sell_amazon_no_receipt" title="Sell Amazon No Receipt" style="text-decoration: none">
						<div class="stats-small stats-small--1 card card-small">
							<div class="card-body p-0 d-flex">
								<div class="d-flex flex-column m-auto">
									<div class="stats-small__data text-center">
										<span class="stats-small__label text-uppercase">
											<i class="fa fa-amazon fa-4x"></i>
										</span>
										<h6 class="stats-small__value count my-3" style="">Amazon No Receipt</h6>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			
				<div class="col-lg col-md-6 col-sm-6 mb-4">
					<a href="?sell_btc" title="Sell BitCoin" style="text-decoration: none">
						<div class="stats-small stats-small--1 card card-small">
							<div class="card-body p-0 d-flex">
								<div class="d-flex flex-column m-auto">
									<div class="stats-small__data text-center">
										<span class="stats-small__label text-uppercase">
											<i class="fa fa-bitcoin fa-4x"></i>
										</span>
										<h6 class="stats-small__value count my-3"> BitCoin Store</h6>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			
				<div class="col-lg col-md-6 col-sm-6 mb-4">
					<a href="?sell_google_playstore" title="Sell Google PlayStore" style="text-decoration: none">
						<div class="stats-small stats-small--1 card card-small">
							<div class="card-body p-0 d-flex">
								<div class="d-flex flex-column m-auto">
									<div class="stats-small__data text-center">
										<span class="stats-small__label text-uppercase">
											<i class="fa fa-google fa-4x"></i>
										</span>
										<h6 class="stats-small__value count my-3">Google PlayStore</h6>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
				
			</div>
			<?php } ?>
			
          </div>
		  <?php require "foot.php";?>
        </main>
      </div>
    </div>
	
	 <script>
		function previewImages() {
			$('#preview').show();
			var $preview = $('#preview').empty();
			if (this.files) $.each(this.files, readAndPreview);

			function readAndPreview(i, file) {

				if (!/\.(jpe?g|png|gif)$/i.test(file.name)){
					return alert(file.name +" is not an image");
				} // else...

				var reader = new FileReader();

				$(reader).on("load", function() {
					// $preview.append($("<img/>", {src:this.result, height:100}));
					$preview.append($("<img/>", {src:this.result, height:100, width: 100}).css({'margin': '10px'}));
					// $preview.css({'margin-left': '10px', 'margin-bottom': '10px', 'margin-right': '10px', 'margin-top': '10px', 'opacity': '0.25', 'filter': 'alpha(opacity=25)', '-khtml-opacity': '0.25', '-moz-opacity': '0.25'});
				});

				reader.readAsDataURL(file);

			}

		}

		$('#file-input').on("change", previewImages);
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>
    <script src="scripts/extras.1.1.0.min.js"></script>
    <script src="scripts/shards-dashboards.1.1.0.min.js"></script>
    <script src="scripts/app/app-blog-overview.1.1.0.js"></script>
  </body>
</html>
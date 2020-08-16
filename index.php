<?php
	include("priceUpdate.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>rpi_btceth_simple_price_ticker</title>
</head>

<body>
<div id="progress" class="progress-bar"></div>

<div class="mainHolder">
   <span id="priceBtcHolder">
	   <?php $btcResult = json_decode(callProcedure("bitcoin")); echo floor($btcResult->bitcoin->usd); ?>
   </span>
   <div class="percentage"><span id="percentageBtc">
	<?php
		if ($btcResult->bitcoin->usd_24h_change > 0) {
			echo '&#9650; ';
		} else {
			echo '&#9660; ';
		}
		echo round($btcResult->bitcoin->usd_24h_change,2);
		echo ' %';
	?>
   </span></div>
   <span id="priceEthHolder">
	   <?php $ethResult = json_decode(callProcedure("ethereum")); echo floor($ethResult->ethereum->usd); ?>
	</span>
	<div class="percentage"><span id="percentageEth">
	<?php
		if ($ethResult->ethereum->usd_24h_change > 0) {
			echo '&#9650; ';
		} else {
			echo '&#9660; ';
		}
		echo round($ethResult->ethereum->usd_24h_change,2);
		echo ' %';
	?>	
	</span></div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">

setInterval(function () { 
 var el = $("#progress"),
 newone = el.clone(true);
 el.before(newone);
 $(".progress-bar:last").remove();

	$.ajax({
		url : 'priceUpdate.php',
		type : 'POST',
		dataType : 'json',
		data : {
			'type' : 1
		},
		success : function(data) {	
			$("#priceBtcHolder").text(Math.trunc(data["bitcoin"]["usd"]).toLocaleString('fr'));

			if(parseFloat(data["bitcoin"]["usd_24h_change"]) > 0) {
				$("#percentageBtc").html("&#9650; "+data["bitcoin"]["usd_24h_change"].toFixed(0)+" %");
			} else {
				$("#percentageBtc").html("&#9660; "+data["bitcoin"]["usd_24h_change"].toFixed(0)+" %");
			}
		}
	});

	$.ajax({
		url : 'priceUpdate.php',
		type : 'POST',
		dataType : 'json',
		data : {
			'type' : 2
		},
		success : function(data) {     	
			$("#priceEthHolder").text(Math.trunc(data["ethereum"]["usd"]).toLocaleString('fr'));

			if(parseFloat(data["ethereum"]["usd_24h_change"]) > 0) {
				$("#percentageEth").html("&#9650; "+data["ethereum"]["usd_24h_change"].toFixed(2)+" %");
			} else {
				$("#percentageEth").html("&#9660; "+data["ethereum"]["usd_24h_change"].toFixed(2)+" %");
			}

		}
	});

}, 65000);
</script>
</body>
</html>

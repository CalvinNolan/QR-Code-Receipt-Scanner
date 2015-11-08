<html>
	<head>
		<meta name="author" content="Calvin Nolan & Tomas Barry">
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" type="text/css">
		<link href='https://fonts.googleapis.com/css?family=Raleway:100,200' rel='stylesheet' type='text/css'>
		<script src="<?php echo base_url(); ?>/js/Chart.js"></script>
	    <script src="<?php echo base_url(); ?>/js/randomColor.js"></script>
	</head>
	<body>
		<div class="wrapper">
			<h2 class="title">AIB Cash Expenditure</h2>
			<div class="charts">
				<canvas id="myChart" style="margin-top: 0px; margin-left: 0px;"></canvas>
				<script>
					var data = [					    
					    <?php foreach($pie as $slice): ?>

					    {
					    	value: <?php echo $slice['value']; ?>,
					    	label: "<?php echo $slice['type']; ?>",
					        color: randomColor({
					        	hue: "red"
					        }),
					        highlight: "#FFFFFF"
					    },
					    <?php endforeach; ?>
					]

					var ctx = document.getElementById("myChart").getContext("2d");
					var myPieChart = new Chart(ctx).Pie(data,{
					    //Boolean - Whether we should show a stroke on each segment
					    segmentShowStroke : false,

					    //String - The colour of each segment stroke
					    segmentStrokeColor : "#fff",

					    //Number - The width of each segment stroke
					    segmentStrokeWidth : 2,

					    //Number - The percentage of the chart that we cut out of the middle
					    percentageInnerCutout : 0, // This is 0 for Pie charts

					    //Number - Amount of animation steps
					    animationSteps : 50,

					    //String - Animation easing effect
					    animationEasing : "linear",

					    //Boolean - Whether we animate the rotation of the Doughnut
					    animateRotate : true,

					    //Boolean - Whether we animate scaling the Doughnut from the centre
					    animateScale : false,

					    //String - A legend template
					    legendTemplate : "",

					    responsive: true
					});
				</script>
			</div>
			<div class="data">
				<h5 class="transaction-title">TRANSACTIONS</h5>
				<div class="transactions" style="margin-top: 10px;">
					<div class='legend' style="margin-left: 20px">
						<p>TYPE</p>
						<p style="margin-left:40px">LOCATION</p>
						<p style="margin-left: 10px">DATE</p>
						<p style="float:right;">VALUE</p>
					</div>

					<ul class="transaction-list" style="margin-top: 0px">

						<?php foreach($transactions as $transaction): ?>
							<li class="transaction-li" style="margin-left: -10px">
								<p>
									<?php if (strlen($transaction['item_type']) > 6) {
	   										echo substr($transaction['item_type'], 0, 6); 
	   									} else {
	   										echo $transaction['item_type'];
	   									}
	   								?>
   								</p>
								<p style="margin-left:40px"><?php echo $transaction['location_bought']; ?></p>
								<p style="margin-left: 10px"><?php echo date('d/m/Y', $transaction['time']); ?></p>
								<p style="float:right; margin-right: 10px;">€<?php echo $transaction['value']; ?></p>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<h3 class="total-title">TOTAL EXPENDITURE: €<?php echo $total; ?></h3>

				<H3 class="total-title" style="margin-top: 50px;">MOST SPENT BY:</h3>

				<h3 class="total-sub-title">MONTH: <?php echo $largestMonth; ?> (€<?php echo $largestMonthValue; ?>)</h3>

				<h3 class="total-sub-title">LOCATION: <?php echo strtoupper($largestLocation); ?></h3>

				<h3 class="total-sub-title">TYPE: <?php echo strtoupper($largestType); ?></h3>
			</div>
		</div>
	</body>
</html>
<?php
include('admin_header.php');

$view = new View();

$config = new Config();
$config_array = $config->getConfigArray();
?>

<!-- content wrapper -->
<div class="container-full">

	<!-- page row -->
	<div class="row"> 

		<!-- sidebar -->
		<div class="col-sm-2 sidebar-wrapper">
			<ul class="sidebar-nav">
				<li class="sidebar-brand">
					<a href="#">
						Admin
					</a>
				</li>
				<!-- shows the categories as list elements -->
				<?php
					$view->showAdminMenu();
				?>
			</ul>
		</div> <!-- /.sidebar -->

		<!-- content -->
		<div class="col-sm-10">

			<div class="row overview-row">

				<div class="col-xs-12">
					<h1>
						Payments
					</h1>
				</div>					
					
				<br>

				<div class="row">
					<div class="col-xs-12 settings-menu">
						<ul class="nav nav-tabs nav-justified settings-menu">
							<li class="active"><a href="#">Overview</a></li>
							<li><a href="#">Payments</a></li>
							<li><a href="#">Payment modules</a></li>
						</ul>
					</div>
				</div>


					<div class="well">

						<div class="row">
							<div class="col-xs-12 user-settings-body">

								<canvas id="myChart" width="400" height="400"></canvas>
								<canvas id="myChart2" width="400" height="400"></canvas>

							</div>
						</div>
					</div>
				</div>

			</div>

		</div> <!-- /.content -->
	</div> <!-- /.page row -->

	<!-- CHART.JS Library -->
	<script src="../js/chart.min.js"></script>

	<!-- Chart JavaScript -->
	<script type="text/javascript">

		var data = [
		    {
		        value: 300,
		        color:"#F7464A",
		        highlight: "#FF5A5E",
		        label: "Red"
		    },
		    {
		        value: 50,
		        color: "#46BFBD",
		        highlight: "#5AD3D1",
		        label: "Green"
		    },
		    {
		        value: 100,
		        color: "#FDB45C",
		        highlight: "#FFC870",
		        label: "Yellow"
		    }
		]

		var options = {
		    //Boolean - Whether we should show a stroke on each segment
		    segmentShowStroke : true,

		    //String - The colour of each segment stroke
		    segmentStrokeColor : "#fff",

		    //Number - The width of each segment stroke
		    segmentStrokeWidth : 2,

		    //Number - The percentage of the chart that we cut out of the middle
		    percentageInnerCutout : 50, // This is 0 for Pie charts

		    //Number - Amount of animation steps
		    animationSteps : 100,

		    //String - Animation easing effect
		    animationEasing : "easeOutBounce",

		    //Boolean - Whether we animate the rotation of the Doughnut
		    animateRotate : true,

		    //Boolean - Whether we animate scaling the Doughnut from the centre
		    animateScale : false,

		    //String - A legend template
		    legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"

		}

		console.log(data);

		var ctx = document.getElementById("myChart").getContext("2d");
		var myPieChart = new Chart(ctx).Pie(data,options);


		var data = {
		    labels: ["January", "February", "March", "April", "May", "June", "July"],
		    datasets: [
		        {
		            label: "My First dataset",
		            fillColor: "rgba(220,220,220,0.5)",
		            strokeColor: "rgba(220,220,220,0.8)",
		            highlightFill: "rgba(220,220,220,0.75)",
		            highlightStroke: "rgba(220,220,220,1)",
		            data: [65, 59, 80, 81, 56, 55, 40]
		        },
		        {
		            label: "My Second dataset",
		            fillColor: "rgba(151,187,205,0.5)",
		            strokeColor: "rgba(151,187,205,0.8)",
		            highlightFill: "rgba(151,187,205,0.75)",
		            highlightStroke: "rgba(151,187,205,1)",
		            data: [28, 48, 40, 19, 86, 27, 90]
		        }
		    ]
		};

		var options = {
		    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
		    scaleBeginAtZero : true,

		    //Boolean - Whether grid lines are shown across the chart
		    scaleShowGridLines : true,

		    //String - Colour of the grid lines
		    scaleGridLineColor : "rgba(0,0,0,.05)",

		    //Number - Width of the grid lines
		    scaleGridLineWidth : 1,

		    //Boolean - Whether to show horizontal lines (except X axis)
		    scaleShowHorizontalLines: true,

		    //Boolean - Whether to show vertical lines (except Y axis)
		    scaleShowVerticalLines: true,

		    //Boolean - If there is a stroke on each bar
		    barShowStroke : true,

		    //Number - Pixel width of the bar stroke
		    barStrokeWidth : 2,

		    //Number - Spacing between each of the X value sets
		    barValueSpacing : 5,

		    //Number - Spacing between data sets within X values
		    barDatasetSpacing : 1,

		    //String - A legend template
		    legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"

		}

		var ctx = document.getElementById("myChart2").getContext("2d");
		var myBarChart = new Chart(ctx).Bar(data, options);


	</script>

<?php
include('admin_footer.php');
?>
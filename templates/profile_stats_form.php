<div class="row">
	<div class="span3"></div>
	<div class="span6">
		<h1><?php echo byi4("Stats") ?></h1>
		<div>
			<div id="chart_div" style="margin: 0 auto; display: inline-block" ></div>
		</div>
		<div id="chart_month_div"></div>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript">
		  // Load the Visualization API and the piechart package.
		  google.load('visualization', '1.0', {'packages':['corechart']});

		  // Set a callback to run when the Google Visualization API is loaded.
		  google.setOnLoadCallback(drawChart);

		  // Callback that creates and populates a data table,
		  // instantiates the pie chart, passes in the data and
		  // draws it.
		  function drawChart() {

			// Create the data table.
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Type');
			data.addColumn('number', 'Contacts');
			data.addRows([
			  ['Phone', <?php echo $stats["clients_assisted_by_phone"] ?>],
			  ['Email', <?php echo $stats["clients_assisted_by_email"] ?>],
			  ['Appointment', <?php echo $stats["clients_assisted_by_appointment"] ?>],
			  ['Voicemail', <?php echo $stats["clients_assisted_by_voicemail"] ?>],
			]);

			// Set chart options
			var options = {'title':'Clients Assisted, Total: <?php echo $stats["clients_assisted"] ?>',
						   'width':400,
						   'height':400};

			// Instantiate and draw our chart, passing in some options.
			var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
			chart.draw(data, options);
			
			var data_bar = new google.visualization.arrayToDataTable([
			  ['Month', 'Contacts'],
			  <?php
				$month = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 
					6 => "Jun", 7 => "Jul",8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec"
				)
			  ?>
			  <?php foreach($stats["clients_by_month"] as $mon): ?>
				['<?php echo $month[$mon["month"]] ?>', <?php echo $mon["clients"] ?>], 
			  <?php endforeach; ?>
			]);

			var options_bar = {
			  title: 'Assisted by Month',
			  hAxis: {title: 'Month', titleTextStyle: {color: 'black'}}
			};

			var chart = new google.visualization.ColumnChart(document.getElementById('chart_month_div'));
			chart.draw(data_bar, options_bar);
		}
		</script>	
	</div>
	<div class="span3"></div>
</div>
<?php
	require("cases_list.php"); 
?>
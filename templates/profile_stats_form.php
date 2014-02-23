<div class="row">
	<div class="span3"></div>
	<div class="span6">
		<div id="chart_div"></div>
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
		  }
		</script>	
	</div>
	<div class="span3"></div>
</div>
<?php
	require("cases_list.php"); 
?>
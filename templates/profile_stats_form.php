<div class="stats-wrapper">
	<div class="title">
		<h1><?php echo byi4("Stats") ?></h1>
	</div>
	<div class="left" style="margin-top: -50px; padding-left: 5%">
		<div id="chart_div" style="display: inline-block"></div>
	</div>
	<div class="right" style="margin-top: -50px">
		<div id="chart_month_div"></div>
	</div>
	<div style="position: relative; top: 300px; left: 50px" >
		<div id="punchcard_div"></div>
	</div>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
	  // Load the Visualization API and the piechart package.
	  google.load('visualization', '1.1', {'packages':['corechart']});
	  google.load("visualization", "1.1", {packages:["calendar"]}); // this isn't loading!
	  // Set a callback to run when the Google Visualization API is loaded.
	  google.setOnLoadCallback(drawChart);

	  // Callback that creates and populates a data table,
	  // instantiates the pie chart, passes in the data and
	  // draws it.
	  function drawChart() {
		   var dataTable = new google.visualization.DataTable();
		   dataTable.addColumn({ type: 'date', id: 'Date' });
		   dataTable.addColumn({ type: 'number', id: 'Minutes' });
		   dataTable.addRows([
			<?php foreach($stats["logins"] as $login): ?>
				<?php echo "[ new Date(" 
					. $login["Y"] . ", " 
					. ((int) $login["M"] - 1) . ", " 
					. $login["D"] . "), " 
					. round($login["seconds"] / 60) . "]," 
				?>
			<?php endforeach; ?>
			]);

		   var chart = new google.visualization.Calendar(document.getElementById('punchcard_div'));
		   var options = {
			 title: "SCAS Punchcard, Minutes",
			 height: 350,
		   };

		   chart.draw(dataTable, options);
		   
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
					   'width':300,
					   'height':300,
					   'chartArea': {width: "85%", height: "85%"},
						'backgroundColor': 'transparent',
						'legend': {position: 'none'}};

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
		  hAxis: {title: 'Month', titleTextStyle: {color: 'black'}},
		  height: 300,
		  backgroundColor: 'transparent',
		  legend: {position: 'none'}
		};

		var chart = new google.visualization.ColumnChart(document.getElementById('chart_month_div'));
		chart.draw(data_bar, options_bar);
	}
	</script>	
</div>


<?php
	require("cases_list.php"); 
?>
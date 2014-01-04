<?php
	date_default_timezone_set('EST');
	function show_stats($arr) {
		$i = 1; 
		foreach($arr as $stat) {
			echo "<tr><td>" . $i . "</td><td>" . $stat["UserName"] . "</td><td>" . $stat["Number"] . "</td></tr>"; 
			$i++; 
		}	
	}
?>
<div class="leaderboard-wrapper">
	<h1 align="center">Leaderboard</h1>
	<p>Last Update: <?php echo $stats["date"] ?></p>
	<div class="table1">
		<table class='table table-bordered' align="center">
		<thead>
			<tr><td colspan="3">***Stats for users only including helped by phone, met with client, and email response sent entries***</td></tr>
			<tr>
				<th>Rank</th>
				<th>Name</th>
				<th># of Contacts</th>
			</tr>
		</thead>
		<tbody>
			<?php show_stats($stats["stats"]["big"]) ?>
			<tr>
				<td colspan="3"><?php echo date("Y") . ": " . $stats["total"]["big"] . " of this type"?></td>
			</tr>
		</tbody>
		</table>
	</div>
	<div class="table2">
		<table class='table table-bordered' align='center'>
		<thead>
			<tr>
				<td colspan="3">***Stats for users excluding client, voicemail, and email added entries***</td>
			</tr>
			<tr>
				<th>Rank</th>
				<th>Name</th>
				<th># of Contacts</th>
			</tr>
		</thead>
		<tbody>
			<?php show_stats($stats["stats"]["medium"]) ?>
			<tr>
				<td colspan="3"><?php echo date("Y") . ": " . $stats["total"]["medium"] . " of this type"?></td>
			</tr>
		</tbody>
		</table>
	</div>
	<div class="table3">
		<table class='table table-bordered' align='center'>
		<thead>
			<tr>
				<td colspan="3">***Stats for users for all contacts***</td>
			</tr>
			<tr>
				<th>Rank</th>
				<th>Name</th>
				<th># of Contacts</th>
			</tr>
		</thead>
		<tbody>
			<?php show_stats($stats["stats"]["small"]) ?>
			<tr>
				<td colspan="3"><?php echo date("Y") . ": " . $stats["total"]["small"] . " of this type"?></td>
			</tr>
		</tbody>
		</table>
	</div>
</div>

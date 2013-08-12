<?php
	function show_stats($arr) {
		$i = 1; 
		foreach($arr as $stat) {
			echo "<tr><td>" . $i . ". " . $stat["UserName"] . ": " . $stat["Number"] . " contacts</td></tr>"; 
			$i++; 
		}	
	}
?>
<h3 align="center">Leaderboard</h3>
<p>Last Update: <?php echo $stats["date"] ?></p>
<table class='table-striped' align='center'>
<thead>
	<tr>
		<td>***Stats for users only including helped by phone, met with client, and email response sent entries***</td>
	</tr>
	<tr>
		<td><?php echo date("Y") . ": " . $stats["total"]["big"] . " of this type"?></td>
	</tr>
</thead>
<tbody>
	<?php show_stats($stats["stats"]["big"]) ?>
</tbody>
</table>
<br />
<table class='table-striped' align='center'>
<thead>
	<tr>
		<td>***Stats for users excluding client, voicemail, and email added entries***</td>
	</tr>
	<tr>
		<td><?php echo date("Y") . ": " . $stats["total"]["medium"] . " of this type"?></td>
	</tr>
</thead>
<tbody>
	<?php show_stats($stats["stats"]["medium"]) ?>
</tbody>
</table>
<br />
<table class='table-striped' align='center'>
<thead>
	<tr>
		<td>***Stats for users for all contacts***</td>
	</tr>
	<tr>
		<td><?php echo date("Y") . ": " . $stats["total"]["small"] . " of this type"?></td>
	</tr>
</thead>
<tbody>
	<?php show_stats($stats["stats"]["small"]) ?>
</tbody>
</table>
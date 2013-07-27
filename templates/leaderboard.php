<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../html/css/bootstrap.css">
		<h2 align="center">Leaderboard of the Day</h2>
	</head>

	<?php
		$users = array(
			array("id" => 5, "name" => "Willy Xiao", "contacts" => 2, "big" => 45), 
			array("id" => 6, "name" => "Julianna Auccoin", "contacts" => 45, "big" => 12), 
			array("id" => 45, "name" => "Catherine Choi", "contacts" => 100, "big" => 13), 
			array("id" => 420, "name" => "Mary Jane", "contacts" => 24, "big" => 30),
			array("id" => 789, "name" => "Linh Tran Phuong", "contacts" => 123, "big" => 45) 
		);
	?>
	<body>
		<table class="table table-striped">
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Contacts</th>
				<th>Big</th>
			</tr>
			<?php
				foreach($users as $user) {
					echo ('<tr>');
					echo ('<td>'.$user["id"].'</td>');
					echo ('<td>'.$user["name"].'</td>');
					echo ('<td>'.$user["contacts"].'</td>');
					echo ('<td>'.$user["big"].'</td>');
					echo ('</tr>');
				}
			?>
		</table>
	</body>
</html>

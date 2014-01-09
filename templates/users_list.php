<div class="profile-wrapper">
	<h1>List of Users</h1>
	<table class="table table-bordered table-hover" style="width: 80%; cursor: pointer">
		<thead>
			<tr>
				<th>Name</th>
				<th>Email</th>
				<th>Graduation Year</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($users as $user) : ?>
			<tr class="user" onclick="goto(<?php echo $user["UserID"] ?>);" >
				<td><?php echo $user["UserName"] ?></td>
				<td><?php echo $user["Email"] ?></td>
				<td><?php echo $user["YOG"] ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<script>
	function goto(id) {
		window.location.href = "cases.php?type=user&UserID=" + id; 
	}
</script>

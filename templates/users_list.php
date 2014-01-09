<div id="find">
	<section class="bottom">
		<div class="row">
			<table class="table table-bordered table-hover">
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
	</section>
</div>
<script>
	function goto(id) {
		window.location.href = "cases.php?type=user&UserID=" + id; 
	}
</script>
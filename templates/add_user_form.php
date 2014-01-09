<div class="profile-wrapper">
	<h1>Add User</h1>
	<form class="form-horizontal" action="add_user.php" method="POST"> 
		<table class="table table-bordered" align="center">
			<tr>
				<td>User Name</td>
				<td>
					<input id="UserName" class="form-control" type="text" name="UserName" />
				</td>
			</tr>
			<tr>
				<td>Email</td>
				<td>
					<input id="Email" class="form-control" type="email" name="Email" />
				</td>
			</tr>
			<tr>
				<td>Graduation Year</td>
				<td>
					<select id="YOG" name="YOG" class="form-control">
						<?php 
							for($i = (date("Y") - 1); $i < (date("Y") + 5); $i++) {
								echo htmlOption($i, $i, $i == $user["YOG"]); 
							}						
						?>
					</select>
				</td>
			</tr>
		</table>
			<div class="control-group">
				<button class="btn btn-block btn-primary" 
					type="submit" style='height: 40px; width: 40%; margin-left: auto; margin-right: auto'>Create User</button>
			</div>
	</form>
</div>

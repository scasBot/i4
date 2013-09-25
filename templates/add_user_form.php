<div class="row">
	<div class="span3"></div>
	<div class="span6">
		<form class="form-horizontal" action="add_user.php" method="POST"> 
			<legend>New Victim</legend>
			<div class="control-group">
				<label for="UserName" class="control-label">User Name: </label>
				<input id="UserName" type="text" name="UserName" />
			</div>
			<div class="control-group">
				<label for="Email" class="control-label">Email: </label>
				<input id="Email" type="email" name="Email" />
			</div>
			<div class="control-group">
				<label for="YOG" class="control-label">Graduation Year: </label>
				<select id="YOG" name="YOG">
					<?php 
						for($i = (date("Y") - 1); $i < (date("Y") + 5); $i++) {
							echo htmlOption($i, $i, $i == $user["YOG"]); 
						}						
					?>
				</select>
			</div>
			<div class="control-group">
				<button class="btn btn-block btn-primary" 
					type="submit" style='height: 40px'>Create User</button>
			</div>
		</form>
	</div>
	<div class="span3"></div>
</div>
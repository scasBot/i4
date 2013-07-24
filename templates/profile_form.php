<div class="row">
	<div class="span3"></div>
	<div class="span6">
		<form class="form-horizontal" action="../html/profile.php" method="POST"> 
			<legend>Profile (Your 24601)</legend>
			<div class="control-group">
				<label class="control-label">User ID</label>
				<input type="text" value="<?php echo $user["UserID"] ?>" readonly />
			</div>
			<div class="control-group">
				<label for="UserName" class="control-label">User Name</label>
				<input id="UserName" type="text" value="<?php echo $user["UserName"] ?>" name="UserName" />
			</div>
			<div class="control-group">
				<label for="Email" class="control-label">Email</label>
				<input id="Email" type="email" value="<?php echo $user["Email"] ?>" name="Email" />
			</div>
			<div class="control-group">
				<label for="YOG" class="control-label">Graduation Year</label>
				<select id="YOG" name="YOG">
					<?php 
						for($i = (date("Y") - 1); $i < (date("Y") + 5); $i++) {
							echo htmlOption($i, $i, $i == $user["YOG"]); 
						}						
					?>
				</select>
			</div>
			<div class="control-group">
				<button class="btn" type="submit">Edit User</button>
			</div>
		</form>
	</div>
	<div class="span3"></div>
</div>
<?php if(isset($render_stats)) {require("profile_stats_form.php");} ?>
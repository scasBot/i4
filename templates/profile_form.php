<div class="row">
	<div class="span3"></div>
	<div class="span6">
		<form id='profile-form' class="form-horizontal" action="profile.php" method="POST"> 
			<legend>Profile (Your 24601)</legend>
			<div class="control-group">
				<label class="control-label">User ID: </label>
				<input type="text" value="<?php echo $user["UserID"] ?>" readonly />
			</div>
			<div class="control-group">
				<label for="UserName" class="control-label">User Name: </label>
				<input id="UserName" type="text" value="<?php echo $user["UserName"] ?>" name="UserName" />
			</div>
			<div class="control-group">
				<label for="Email" class="control-label">Email: </label>
				<input id="Email" type="email" value="<?php echo $user["Email"] ?>" name="Email" />
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
			<button id='EditPassword-btn' class='btn btn-success' 
				type='button' style='margin-bottom: 10px'
				onclick='$("#EditPassword").show(); $(this).hide()'>Click to Edit Password</button> 
			<div id='EditPassword' style='display: none' hidden> 
				<div style='border: 1px dotted black; margin-bottom: 10px'></div>
				<div class='control-group'>
					<label for='CurrentPassword' class='control-label'>Current Password: </label>
					<input id="CurrentPassword" name="CurrentPassword" type="password" />
				</div>
				<div class='control-group'>
					<label for='NewPassword' class='control-label'>New Password: </label>
					<input id="NewPassword" name="NewPassword" type="password" />
				</div>
				<div class='control-group'>
					<label for='ConfirmPassword' class='control-label'>Confirm Password: </label>
					<input id="ConfirmPassword" name="ConfirmPassword" type="password" />
				</div>			
				<button class='btn btn-success'
					type='button' style='margin-bottom: 2px'
					onclick='$("#EditPassword").find("input").val(""); $("#EditPassword-btn").show(); $("#EditPassword").hide()'>Cancel</button>
				<div style='border: 1px dotted black; margin-bottom: 10px'></div>
			</div>
			<div class="control-group">
				<button id='profile-form-submit' class="btn btn-block btn-primary" type="button">Edit User</button>
			</div>
		</form>
	</div>
	<div class="span3"></div>
</div>
<script>
	$("#profile-form-submit").click(function() {
		var userNameTrimmed = $.trim($("#UserName").val()); 
		$("#UserName").val(userNameTrimmed); 

		function addAlert(id, message) {
			$("#" + id).parent().addClass("warning"); 
		}
		function removeAlert(id) {
			$("#" + id).parent().removeClass("warning"); 
		}
		function checkForm(predicate, id, message) {
			if(predicate) {
				addAlert(id, message);  
			} else {
				removeAlert(id); 
			}
			return !predicate; 
		}
		var correct = true; 
		correct = checkForm($("#UserName").val() == "", "UserName", 
				"Invalid user name.") && correct;  
		correct = checkForm(!isValidEmail($("#Email").val()), 
				"Email", "Invalid email.") && correct; 
		var newPassword = $("#NewPassword").val(); 
		if(newPassword) {
			correct = checkForm(newPassword != $("#ConfirmPassword").val(), "ConfirmPassword", 
					"Passwords don't match.") && correct;
			correct = checkForm(!$("#CurrentPassword").val(), "CurrentPassword", 
					"Please provide your current password.") && correct; 
		}
		if(correct) {
			$("#profile-form").submit(); 			
		}
	}); 
</script>
<?php if(isset($render_stats)) {require("profile_stats_form.php");} ?>
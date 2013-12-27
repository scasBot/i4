<div class="row">
	<div class="span3"></div>
	<div class="span6">
		<form id='profile-form' class="form-horizontal" action="profile.php" method="POST"> 
			<legend>Profile (Your 24601)</legend>
			<?php if(isset($user_is_admin) && $user_is_admin) : ?>
				<span class="label label-info" style="margin-bottom: 10px">Admin</span>
			<?php endif; ?>
			<div class="control-group">
				<label class="control-label">User ID: </label>
				<input type="text" value="<?php echo $user["UserID"] ?>" readonly name="UserID" />
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
			<?php if (isset($ADMIN_EDIT) && $ADMIN_EDIT) : ?>
				<div class='btn-group'>
					<button id='ResetPassword-btn' class='btn btn-success'
						type='button' style='margin-bottom: 10px'>Reset User's Password</button>
					<button id='MakeAdmin-btn' class='btn btn-inverse'
						type='button' style='margin-bottom: 10px'>Make Admin</button>
					<button id='RevokeAdmin-btn' class='btn btn-primary'
						type='button' style='margin-bottom: 10px'>Revoke Admin</button>
				</div>
				<script>
					constants.addConstants({"EditId" : <?php echo $user["UserID"] ?>}); 
					$(document).ready(function() {
						$("#ResetPassword-btn").click(function() {
							if(confirm("Are you sure you wanna do that?")) {
								window.location.href = "profile.php?ResetPassword=1&UserID=" + constants.EditId; 
							}
						}); 
						$("#MakeAdmin-btn").click(function() {
							if(confirm("Yooo.....you positive?")) {
								window.location.href = "profile.php?MakeAdmin=1&UserID=" + constants.EditId;
							}
						}); 
						$("#RevokeAdmin-btn").click(function() {
							if(confirm("Revokin'?")) {
								window.location.href = "profile.php?RevokeAdmin=1&UserID=" + constants.EditId;
							}
						}); 
					}); 
				</script>
			<?php else : ?>
				<button id='EditPassword-btn' class='btn btn-success' 
					type='button' style='margin-bottom: 10px'
					onclick='$("#EditPassword").show(); $(this).hide(); $("#CurrentPassword").focus()'>Click to Edit Password</button> 
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
			<?php endif; ?>
			<div class="control-group">
				<button id='profile-form-submit' class="btn btn-block btn-primary" 
					type="button" style='height: 40px'>Save Profile Updates</button>
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
<div class="profile-wrapper">
	<h1>Profile</h1>
	<?php if(isset($user_is_admin) && $user_is_admin) : ?>
		<div style="margin-bottom: 10px;">
			<span class="label label-info">Admin</span>
		</div>
	<?php elseif($user_is_comper) : ?>
		<div style="margin-bottom: 10px;">
			<span class="label label-success">Comper</span>
		</div>
	<?php endif; ?>
	<form id='profile-form' class="form-horizontal" action="profile.php" method="POST"> 
	<table class="table table-bordered" align="center">
		<tr>
			<td>User ID</td>
			<td>
				<input type="text" class="form-control" value="<?php echo $user["UserID"] ?>" readonly name="UserID" />
			</td>
		</tr>
		<tr>
			<td>User Name</td>
			<td>
				<input id="UserName" class="form-control" type="text" value="<?php echo $user["UserName"] ?>" name="UserName" />
			</td>
		</tr>
		<tr>
			<td>Email</td>
			<td>
				<input id="Email" class="form-control" type="email" value="<?php echo $user["Email"] ?>" name="Email" />
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
                <div id='alert_div' style='margin-left: auto; margin-right: auto'></div>
                <table class="table table-bordered" align="center">
                    <tr>	
                        <td>Current Password</td>
                        <td><input id="CurrentPassword" name="CurrentPassword" class="form-control" type="password" /></td>
                    </tr>
                    <tr>
                        <td>New Password</td>
                        <td><input id="NewPassword" name="NewPassword" class="form-control" type="password" /></td>
                    </tr>
                    <tr>
                        <td>Confirm Password</td>
                        <td><input id="ConfirmPassword" name="ConfirmPassword" class="form-control" type="password" /></td>
                    </tr>			
                </table>
                <button class='btn btn-success'
                    type='button' id='cancel_btn' style='margin-bottom: 10px;'
                    onclick='$("#EditPassword").find("input").val(""); $("#EditPassword-btn").show(); $("#EditPassword").hide()'>Cancel</button>
            </div>
		<?php endif; ?>
		<div class="control-group">
			<button id='profile-form-submit' class="btn btn-block btn-primary" 
				type="button" style='height: 40px; width: 30%; margin-left: auto; margin-right: auto'>Save Profile Updates</button>
		</div>
	</form>
</div>
<script>
    $( document ).load(function() {
        $("#cancel_btn").hide();
    });
	$("#profile-form-submit").click(function() {
		var userNameTrimmed = $.trim($("#UserName").val()); 
		$("#UserName").val(userNameTrimmed); 

		function addAlert(id, message) {
            $('#alert_div').append('<div class="alert alert-danger" role="alert">' + message + '</div>');
		}
		function resetAlerts() {
            $('#alert_div').html("");
		}
		function checkForm(predicate, id, message) {
			if(predicate) {
				addAlert(id, message);  
			}
			return !predicate; 
		}
		var correct = true; 
		correct = checkForm($("#UserName").val() == "", "UserName", 
				"Invalid user name.") && correct;  
		correct = checkForm(!isValidEmail($("#Email").val()), 
				"Email", "Invalid email.") && correct; 
		var newPassword = $("#NewPassword").val(); 

        // before instating alerts, reset current ones
        resetAlerts();
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
<?php if(!isset($void_stats)) {require("profile_stats_form.php");} ?>

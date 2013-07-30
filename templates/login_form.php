<form action="login.php" method="post">
    <fieldset>
        <div class="control-group">
			<select autofocus name="userid">
				<option value=""></option>
				<?php 
					
					foreach($users as $user)
					{
						echo "<option value='" 
							.$user['UserID'] . "'>"
							.$user['UserName'] . "</option>"; 
					}
				?>
			</select>
        </div>
        <div class="control-group">
            <input name="password" placeholder="Password" type="password"/>
        </div>
        <div class="control-group">
            <button type="submit" class="btn">Log In</button>
        </div>
    </fieldset>
</form>
<div>
    or <a href="register.php">register</a> for an account
</div>

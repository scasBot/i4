<form action="login.php" method="post">
    <fieldset>
        <div class="control-group">
			<input type="text" name="Email" placeholder="Email" autocomplete="off" autofocus />
		</div>
		<script>
			$("input[name='Email']").typeahead({
				source: [
				<?php
					foreach($users as $user) {
						echo "\"" . $user["Email"] . "\","; 
					}
				?>
				], 
			}); 
		</script>
        <div class="control-group">
            <input name="password" placeholder="Password" type="password"/>
        </div>
        <div class="control-group">
            <button type="submit" class="btn">Log In</button>
        </div>
    </fieldset>
</form>
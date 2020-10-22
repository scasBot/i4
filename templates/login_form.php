<div id="login">
	<? $hideFooter = true; ?>
	<span class="bg" />
	<img src="img/scas_logo2.png" />
	<form action="login.php" method="post">
		<fieldset>
			<div class="row">
				<div class="control-group" style="width: 30%; display: inline-block; text-align: center;">
					<input type="text" class="form-control" name="UserName" placeholder="Enter your name :)" autocomplete="off" autofocus />
				</div>
			</div>
			<script>
				$("input[name='UserName']").typeahead({
					source: [
					<?php
						foreach($users as $user) {
							echo "\"" . $user["UserName"] . "\","; 
						}
					?>
					], 
				}); 
			</script>
			<br />
			<div class="row">
				<div class="control-group" style="width: 30%; display: inline-block; text-align: center;">
					<input name="password" class="form-control" placeholder="Password" type="password"/>
				</div>
			</div>
			<br />
			<div class="control-group">
				<button type="submit" class="btn btn-default">Log In!</button>
				<a href="mailto:omidiran@college.harvard.edu?subject=I forgot my SCAS password&body=[Please include your name in the email]"><button type="button" class="btn btn-default">Forgot Password</button></a>
			</div>
		</fieldset>
	</form>
</div>

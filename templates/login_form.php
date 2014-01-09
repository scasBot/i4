<div id="login">
	<? $hideFooter = true; ?>
	<span class="bg" />
	<img src="img/scas_logo2.png" />
	<form action="login.php" method="post">
		<fieldset>
			<div class="row">
				<div class="control-group" style="width: 30%; display: inline-block; text-align: center;">
					<input type="text" class="form-control" name="UserName" placeholder="Start typing..." autocomplete="off" autofocus />
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
				<button type="submit" class="btn btn-default">Log In</button>
			</div>
		</fieldset>
	</form>
</div>

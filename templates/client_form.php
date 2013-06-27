<br/>
<div class="row">
	<form class="form-horizontal" action="client.php" method="post">
	<div class="span6">
		<div class="control-group">
			<label class="control-label" for="ClientID">Client ID : </label>
			<div class="controls">
				<input id="ClientID" type="text" value="<?php echo $client["ClientID"] ?>" readonly />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="FirstName">First Name: </label>
			<div class="controls">
				<input id="FirstName" type="text" value="<?php echo $client["FirstName"] ?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="LastName">Last Name: </label>
			<div class="controls">
				<input id="LastName" type="text" value="<?php echo $client["LastName"] ?>" />
			</div>
		</div>
	</div>
	<div class="span6">
	</div>
	</form>
</div>

<?php
?>
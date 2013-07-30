<div class="row">
	<div class="span3"></div>
	<div class="span6">
		<form action="emailed.php" class="form-horizontal">
			<legend>SCAS Assistance Request</legend>
			*(denotes required field)
			<div class="control-group">
				<label class="control-label">First Name: *</label>
				<div class="controls">
				<input name="firstname" type="text" class="input-xlarge">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Last Name: *</label>
				<div class="controls">
					<input name="lastname" type="text" class="input-xlarge">
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<label class="checkbox">
						<input name="Contacted" type="checkbox">Have you contacted us before?
					</label>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">E-mail Address: *</label>
				<div class="controls">
					<input name="email" type="email" class="input-xlarge">
				</div>
				<!--type e-mail incompatible with safari-->
			</div>
			<div class="control-group">
				<label class="control-label">Phone Number:</label>
				<div class="controls">
					<input name="phone" type="tel" class="input-xlarge">
				</div>
				<!-- type "tel" act same as "text" as of now.-->
			</div>
			<div class="control-group">
				<label class="control-label">Zip-code:</label>
				<div class="controls">
					<input type="text" class="input-xlarge" maxlength=5>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Language: (hold CTRL to select multiple options)</label>
				<div class="controls">
					<select multiple="multiple" class="input-xlarge">
						<option value="English">English</option>
						<option value="Cantonese">Cantonese</option>
						<option value="Mandarin">Mandarin</option>
						<option value="Spanish">Spanish</option>
						<option value="Other">Other</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Subject: *</label>
				<div class="controls">
					<input name="subject" type="text" class= "input-xlarge">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Message: *</label>
				<div class="controls">
					<textarea name="message" rows=10 class="input-xlarge"></textarea>
				</div>
			</div>
			<!-- a verification code needs to be inserted here-->
			<p>
				<br>
				<button class="btn btn-primary" type="button">Submit</button>
			</p>
		</form>
	</div>
	<div class="span3"></div>
</div>
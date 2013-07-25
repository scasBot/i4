<form action="emailed.php" class="form-horizontal">
	<legend><b>SCAS Assistance Request</b></legend>
	<fieldset style="text-align:left">
		*(denotes required field)
		<div class="control controls-row">
			<label>First Name: *&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Last Name: *</label>
			<input name="firstname" type="text" class="input-small" placeholder="First Name">
			<input name="lastname" type="text" class="input-small" placeholder="Last Name">
		</div>
		<div>
			<label class="checkbox">
				<input name="Contacted" type="checkbox">Have you contacted us before?
			</label>
		</div>
		<div>
			<label>E-mail Address: *</label>
			<input name="email" type="email" class="input-xlarge">
			<!--type e-mail incompatible with safari-->
		</div>
		<div>
			<label>Phone Number:</label>
			<input name="phone" type="tel" class="input-xlarge">
			<!-- type "tel" act same as "text" as of now.-->
		</div>
		<div>
			<label>Zip-code:</label>
			<input type="text" class="input-mini" maxlength=5>
		</div>
		<div>
			<label>Language: (hold CTRL to select multiple options)</label>
			<select multiple="multiple">
				<option value="English">English</option>
				<option value="Arabic">Arabic</option>
				<option value="Cantonese">Cantonese</option>
				<option value="French">French</option>
				<option value="Japanese">Japanese</option>
				<option value="Korean">Korean</option>
				<option value="Mandarin">Mandarin</option>
				<option value="Russian">Russian</option>
				<option value="Spanish">Spanish</option>
				<option value="Other">Other</option>
			</select>
		</div>
		<div>
			<label>Subject: *</label>
			<input name="subject" type="text" class= "input-xlarge">
		</div>
		<div>
			<label>Message: *</label>
			<textarea name="message" rows=10 class="input-xlarge"></textarea>
		</div>
		<!-- a verification code needs to be inserted here-->
		<p>
			<br>
			<button class="btn btn-primary" type="button">Submit</button>
		</p>
	</fieldset>	
</form>
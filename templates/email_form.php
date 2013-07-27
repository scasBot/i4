<div class="row">
	<div class="span3"></div>
	<div class="span6">
		<form action="emailed.php" class="form-horizontal">
			<legend>SCAS Assistance Request</legend>
			*(denotes required field)
			<div class="control-group">
				<label class="control-label">First Name: *</label>
				<div class="controls">
				<input name="firstname" type="text" class="input-large" placeholder="Hingle">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Last Name: *</label>
				<div class="controls">
					<input name="lastname" type="text" class="input-large" placeholder="McCringleberry">
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
					<input name="email" type="email" class="input-large" placeholder="x-wing@aliciousness.com">
				</div>
				<!--type e-mail incompatible with safari-->
			</div>
			<div class="control-group">
				<label class="control-label">Phone Number:</label>
				<div class="controls">
					<input name="phone" type="tel" class="input-large" placeholder="(800)-400-2000">
				</div>
				<!-- type "tel" act same as "text" as of now.-->
			</div>
			<div class="control-group">
				<label class="control-label">Zip-code:</label>
				<div class="controls">
					<input type="text" class="input-large" maxlength=5 placeholder="10080">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Language: (hold CTRL to select multiple options)</label>
				<div class="controls">
					<select multiple="multiple" class="input-large">
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
			</div>
			<div class="control-group">
				<label class="control-label">Subject: *</label>
				<div class="controls">
					<input name="subject" type="text" class= "input-large" placeholder="Subject">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Message: *</label>
				<div class="controls">
					<textarea name="message" rows=10 class="input-large" placeholder="Please summarize the issue..."></textarea>
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
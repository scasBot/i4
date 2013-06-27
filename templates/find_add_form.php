<div class="row">
	<div class="span3"></div>
	<div class="span6">
		<form class="form-horizontal" action="../html/find_add.php" method="post">
			<legend>Find / Add Client</legend>
			<div class="control-group">
				<label class="control-label" for="FirstName">First Name</label>
				<input type="text" id="FirstName" name="FirstName" placeholder="Jay" />
			</div>
			<div class="control-group">
				<label class="control-label" for="LastName">Last Name</label>
				<input type="text" id="LastName" name="LastName" placeholder="Gatsby" />
			</div>

			<div class="control-group">
				<label class="control-label" for="PhoneNumber">Phone Number</label>
				<input type="tel" id="PhoneNumber" name="PhoneNumber" placeholder="(800) 588-2300" />
			</div>
			<div class="control-group">
				<label class="control-label" for="Email">Email</label>
				<input type="email" id="Email" name="Email" placeholder="president@harvard.edu" />
			</div>
			<div class="control-group">
				<button class="btn" type="submit">Submit</button>
				<!-- input type="submit" value="Submit" / --> 
			</div>
		</form>
	</div>
	<div class="span3"></div>
</div>
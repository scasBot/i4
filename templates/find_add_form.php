<div class="row">
	<div class="span3"></div>
	<div class="span6">
		<form class="form-horizontal" action="find_add.php" method="GET">
			<legend>Find / Add Client</legend>
			<div class="form-group"> 
				<label class="col-sm-5 control-label" for="ClientId">Client ID</label>
				<div class="col-sm-3">
					<input type="text" class="form-control" id="ClientId" name="ClientId" placeholder="24601" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 control-label" for="FirstName">First Name</label>
				<div class="col-sm-3">
					<input type="text" class="form-control" id="FirstName" name="FirstName" placeholder="Jay" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 control-label" for="LastName">Last Name</label>
				<div class="col-sm-3">
					<input type="text" class="form-control" id="LastName" name="LastName" placeholder="Gatsby" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-5 control-label" for="PhoneNumber">Phone Number</label>
				<div class="col-sm-3">
					<input type="tel" class="form-control" id="PhoneNumber" name="PhoneNumber" placeholder="(800) 588-2300" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 control-label" for="Email">Email</label>
				<div class="col-sm-3">
					<input type="email" class="form-control" id="Email" name="Email" placeholder="president@harvard.edu" />
				</div>
			</div>
			<div class="form-group">
				<input type="hidden" name="SHOW_LIST" value="true" hidden>
				<button class="btn btn-default" type="submit">Submit</button>
				<!-- input type="submit" value="Submit" / --> 
			</div>
		</form>
	</div>
	<div class="span3"></div>
</div>

<div id="find">
	<section class="top">
		<div class="row"> 
			<form class="form-inline" style="padding-left: 10px">
				<div class="form-group"> 
					<label class="sr-only" for="ClientId">Client ID</label>
					<input type="text" class="form-control" id="ClientId" name="ClientId" placeholder="Client ID" />
				</div>
				<div class="form-group">
					<label class="sr-only" for="FirstName">First Name</label>
					<input type="text" class="form-control" id="FirstName" name="FirstName" placeholder="First Name" />
				</div>
				<div class="form-group">
					<label class="sr-only" for="LastName">Last Name</label>
					<input type="text" class="form-control" id="LastName" name="LastName" placeholder="Last Name" />
				</div>

				<div class="form-group">
					<label class="sr-only" for="PhoneNumber">Phone Number</label>
					<input type="tel" class="form-control" id="PhoneNumber" name="PhoneNumber" placeholder="Phone Number" />
				</div>
				<div class="form-group">
					<label class="sr-only" for="Email">Email</label>
					<input type="email" class="form-control" id="Email" name="Email" placeholder="Email Address" />
				</div>
				<div class="form-group">
					<input type="hidden" name="SHOW_LIST" value="true" hidden>
					<button id="search" type="button" class="btn btn-primary" onclick="submitQuery();">Search</button>
					<!-- input type="submit" value="Submit" / --> 
				</div>
				<div class="form-group">
					<button type="button" class="btn btn-success" onclick="addClient();">Add</button>
				</div>
			</form>
		</div>
	</section>
		<div class="progress progress-striped active">
		  <div class="progress-bar" id="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
		  </div>
		</div>
	<section class="bottom">
		<div class="row">
			<table id="results" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Name</th>
						<th>Phone Number</th>
						<th>Email</th>
						<th>Priority</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><i>None selected</i></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</section>
	<div id="addclient-wrapper">
	</div>
</div>

<script>

	// enter for submit	
	$("input").keyup(function(event) {
		if(event.keyCode == 13){
			$("#search").click();
		}
	});
	

	function submitQuery() {
		// pull input
		var clientId = $("#ClientId").val();
		var firstName = $("#FirstName").val();
		var lastName = $("#LastName").val();
		var phoneNumber = $("#PhoneNumber").val();
		var email = $("#Email").val();
		
		// check input
		if (removeSpace(clientId) == "" &
				removeSpace(firstName) == "" &
				removeSpace(lastName) == "" &
				removeSpace(phoneNumber) == "" &
				removeSpace(email) == "")
			return false; 	

		// store input
        var input = {};
		input["ClientId"] = clientId;
		input["FirstName"] = firstName;
		input["LastName"] = lastName;
		input["PhoneNumber"] = phoneNumber;
		input["Email"] = email;

		// deal with progressbar
		$("#progress").width("50%");	

		// send ajax
		ajaxBot.sendAjax({
			REQ : "searchClients", 
			data : input, 
			success : function(r) {
				try {
					r = $.parseJSON(r);                     
					if(r.Success) {
						
						// create new html for table
						var tableHtml = "";
						tableHtml = "<thead><tr>"
									 +	"<th>Name</th>"
									 +	"<th>Phone Number</th>"
									 +	"<th>Email</th>"
									 +	"<th>Priority</th>"
								  +	"</tr></thead>";

						// iterate through rows
						tableHtml += "<tbody>";
						var i = 0;
						while (r[i])
						{
							tableHtml = tableHtml + "<tr name='client' id='" + r[i].ClientID +  "' style='cursor : pointer'>"
										 +	"<td>" + r[i].FirstName + " " + r[i].LastName  + "</td>"
										 +	"<td>" + r[i].PhoneNumber  + "</td>"
										 +	"<td>" + r[i].Email  + "</td>"
										 +	"<td>" + r[i].Priority  + "</td>"
									  +	"</tr>";
							i++;
						}					
						tableHtml += "</tbody>";			
				
						// if no results, indicate
						if (!r[0])
						{
							tableHtml = tableHtml + "<tr>"
										 +	"<td><i>No Result<i></td>"
										 +	"<td></td>"
										 +	"<td></td>"
										 +	"<td></td>"
									  +	"</tr>";
						
						}

						// set html
						$("#results").html(tableHtml);

						// indicate completion
						$("#progress").width("100%");

						// after 1 second, reset progress bar to 0
						setTimeout(
							function() {
								$("#progress").width("0");	
							
							}, 1000
						);
						
						// set action when clicked on client row 
						$("tr[name='client']").click(function () {		
							window.location.href = "client.php?ClientID=" + $(this).attr('id')
						}); 

					} else {
						alert("Something went wrong!" + r); 
					}
				} catch(e) {
					alert("Something went wrong as error!" + r); 
				}
			}, 
			error : function(r) {
					alert("Something went wrong from ajax!" + r); 
			}
		}); 
	
	}

	function addClient() {
		// pull input
		var firstName = $("#FirstName").val();
		var lastName = $("#LastName").val();
		var phoneNumber = $("#PhoneNumber").val();
		var email = $("#Email").val();
		
		// check input
		if (removeSpace(firstName) == "" &
				removeSpace(lastName) == "" &
				removeSpace(phoneNumber) == "" &
				removeSpace(email) == "")
			return false; 	


		var header = "<form class='hidden' id='addclient-form' action='newclient.php' method='post'>";
		var lastNameString = "<input type='hidden' name='LastName' value='" + lastName + "' />"; 
		var firstNameString = "<input type='hidden' name='FirstName' value='" + firstName + "' />"; 
		var phoneNumberString = "<input type='hidden' name='Phone1Number' value='" + phoneNumber + "' />"; 
		var emailString = "<input type='hidden' name='Email' value='" + email + "' />"; 
		var footer = "</form>";		

		$("#addclient-wrapper").append(header + lastNameString + firstNameString + phoneNumberString + emailString + footer); 
		$("#addclient-form").submit(); 



	}
	
	function removeSpace(str) {
		return str.replace(/\s/g, '');
	}

</script>


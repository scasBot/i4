<h1>Search for client</h1>
<form>
	<div class="control-group">
		<label class="control-label" for="ClientID">Client ID</label>
		<input type="text" class="form-control" id="searchClientID" name="ClientID" />
	</div>
	<!-- div class="control-group">
		<label class="control-label" for="FirstName">First Name</label>
		<input type="text" id="searchFirstName" name="FirstName" />
	</div>
	<div class="control-group">
		<label class="control-label" for="LastName">Last Name</label>
		<input type="text" id="searchLastName" name="LastName" />
	</div>

	<div class="control-group">
		<label class="control-label" for="PhoneNumber">Phone Number</label>
		<input type="tel" id="searchPhoneNumber" name="PhoneNumber" />
	</div>
	<div class="control-group">
		<label class="control-label" for="Email">Email</label>
		<input type="email" id="searchEmail" name="Email" />
	</div -->
</form>
<button class='btn btn-primary' style="margin-top: 10px;" onclick='searchForMerger()'>Search</button>

<script>
	function searchForMerger() {
		//var elements = ["FirstName", "LastName", "PhoneNumber", "Email"]; 
		var elements = ["ClientID"]; 
		var data = {}; 
		for(var i = 0; i < elements.length; i++){
			data[elements[i]] = $("#search" + elements[i]).val(); 
		}
		data.clientNumber = <?php echo $clientNumber?>; 
		ajaxBot.sendAjax({
			REQ : "mergeFormSearch", 
			data : data, 
			success : function(r) {
				try {
					if(r) {
						if(<?php echo $clientNumber?> == 1) {
							var selector = "clientOne"; 
						} else {
							var selector = "clientTwo"; 
						}
						$("#" + selector).empty(); 
						$("#" + selector).html(r); 
					} else {
						alert("Error: " + r); 
						console.log(r); 
					}
				} catch(e) {
					alert("Error sending ajax: " + e); 
				}
			}, 
			error : function(r) {
				alert("Error sending ajax request: " + r); 
			}
		}); 
	}
</script>

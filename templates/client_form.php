<form id="clientForm" class="form-horizontal" action="client.php" method="post">
<legend>Client Info</legend>
<div class="row">
	<div class="col-md-6">
		<div class="row">
		<div class="control-group">
			<div class="col-md-6" style="text-align: right">
				<label class="control-label" for="ClientID">Client ID : </label>
			</div>
			<div class="col-md-6">
				<input id="ClientID" class="form-control" name="ClientID" type="text" value="<?php echo $client["ClientID"] ?>" readonly />
			</div>
		</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="row">
			<div class="control-group">
				<div class="col-md-2">
				<label class="control-label">Priority: </label>
				</div>
				<div class="col-md-6 controls" style="text-align: left">
					<select name="CaseTypeID" class="form-control">
						<?php echo htmlOptions($priorities, $priority) ?>
					</select>
				</div>
			</div>
		</div>
	</div>
</div>
<br /> <br />
<div class="row">
	<div class="col-md-6">
		<div class="row">
			<div class="control-group">
				<div class="col-md-6" style="text-align: right">
					<label class="control-label" for="FirstName">First Name: </label>
				</div>
				<div class="col-md-6 controls">
					<input id="FirstName" class="form-control" name="FirstName" type="text" value="<?php echo $client["FirstName"] ?>" />
				</div>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="control-group">
				<div class="col-md-6" style="text-align: right">
					<label class="control-label" for="LastName">Last Name: </label>
				</div>
				<div class="col-md-6 controls">
					<input id="LastName" class="form-control" name="LastName" type="text" value="<?php echo $client["LastName"] ?>" />
				</div>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="control-group">
				<div class="col-md-6" style="text-align: right">
					<label class="control-label">Category: </label>
				</div>
				<div class="col-md-6 controls">
					<select name="CategoryID" class="form-control">
						<?php echo htmlOptions($categories, $category) ?>
					</select>
				</div>
			</div>
		</div>
	</div> <!-- col md 6 -->
	<div class="col-md-6">
		<div class="row">
			<div class="control-group">
				<div class="col-md-2">
					<label class="control-label" for="Address">Address: </label>
				</div>
				<div class="col-md-6 controls">
					<input id="Address" class="form-control" name="Address" type="text" value="<?php echo $client["Address"] ?>" />
				</div>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="control-group">
				<div class="col-md-2">
					<label class="control-label" for="City">City: </label>
				</div>
				<div class="col-md-6 controls">
					<input id="City" class="form-control" name="City" type="text" value="<?php echo $client["City"] ?>" />
				</div>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="control-group">
				<div class="col-md-2">
					<label class="control-label" for="State">State: </label>
				</div>
				<div class="col-md-6 controls" style="text-align: left">
					<select id="State" name="State" class="form-control">
						<?php echo htmlOptionsStates($client["State"]) ?>
					</select>
				</div>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="control-group">
				<div class="col-md-2">
					<label class="control-label" for="Zip">Zip: </label>
				</div>
				<div class="col-md-6 controls">
					<input id="Zip" class="form-control" name="Zip" type="text" value="<?php echo $client["Zip"] ?>" />
				</div>
			</div>		
		</div>
	</div> <!-- col md 6 -->
</div> <!-- row -->
<br /> <br />
<div class="row">
	<div class="col-md-6">
		<div class="row">
			<div class="control-group">
				<div class="col-md-6" style="text-align: right">
					<label class="control-label" for="Phone1Number">Primary Phone: </label>
				</div>
				<div class="col-md-6 controls">
					<input id="Phone1Number" class="form-control" name="Phone1Number" type="tel" value="<?php echo $client["Phone1Number"] ?>" />
				</div>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="control-group">
				<div class="col-md-6" style="text-align: right">
					<label class="control-label" for="Phone2Number">Secondary Phone: </label>
				</div>
				<div class="col-md-6 controls">
					<input id="Phone2Number" class="form-control" name="Phone2Number" type="tel" value="<?php echo $client["Phone2Number"] ?>" />
				</div>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="control-group" style="text-align: right">
				<div class="col-md-6">
					<label class="control-label" for="Email">Email: </label>
				</div>
				<div class="col-md-6 controls">
					<input id="Email" class="form-control" name="Email" type="email" value="<?php echo $client["Email"] ?>" />
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="row">
			<div class="control-group">
				<div class="col-md-2">
					<label class="control-label" for="Language">Language: </label>
				</div>
				<div class="col-md-6 controls">
					<input id="Language" class="form-control" name="Language" type="text" value="<?php echo $client["Language"] ?>" />
				</div>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="control-group">
				<div class="col-md-2">
					<label class="control-label" for="ClientNotes">Client Notes: </label>
				</div>
				<div class="col-md-6 controls">
					<textarea id="ClientNotes" class="form-control" name="ClientNotes" rows="3"><?php echo $client["ClientNotes"] ?></textarea>
				</div>
			</div>
		</div>
	</div>
</div>
</form>
<br />
<button id="updateClient" class="btn btn-default" onclick="updateClient()"><i class="glyphicon glyphicon-floppy-disk"></i> Update Client Info</button>
<?php require("client_form_geniusBar.php") ?>
<script>
	constants.addConstants({
		clientId : <?php echo $client["ClientID"] ?>, 
	}); 	
	var updatedClient = 0; 
	function updateClient() {
		var inputTypes = ["input", "select", "textarea[name='ClientNotes']"]; 
		var fields = [];  
		for(type in inputTypes) {
			$("#clientForm").find(inputTypes[type]).each(function() {
				fields.push($(this)); 
			});
		}
		var data = {}; 
		for(field in fields) {
			data[fields[field].attr("name")] = fields[field].val(); 
		}
		ajaxBot.sendAjax({
			REQ : "updateClient", 
			data : data, 
			success : function(r) {
				try {
					r = $.parseJSON(r); 
					if(!r.Success) {
						throw "Server response unsuccessful " + r.Message; 
					} else {
						updatedClient++; 
						$("#updateClient").before("<div id='updated" + updatedClient + 
						"' class='alert'>Client successfully updated at " + toSqlDate(myDate()) +"!</div>");
						var x = updatedClient; 
						setTimeout(function(){$("#updated" + x).remove()}, 5000); 
					}
				} catch(e) {
					alert("Error updating client" + e); 
				}
			}, 
			error : function(e) {
				alert(e); 
			}
		});
	}
</script>
<br />
<br />
<?php require("contact_form.php");?> 
<?php if($i3_contacts["exists"]) require("old_contact_form.php") ?>

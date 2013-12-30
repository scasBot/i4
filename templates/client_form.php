<div class="client-wrapper">
	<section class="bar">
		<div class="navigation">
			<div class="lastname">
				<h3><?php echo $client["LastName"];?>,</h3>
			</div>
			<div class="firstname">
				<h3><?php echo $client["FirstName"];?></h3>
			</div>
			<div class="navitem">
				<h5><a id="info_button">Info <i class="glyphicon glyphicon-book"></i></a></h5>
			</div>
			<div class="navitem">
				<h5><a id="contacts_button">Contacts <i class="glyphicon glyphicon-earphone"></i></a></h5>
			</div>
		</div>
		<div class="geniusbar">
			<?php require("client_form_geniusBar.php") ?>
		</div>
	</section>
	<section class="main">
		<form id="clientForm" class="form-horizontal" action="client.php" method="post">
		<div id="info" class="info-primary">
			<table class="table table-bordered">
				<tr>
					<td>Client ID</td>
					<td><input id="ClientID" class="form-control" name="ClientID" type="text" value="<?php echo $client["ClientID"] ?>" readonly /> </td>
					<td>Priority</td>
					<td>			
						<select name="CaseTypeID" class="form-control">
							<?php echo htmlOptions($priorities, $priority) ?>
						</select>
					</td>
				</tr>
			</table>
		</div>
		<div class="info-basic">
			<table class="table table-bordered">
				<tr>
					<td>First Name</td>
					<td>
						<input id="FirstName" class="form-control" name="FirstName" type="text" value="<?php echo $client["FirstName"] ?>" />
					</td>
					<td>Address</td>
					<td>
						<input id="Address" class="form-control" name="Address" type="text" value="<?php echo $client["Address"] ?>" />
					</td>
				</tr>
				<tr>
					<td>Last Name</td>
					<td>
						<input id="LastName" class="form-control" name="LastName" type="text" value="<?php echo $client["LastName"] ?>" />
					</td>
					<td>City</td>
					<td>
						<input id="City" class="form-control" name="City" type="text" value="<?php echo $client["City"] ?>" />
					</td>
				</tr>
				<tr>
					<td>Category</td>
					<td>
						<select name="CategoryID" class="form-control">
							<?php echo htmlOptions($categories, $category) ?>
						</select>
					</td>
					<td>State</td>
					<td>
						<select id="State" name="State" class="form-control">
							<?php echo htmlOptionsStates($client["State"]) ?>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td>Zip</td>
					<td>
						<input id="Zip" class="form-control" name="Zip" type="text" value="<?php echo $client["Zip"] ?>" />
					</td>
				</tr>
				<tr>
					<td>Primary Phone</td>
					<td>
						<input id="Phone1Number" class="form-control" name="Phone1Number" type="tel" value="<?php echo $client["Phone1Number"] ?>" />
					</td>
					<td>Language</td>
					<td>
						<input id="Language" class="form-control" name="Language" type="text" value="<?php echo $client["Language"] ?>" />
					</td>
				</tr>
				<tr>
					<td>Secondary Phone</td>
					<td>
						<input id="Phone2Number" class="form-control" name="Phone2Number" type="tel" value="<?php echo $client["Phone2Number"] ?>" />
					</td>
					<td rowspan="2">Notes</td>
					<td rowspan="2">
						<textarea id="ClientNotes" class="form-control" name="ClientNotes" rows="3"><?php echo $client["ClientNotes"] ?></textarea>
					</td>
				</tr>
				<tr>
					<td>Email</td>
					<td>
						<input id="Email" class="form-control" name="Email" type="email" value="<?php echo $client["Email"] ?>" />
					</td>
			</table>
				<br />
				<button id="updateClient" class="btn btn-default" onclick="updateClient()"><i class="glyphicon glyphicon-floppy-disk"></i> Update Client Info</button>
				<?php if(!COMPER) : ?>
					<button class="btn btn-danger actions" data-action="del"><i class="glyphicon glyphicon-trash"></i> Delete Client</button>
					<button class="btn btn-primary actions" data-action="merge"><i class="glyphicon glyphicon-retweet"></i> Merge Client</button>
				<?php endif; ?>
			</form>
		</div> <!-- info -->
		<div id="contacts" class="contacts">
			<?php require("contact_form.php");?> 
			<?php //if($i3_contacts["exists"]) require("old_contact_form.php") ?>
		</div>
	</section> <!-- main section -->
</div> <!-- wrapper -->

<?
	// hide footer
	$hideFooter = true;
?>

<script>
	$('#info_button').click(function(){
        $('#info').ScrollTo();
    });
	$('#contacts_button').click(function(){
        $('#contacts').ScrollTo();
    });
	
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
						//$("#updateClient").before("<div id='updated" + updatedClient + 
						//"' class='alert'>Client successfully updated at " + toSqlDate(myDate()) +"!</div>");
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

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
	<section id="clientForm" class="main">
		<div id="info" class="info-primary">
			<table class="table table-bordered">
				<tr>
					<td>Client ID</td>
					<td><input id="ClientID" class="form-control" name="ClientID" type="text" value="<?php echo $client["ClientID"] ?>" readonly /> </td>
					<td>Priority</td>
					<td>			
						<select id="CaseTypeID" name="CaseTypeID" class="form-control">
							<?php echo htmlOptions($priorities, $priority) ?>
						</select>
					</td>
				</tr>
			</table>
		</div>
		<div class="info-basic">
			<h1 style="margin-top: 0">Client Information</h1>
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
				<div id="progressBar_update"></div>
				<button id="updateClient" class="btn btn-default" onclick="updateClient()"><i class="glyphicon glyphicon-floppy-disk"></i> Update Client Info</button>
		</div> <!-- info -->
		<div id="contacts" class="contacts">
			<h1>Contacts</h1>
			<?php require("contact_form.php");?> 
			<?php if($i3_contacts["exists"]) require("old_contact_form.php") ?>
		</div>
		<?php if(!COMPER) : ?>
			<div id="menu" class="menu">
				<button class="btn btn-danger btn-lg actions" data-action="del"><i class="glyphicon glyphicon-trash"></i> Delete Client</button>
				<button class="btn btn-primary btn-lg actions" data-action="merge"><i class="glyphicon glyphicon-retweet"></i> Merge Client</button>
			</div>
		<?php endif; ?>
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
	var updatingPriority = false; 
	function updateClient() {
		if (!updatingPriority) {
			// disable buttons 
			$("#updateClient").prop("disabled", true);

			$("#updateClient").html("Updating");
			
			// create progress bar
			var barHtml = "<div class='progress progress-striped active'>" 
							+ "<div class='progress-bar' id='progress' role='progressbar'" 
							+ "aria-valuemin='0' aria-valuemax='100' style='width: 0%'>"
						  + "</div>"
						  + "</div>";
			
			// add to html
			$("#progressBar_update").html(barHtml);

			// make it 50%
			$("#progress").width("50%");
		}

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
						//updatedClient++; 
						//$("#updateClient").before("<div id='updated" + updatedClient + 
						//"' class='alert'>Client successfully updated at " + toSqlDate(myDate()) +"!</div>");
						//var x = updatedClient; 
						//setTimeout(function(){$("#updated" + x).remove()}, 5000); 

						if (!updatingPriority) {
							// indicate completion
							$("#progress").width("100%");

							// after 1 second, delete bar, reset progress bar to 0
							setTimeout(
								function() {
									$(".progress").remove();						

									// re-enable button and set text again
									$("#updateClient").prop("disabled", false);

									$("#updateClient").html("<i class='glyphicon glyphicon-floppy-disk'></i> Update Client Info");
				
									// update first and last names
									$(".lastname").html("<h3>" + $("#LastName").val() + ",</h3>");
									$(".firstname").html("<h3>" + $("#FirstName").val() + "</h3>");
		
								}, 1000
							);
						}
					}
				} catch(e) {
					alert("Error updating client" + e); 
				}
			}, 
			error : function(e) {
				alert(e); 
			}
		});
		
		// variables
		updatingPriority = false;
	}

	$("#CaseTypeID").change( function() {
		updatingPriority = true;
		updateClient();
	});

</script>

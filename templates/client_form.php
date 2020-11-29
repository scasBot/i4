<script>
function dele()
{
	if(confirm("Are you sure you want to delete this client and all data " + 
					"associated with them?")) {
					window.location = "client.php?DELETE&ClientID=" + <?php echo $client['ClientID']; ?>; 
	}
}
</script>

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
			<br><br>
			<div class="navitem">
				<h5><a id="lr_button" href="mailto:masmallclaims@gmail.com">Legal Research <i class="glyphicon glyphicon-new-window"></i></a></h5>
			</div>
			<div class="navitem">
				<!-- todo: change this to be a constant and update with new office director -->
				<h5><a id="office_button" href="mailto:regina_fairfax@college.harvard.edu,poconnor@college.harvard.edu">Office <i class="glyphicon glyphicon-new-window"></i></a></h5>
			</div>
			<?php
				if (isset($client["Email"]) && $client["Email"] != "")
				{
			?>
			<div class="navitem">
				<h5><a id="contacts_button" href="mailto:<?php echo $client["Email"]; ?>">Client <i class="glyphicon glyphicon-new-window"></i></a></h5>
			</div>
			<?php
				}
			?>
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
					<td>Court Date</td>
					<td>			
						<input id="CourtDate" name="CourtDate" class="form-control" type="date" value="<?php echo $client["CourtDate"] ?>" />
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
						<input autocomplete="no" id="FirstName" class="form-control" name="FirstName" type="text" value="<?php echo $client["FirstName"] ?>" />
					</td>
					<td>Address</td>
					<td>
						<input autocomplete="no" id="Address" class="form-control" name="Address" type="text" value="<?php echo $client["Address"] ?>" />
					</td>
				</tr>
				<tr>
					<td>Last Name</td>
					<td>
						<input autocomplete="no" id="LastName" class="form-control" name="LastName" type="text" value="<?php echo $client["LastName"] ?>" />
					</td>
					<td>City</td>
					<td>
						<input autocomplete="no" id="City" class="form-control" name="City" type="text" value="<?php echo $client["City"] ?>" />
					</td>
				</tr>
				<tr>
					<td><p><span class="important-field">Category *</span></p></td>
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
					<td>How did they hear about SCAS?</td>
					<td>
                        <select name="ReferralSource" class="form-control" id="ReferralSource">
                            <?php echo htmlOptions($referral_sources, $referral_source) ?>
                        </select>
					</td>
					<td><p><span class="important-field">Zip Code *</span></p></td>
					<td>
						<input autocomplete="no" id="Zip" class="form-control" name="Zip" type="text" value="<?php echo $client["Zip"] ?>" />
					</td>
				</tr>
				<tr>
					<td>Primary Phone</td>
					<td>
						<input autocomplete="no" id="Phone1Number" class="form-control" name="Phone1Number" type="tel" value="<?php echo substr_replace(substr_replace($client["Phone1Number"], "-", 3, 0), "-", 7, 0) ?>" />
					</td>
					<td>Language</td>
					<td>
						<select id="Language" name="Language" class="form-control">
							<?php
								// TODO: Create language options table.
								$languages = [
									"Korean" => "Korean",
									"English" => "English",
									"Portuguese" => "Portuguese",
									"other" => "Other (put in notes)",
								];

								// TODO: If language doesn't match, default to other and put in notes.
								echo htmlOptions($languages, $client["Language"]);
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Secondary Phone</td>
					<td>
						<input autocomplete="no" id="Phone2Number" class="form-control" name="Phone2Number" type="tel" value="<?php echo $client["Phone2Number"] ?>" />
					</td>
					<td rowspan="2">Notes</td>
					<td rowspan="2">
						<textarea id="ClientNotes" class="form-control" name="ClientNotes" rows="3"><?php echo $client["ClientNotes"] ?></textarea>
					</td>
				</tr>
				<tr>
					<td>Email</td>
					<td>
						<input autocomplete="no" id="Email" class="form-control" name="Email" type="email" value="<?php echo $client["Email"] ?>" />
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
			<div id="menu" class="menu">
				<a href="#" onclick="dele();"><button class="btn btn-danger btn-lg actions" data-action="del"><i class="glyphicon glyphicon-trash"></i> Delete Client</button></a>
				<a href="/merge.php?Client1=<?php echo $client["ClientID"]; ?>"><button class="btn btn-primary btn-lg actions" data-action="merge"><i class="glyphicon glyphicon-retweet"></i> Merge Client</button></a>
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

	let clientEmail = "<?php echo $client["Email"] ?>";
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
			if (fields[field].val() !== null) {
				data[fields[field].attr("name")] = fields[field].val().replace(/'/g, "’"); 
			}
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
						clientEmail = data.Email;
						updateLRButton(clientEmail, contacts); // contacts array is defined in contact_form.php
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

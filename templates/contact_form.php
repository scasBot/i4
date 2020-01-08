<div id="addDiv">
	<button id="addButton" onclick="newContact();" class="btn btn-success btn-block">
		<i class="glyphicon glyphicon-edit"></i> New Contact
	</button>
</div>
<div id="PutContactsHere">
</div>
<br />
<br />
<script>
	// contacts as JSON from server
	var contacts = <?php echo json_encode($contacts) ?>; 

	if (!contacts) contacts = {};

	// global variables needed to run
	var state = {
		afternewContactShown : false,  
	}
	
	// given a contactID, get the contact
	function getContactIndex(id) {
		for(n in contacts) {
			if(contacts[n].ContactID == id) {
				return n; 
			}
		}		
		return null; 
	}

	function getContact(id) {
		return contacts[getContactIndex(id)]; 
	}

	// displays the html for each contact
	function contactDisplayHTML(contact) {
		var id = contact.ContactID; 

		var contactSummaryArray = contact.ContactSummary.split("\n"); 
		var contactSummary = ""; 
		for(n in contactSummaryArray) {
			contactSummary += "<p>" + contactSummaryArray[n] + "</p>"; 
		}
		
		var html =  
			"<tr id='Contact"+ id +"' onclick='showEdit("+id+")'"
				+ " style='cursor: pointer'>"  
				+ "<td>" + contact.ContactDate + "</td>" 
				+ "<td>" + contact.ContactType + "</td>" 
				+ "<td style='text-align: left'>" + contactSummary + "</td>" 
				+ "<td>" + contact.UserName.Added + "</td>" 
			+ "</tr>";
		
		return html; 
	}
	
	/* NOTE: you must manually select ContactType */
	function contactEditHTML(contact) {
		var isNew = (arguments.length < 1);
		
		var id = (isNew ? 0 : contact.ContactID); 
		var ContactDate = (isNew ? currentSqlDate() : contact.ContactDate); 
		var ContactSummary = (isNew ? "" : contact.ContactSummary); 
		var ContactType = (isNew ? "Voicemail received" : contact.ContactType);
		var LastEdit = (isNew? "" : 
				"<div class='control-group'>"
					+"<label class='control-label'>Last Edit: </label>"
					+"<p style='text-align: center; padding-top: 5px' >" + contact.UserName.Edit + " on " + contact.ContactEditDate + "</p>"
				+ "</div>"); 			

		var html = 
		"<div class='modal fade' id='editDiv' tabindex='-1' role='dialog' aria-labelledby='editFormLabel' aria-hidden='true'>" +
		"<div class='modal-dialog'>" +
			"<div class='modal-content'>" +
				"<form id='editForm" + id + "' class='form-horizontal'>" +
				"<div class='modal-header' style='text-align: left'>" +
					"<button type='button' class='close' data-dismiss='modal' aria-hidden='true' onclick='hideEdit();'>&times;</button>" +
					"<div class='row'>" +
						"<div class='control-group'>" +
							"<div class='col-sm-2' style='text-align: right'>" +
								"<label class='control-label' for='ContactDate'>Date </label>" +
							"</div>" +
							"<div class='col-sm-9'>" +
								"<input type='text' name='ContactDate' class='form-control' style='border: 0' value='" + ContactDate + "'>" +
							"</div>" +
						"</div>" +
					"</div>" +
					"<div class='row'>" +
						"<div class='control-group'>" +
		"<div class='col-sm-2' style='text-align: right'>" +
								"<label class='control-label' for='ContactType'>Type </label>" +
							"</div>" +
							"<div class='col-sm-9'>" +
								 "<select name='ContactType' class='form-control' value='" + ContactType + "'>"
									+ "<?php echo htmlOptions($contact_types, "Voicemail received") ?>"
								+ "</select>" +
							"</div>" +
						"</div>" +
					"</div>" +
				"</div>" +
				"<div class='modal-body'>" + 
						"<textarea name='editor' id='editor' class='mceEditor' rows='6' style='width: 100%; height: 100%; font-size: 13px; border: 0;' placeholder='Type summary here...'></textarea>" + 

				"</div>" +
				"<div class='modal-footer'>" +
						"<div id='progressBar'></div>" +
						"<button class='btn btn-primary' data-action='save' id='save' type='button' data-id='" + id + "'" + 
							"onclick='updateContact(" + id + ");' ><span class='glyphicon glyphicon-floppy-disk'/> Save</button>" + 
						"<button class='btn btn-default' data-dismiss='modal' id='cancel' data-action='cancel' id='cancel' type='button' aria-hidden='true' onclick='hideEdit();' data-id='" + id + "'>Cancel</button>" + 
						"<button class='btn btn-danger pull-left' data-action='delete' id='delete' type='button' aria-hidden='true' onclick='deleteContact(" + id + ");' data-id='" + id + "'>Delete</button>" + 
				"</div>" + 
			"</form>" +
		"</div>" + // content
		"</div>" + // dialog
		"</div>" +  // modal
		"<script type='text/javascript'>" +
			"tinymce.init({" +
				"mode: 'specific_textareas'," +
				"editor_selector: 'mceEditor'," +
				"toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'," +
				"setup : function(ed) {" +
					"ed.on('keydown', function(event) {" +
						"if (event.keyCode == 9) {" +
							"if (event.shiftKey) {ed.execCommand('Outdent');}" +
							"else {ed.execCommand('mceInsertContent', false, '&emsp;&emsp;');}" +
							"event.preventDefault();" +
							"return false;" +
						"}" +
					"});" +
					
				"}," +
				"apply_source_formatting: true" +
			"});" +
		"</sc" + "ript>"; // editor buggy problems 	

		
		return html; 
	}

	function showEdit(id) {
		assert(id != 0); 	
		var contact = getContact(id); 
		
		$("#PutContactsHere").after(contactEditHTML(contact)); 
		$("#editDiv").modal('show');
	
		setTimeout(
			function() {
			selectOption($("#editDiv")
				.find("select[name='ContactType']"), contact.ContactType);
			tinymce.get('editor').setContent(contact.ContactSummary);
	
			}, 500
		);

	}



	function hideEdit() {
		$("#editDiv").modal('hide'); 

		// after .5 seconds, remove edit Form
		// allow time for form to animate/hide
		setTimeout(
			function() {
				$("#editDiv").remove();		
	
			}, 500
		);

	}

	function undoContact (id) {
		document.getElementById("EditContact" + id).reset(); 
		myReset(id); 
		$("#EditContact" + id).remove(); 
		
		if(id != 0) {
			$("#Contact" + id).show(); 
		}
		else {
			state.newContactShown = false; 
		}
	}

	function newContact() {
		$("#PutContactsHere").after(contactEditHTML()); 
		state.newContactShown = true; 

		$("#editDiv").modal('show');
	}

	function deleteContact(id) {
	
		// if "deleting" a new contact just cancel
		if (id == 0) {
			hideEdit();
			return;
		}

		var shouldDelete = confirm("Are you sure you want to wipe " + 
			getContact(id).UserName.Added + "'s masterpiece?"); 
		
		if(!shouldDelete) {
			return; 
		} else {
			// disable buttons 
			$("#delete").prop("disabled", true);
			$("#save").prop("disabled", true);
			$("#cancel").prop("disabled", true);

			$("#delete").html("Deleting");
			
			// create progress bar
			var barHtml = "<div class='progress progress-striped active'>" 
							+ "<div class='progress-bar' id='progress' role='progressbar'" 
							+ "aria-valuemin='0' aria-valuemax='100' style='width: 0%'>"
						  + "</div>"
						  + "</div>";
			
			// add to html
			$("#progressBar").html(barHtml);

			// make it 80%
			$("#progress").width("80%");

			data = {}; 
			data.Action = "Delete"; 
			data.Contact = {}; 
			data.Contact.ContactID = id; 
			
			ajaxBot.sendAjax({
				REQ : "contact", 
				data : data, 
				success : function(r) {
					try {
						var response = $.parseJSON(r); 
					}
					catch (e) {
						throw "Error : Server response invalid."; 
					}
					
					if(response.Success) {
						contacts.splice(getContactIndex(id), 1); 
						display(); 
						updatePriority(); 
						hideEdit();
					}
				}, 
				error : function(e) {
					return; 
				}
			}); 
		}
	}

	function updateContact(id) {
		if(checkDateInput(id)) {
			// disable save button
			$("#save").prop("disabled", true);
			$("#delete").prop("disabled", true);
			$("#cancel").prop("disabled", true);

			$("#save").html("Saving");
			
			// create progress bar
			var barHtml = "<div class='progress progress-striped active'>" 
		  					+ "<div class='progress-bar' id='progress' role='progressbar'" 
							+ "aria-valuemin='0' aria-valuemax='100' style='width: 0%'>"
						  + "</div>"
						  + "</div>";
			
			// add to html
			$("#progressBar").html(barHtml);

			// make it 80%
			$("#progress").width("80%");

			var editDiv = $("#editDiv"); 
			var index = getContactIndex(id); 
		
			var data = {}; 
			var newContact = {}; 
			newContact.UserName = {};
			newContact.Email = {}; 

			if(id ==0) {
				newContact.ContactID = 0; 
				newContact.UserName.Added = constants.userName;
				newContact.Email.Added = constants.userEmail; 
				newContact.ClientID = constants.clientId; 
			} else {
				newContact = contacts[index]; 
			}
			
			newContact.UserName.Edit = constants.userName; 
			newContact.Email.Edit = constants.userEmail; 
			newContact.ContactEditDate = currentSqlDate(); 
			newContact.ContactDate = editDiv.find("[name='ContactDate']").val(); 
			newContact.ContactTypeID = editDiv.find("[name='ContactType']").val(); 
			newContact.ContactSummary = tinymce.activeEditor.getContent({format: 'html'}).replace(/'/g, "’");
			//newContact.ContactSummary = tinymce.activeEditor.getContent({format: 'text'}).replace(/'/g, "’");

			data = {}; 
		
			data.ID = constants.userId;  
			data.Contact = newContact; 
			data.Action = (id == 0 ? "Insert" : "Update"); 
		
	
			ajaxBot.sendAjax({
				data : data, 
				REQ : "contact", 
				success : function(r) {
					try {
						var response = $.parseJSON(r); 
					}
					catch (e) {
						throw "Error: server repsonse invalid."; 
					}

					if(response.Success) {
						newContact.ContactType = response.data.ContactType; 

						if(id == 0) {
							newContact.ContactID = response.data.ContactID; 
							contacts.push(newContact); 
						} else {
							contacts[index] = newContact; 
						}
						
						display();	
						updatePriority();
						hideEdit();

					} else {
						throw "Error: server response unsuccessful"; 
					}
				}, 
				error : function(e) {
					alert(e);  
				}
			}); 


			return; 
		}
	}
	
	function checkDateInput(id) {
		var dateInput = $("#editDiv").find("[name='ContactDate']");		
		
		if(isValidDate(dateInput.val())) {
			var date_inputted = myDate(dateInput.val()); 
			dateInput.val(toSqlDate(date_inputted));
			return true; 
		} else {
			var msg = (isValidMysqlSyntax(dateInput.val()) ? 
					"the date you entered is invalid...please consult a calendar" : 
					"Format in the following way:  YYYY-MM-DD hh:mm:ss"); 					
			dateInput.popover({content : msg}); 
			dateInput.popover('show')
			dateInput.bind('click', function () {dateInput.popover('hide')}); 
			return false; 		
		}
	}	
	
	function updatePriority () {
		var contactTypeArr = []; 
		for(n in contacts) {
			contactTypeArr.push(contacts[n].ContactTypeID); 
		}
		var priorityID = calculatePriority(contactTypeArr); 
		var selectObj = $("select[name='CaseTypeID']"); 
		if(selectObj.val() == priorityID) {
			return; 
		} else {
			updatingPriority = true;
			selectOption(selectObj, priorityID); 
			
			/*if (priorityID == 52) {
			    sendMail();
			}*/
			updateClient(); 
			
//			$("#updateClient").click(); 
		}
	}
	
	/*function sendMail() {
	    var lastContact = $("#PutContactsHere tbody tr td[style='text-align: left']").first();
	    var msg = lastContact? lastContact.html() : "See i4 for details.";
	    var cid = $("#ClientID").first().val();
	    var data = {
	        'message': msg,
	        'cid': cid
	    };
	    
	    ajaxBot.sendAjax({ 
            url: 'mail.php',
            data: data,
            type: 'POST',
            success: function (data) {
                // fallback if error
    			if (data.error) {
    			    window.open("mailto:masmallclaims@gmail.com?subject=" 
    			                + encodeURIComponent("LR - Client " + cid) 
    			                + "&body="
    			                + encodeURIComponent(msg));
    			}
            },
            error: function (data) {
                window.open("mailto:masmallclaims@gmail.com?subject=" 
    			                + encodeURIComponent("LR - Client " + cid) 
    			                + "&body="
    			                + encodeURIComponent(msg));
            }
        });
	}*/
	
	function calculatePriority(arr) {
		if(!arr || arr.length < 1) {
			return 21; // never been contacted
		}

		switch(Number(arr.shift())) {
			case 97 : // assistance not required
				return 97; // assistance not required
			break; 
			case 31 : // appointment scheduled 
				return 10; // upcoming appointment
			break; 
			case 12 : // Called, helped by phone
			case 16 : // Email, response sent
			case 20 : // Call received, helped by phone
			case 30 : // Met with client
				return 61; // Client Assisted
			break; 
			case 11 : // Called, no answer
				return 11; // Phone tag
			break; 
			case 13 : // Called, wrong number
			case 14 : // Called, number not in service
				return 90; // cannot contact
			break; 
			case 21 : // Voicemail received
			case 15 : // Email received
				return 21; // Never been contacted
			break; 
			case 92 : // referred to legal research
				return 52; // Case referred, LR
			break;
			case 1 : // Create client record	
				if(arr.length > 1)
					return calculatePriority(arr); // We don't care about when the record was created
				else
					return 21; // Never been contacted
			break; 
			case 10 : // message left
				switch (countLeftVM(arr) + 1) {
					case 0 : 
						return 0; // undefined
					break; 
					case 1 : 
						return 22; // 1 message left
					break;
					case 2 : 
						return 23; // 2 messages left
					break;
					default : 
						return 24; // 3+ messages left
					break;
				} 
			break; 
		}
	}
	
	function countLeftVM(arr) {
		if(arr.length < 1) 
			return 0; 
		else if(arr.shift() == 10) 
			return countLeftVM(arr) + 1; 
		else 
			return countLeftVM(arr); 
	}
		
</script>

<!-- MAIN SCRIPT FOR THIS PAGE HERE -->
<script>
	function display() {		
		state.newContactShown = false; 
		$("#PutContactsHere").html(""); 

		var htmlOutput = "<table class='table table-bordered table-hover'>" 
						+ "<thead>"
							+ "<tr>"
								+ "<th>Contact Date</th>"
								+ "<th>Type</th>"
								+ "<th>Summary</th>"
								+ "<th>Added by</th>"
							+ "</tr>"
						+ "</thead>"
						+ "<tbody>";	


		contacts.sort(function(a, b) {
			return b.ContactID - a.ContactID; 
		}); 

		for(n in contacts) {
			var html = contactDisplayHTML(contacts[n]); 
			htmlOutput += html;
		}


		if (contacts.length == 0)
		{
			htmlOutput += "<tr>"
							+ "<td><i>No contacts</i></td>"
							+ "<td></td>"
							+ "<td></td>"
							+ "<td></td>"
						+ "</tr>";
		}

		htmlOutput += "</tbody></table>";
	
		$("#PutContactsHere").append(htmlOutput);
	}
		
	$(document).ready(function() {
		display();  		
	}); 
</script>

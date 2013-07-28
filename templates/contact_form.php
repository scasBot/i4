<form id="contactForm" class="form-horizontal">
	<legend>Contact Info</legend>
</form>

<div class="row contact-form-header">
	<div class="span2">Contact Date</div>
	<div class="span2">Type</div>
	<div class="span6">Summary</div>
	<div class="span2">Added by</div>
</div>
<div class='row contact-form-new' onclick="newContact()" 
	data-title="Add New Contact" 
	data-content="<?php echo $random_quote ?>">Click here to add new contact</div>
<div id="PutContactsHere">
</div>
<br />
<br />
<script>
	// contacts as JSON from server
	var contacts = <?php echo json_encode($contacts) ?>; 

	// global variables needed to run
	var state = {
		newContactShown : false,  
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
			"<div id='Contact"+ id +"' class='row contact-form-row'"
					+ "onclick='showEdit("+id+")' >"  
				+ "<div class='span2 divContactDate'>"
					+ "<span id='Contact"+ id +"Date'>" 
						+ contact.ContactDate + "</span>" 
				+ "</div>"
				+ "<div class='span2 divContactType'>"
					+ "<span id='Contact"+ id + "Type'>" 
						+ contact.ContactType + "</span>"
				+ "</div>"
				+ "<div class='span6 contact-form-summary divContactSummary'>" 
					+ "<span id='Contact" +id+"Summary'>"
						+  contactSummary + "</span>" 
				+ "</div>"
				+ "<div class='span2'>"
					+ contact.UserName.Added
				+ "</div>"
			+ "</div><br />";
		
		return html; 
	}
	
	/* NOTE: you must manually select ContactType */
	function contactEditHTML(contact) {
		var isNew = (arguments.length < 1);
		
		var id = (isNew ? 0 : contact.ContactID); 
		var ContactDate = (isNew ? currentSqlDate() : contact.ContactDate); 
		var ContactSummary = (isNew ? "" : contact.ContactSummary); 
		var LastEdit = (isNew? "" : 
				"<div class='control-group'>"
					+"<label class='control-label'>Last Edit: </label>"
					+"<p style='text-align: center; padding-top: 5px' >" + contact.UserName.Edit + " on " + contact.ContactEditDate + "</p>"
				+ "</div>"); 			
				
		var html =  
		"<form id='EditContact" + id + "' class='contact-edit-form form-horizontal' hidden>" 
			+ "<div class='row contact-edit-row'>"
				+ "<div class='row'>" 
					+ "<div class='span6'>"
						+ "<div class='control-group'>"
							+ "<label class='control-label'>Date: </label>"
							+ "<div class='controls'>"
								+ "<input type='text' name='ContactDate' value='" + ContactDate + "' data-title='Invalid' />" 
							+ "</div>"
						+ "</div>"
						+ "<div class='control-group'>"
							+ "<label class='control-label'>Type: </label>"
							+ "<div class='controls'>"
								+ "<select name='ContactType' >"
									+ "<?php echo htmlOptions($contact_types) ?>"
								+ "</select>"
							+ "</div>"
						+ "</div>"
						+ LastEdit 
					+ "</div>"
					+ "<div class='span6'>"
						+ "<textarea class='field span5' rows='6' name='ContactSummary' style='font-size: 12px'>"+ContactSummary+"</textarea>"
					+ "</div>"
				+ "</div>"
				+ "<br />"
				+ "<div class='row'>"
					+ "<div class='span2'></div>"
					+ "<div class='span3'>"
						+ "<button type='button' id='contact-edit-row-update"+id+"' class='btn' onclick='updateContact("+id+")'>Save</button>"
					+ "</div>"
					+ "<div class='span2'>"
						+ "<button type='button' id='contact-edit-row-undo" +id+"' class='btn' onclick='undoContact("+id+")'>Undo</button>"
					+ "</div>"
					+ "<div class='span3'>"
						+ "<button type='button' id='contact-edit-row-delete" + id + "' class='btn' "
							+ (id == 0 ? "disabled" : "onclick='deleteContact("+id+")'")
							+ ">Delete</button>"
					+ "</div>"
					+ "<div class='span2'></div>"
				+ "</div>" 			
			+ "</div>"
		+ "</form>"; 		
		
		return html; 
	}

	function showEdit(id) {
		assert(id != 0); 	
		var contact = getContact(id); 
		
		$("#Contact" + id).after(contactEditHTML(contact)); 
		selectOption($("#EditContact" + id)
			.find("select[name='ContactType']"), contact.ContactType);
		$("#Contact" + id).hide(); 
		$("#EditContact" + id).show(); 
	}

	function myReset (id) {
		$("#EditContact" + id).find("[name='ContactDate']").popover('hide'); 
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
		if(!state.newContactShown) {
			$("#PutContactsHere").prepend(contactEditHTML()); 
			state.newContactShown = true; 
			$("#EditContact0").show(); 
		}
	}

	function deleteContact(id) {
		var shouldDelete = confirm("Are you sure you want to wipe " + 
			getContact(id).UserName.Added + "'s masterpiece?"); 
		
		if(!shouldDelete) {
			return; 
		}
		else {
			data = {}; 
			data.Action = "Delete"; 
			data.Contact = {}; 
			data.Contact.ContactID = id; 
			
			ajaxBot.sendAjax({
				REQ : "contact", 
				data : data, 
				success : function(r) {
					try {
						console.log(r); 
						var response = $.parseJSON(r); 
					}
					catch (e) {
						throw "Error : Server response invalid."; 
					}
					
					if(response.Success) {
						contacts.splice(getContactIndex(id), 1); 
						console.log("gone!"); 
						display(); 
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
			var editDiv = $("#EditContact" + id); 
			var index = getContactIndex(id); 
		
			var data = {}; 
			var newContact = {}; 
			newContact.UserName = {};
			newContact.Email = {}; 

			if(id ==0) {
				newContact.ContactID = 0; 
				newContact.UserName.Added = constants.userName; //"<?php echo $_SESSION["username"] ?>";
				newContact.Email.Added = constants.userEmail; 
				newContact.ClientID = constants.clientId; // EDITED 
			} else {
				newContact = contacts[index]; 
			}
			
			newContact.UserName.Edit = constants.userName; //"<?php echo $_SESSION["username"] ?>"; 
			newContact.Email.Edit = constants.userEmail; 
			newContact.ContactEditDate = currentSqlDate(); 
			newContact.ContactDate = editDiv.find("[name='ContactDate']").val(); 
			newContact.ContactTypeID = editDiv.find("[name='ContactType']").val(); 
			newContact.ContactSummary = editDiv.find("[name='ContactSummary']").val(); 

			data = {}; 
		
			data.ID = constants.userId;  
			data.Contact = newContact; 
			data.Action = (id == 0 ? "Insert" : "Update"); 
			
			ajaxBot.sendAjax({
				data : data, 
				REQ : "contact", 
				success : function(r) {
					try {
						console.log(r); 
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
		var dateInput = $("#EditContact" + id).find("[name='ContactDate']");		
		
		if(isValidDate(dateInput.val())) {
			var date_inputted = myDate(dateInput.val()); 
			dateInput.val(toSqlDate(date_inputted));
			return true; 
		}
		else {
			var msg = (isValidMysqlSyntax(dateInput.val()) ? 
					"the date you entered is invalid...please consult a calendar" : 
					"Format in the following way:  YYYY-MM-DD hh:mm:ss"); 					
			dateInput.popover({content : msg}); 
			dateInput.popover('show')
			dateInput.bind('click', function () {dateInput.popover('hide')}); 
			return false; 		
		}
	}	
	

</script>

<!-- MAIN SCRIPT FOR THIS PAGE HERE -->
<script>	
	function display() {
		state.newContactShown = false; 
	
		$("#PutContactsHere").html(""); 
		
		contacts.sort(function(a, b) {
			return (myDate(b.ContactDate)) - (myDate(a.ContactDate)); 
		}); 
		
		for(n in contacts) {
			var html = contactDisplayHTML(contacts[n]); 
			$("#PutContactsHere").append(html); 
		}
	}
	
	$(document).ready(function() {
		display();  		
	}); 
</script>
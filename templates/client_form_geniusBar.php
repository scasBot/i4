	<button class="btn btn-default actions" style="height: 50px;" data-action="emaili4">Email i4 Users</button>
    <!--<button class="btn btn-default actions" style="height: 50px; ;" data-action="emaili4">Email i4 Users</button> -->
    <button class="btn btn-primary actions" style="height: 50px;" data-action="emailLegalResearch">Email Legal Research</button>
    <!--<button class="btn btn-primary actions" style="height: 50px; ;" data-action="emailLegalResearch">Email Legal Research</button> -->
	<button class="btn btn-success actions" style="height: 100px;" data-action="emailClient"><i class="glyphicon glyphicon-envelope"></i> Email Client</button>
	<!-- button class="btn btn-inverse actions" data-action="email">Email Client</button -->
<script>
$(document).ready(function() {
	$(".actions").on("click", function() {
		actions[$(this).data("action")] (); 
	}); 	

	var actions = {
		<?php if(!COMPER) : ?>
			del : function() {
				if(confirm("Are you sure you want to delete this client and all data " + 
					"associated with them?")) {
					window.location = "client.php?DELETE&ClientID=" + constants.clientId; 
				}
			}, 
		merge : function() {
			window.location = "merge.php?Client1=" + constants.clientId; 
		}, 		
		<?php endif; ?>		
		<?php if(false) : ?>
		email : function() {
			var to = $("input[name='Email']").val(); 
			if(!isValidEmail(to)) {
				alert("This client's email is invalid."); 
				return; 
			} else {
				addEmailHandler(function(emailForm) {
					emailForm.to(to); 
					emailForm.from("masmallclaims@gmail.org"); 
					emailForm.inputFieldObj("to").prop("disabled", true); 
				}); 
			}
		},
		<?php endif; ?>
		emaili4 : function() {
			addEmailHandler(function(emailForm) {
				emailForm.from(constants.userEmail);

				function Emails(contacts) {
					var emails = []; 
					this.getEmails = function() {return emails;}; 
					this.addToEmails = addToEmails;
					function addToEmails(email) {
						var inArray = (emails.indexOf(email) > -1); 
						if(!inArray) {emails.push(email);}
					}
					for(n in contacts) {
						addToEmails(contacts[n].Email.Edit); 
						addToEmails(contacts[n].Email.Added); 
					}
				}
				
				emailForm.inputFieldObj("to").attr("autocomplete", "off"); 
				emailForm.inputFieldObj("to").attr("placeholder", "Start typing..."); 
				emailForm.inputFieldObj("to").typeahead({
					source : new Emails(contacts).getEmails(), 
				}); 
				emailForm.subject("SCAS Question: Client " + constants.clientId); 
				emailForm.inputFieldObj("to").focus();				
			}); 
		},
		emailLegalResearch : function() {
			addEmailHandler(function(emailForm) {
				emailForm.from(constants.userEmail); 
				emailForm.to("masmallclaims@gmail.com"); //constants.legalResearchEmail - old
				emailForm.inputFieldObj("to").prop("disabled", true); 
				emailForm.subject("SCAS Referral: Client " + constants.clientId); 
				emailForm.inputFieldObj("message").focus(); 
			}); 
		}, 
		emailClient : function() {
			addEmailHandler(function(emailForm) {
				emailForm.from("masmallclaims@gmail.com"); 
				emailForm.senderName("MA Small Claims");
				emailForm.to("<? echo $client['Email'] ?>"); 
				// emailForm.inputFieldObj("to").prop("disabled", true); 
				emailForm.subject(""); 
				emailForm.inputFieldObj("subject").focus();
			}); 
		}, 
	}

	var state = {
		emailShowing : null, 
	}

	function addEmailHandler(fun) {
		if(state.emailShowing) {
			state.emailShowing.remove(); 
		}

		var emailForm = addEmailForm(); 
		state.emailShowing = emailForm; 
		emailForm.onReset = function() {
			emailForm.getOnResetDefault()(); 
			fun(emailForm); 
		}
		fun(emailForm); 
		return; 
	}
	
	function addEmailForm() {

		var emailForm = emailBot.newEmailForm(); 
		$(".client-wrapper").after(
			emailForm.form()

		);

		// show modal
		$("#emailForm").modal('show');
		
		// disable hide when clicked outside modal
		$("#emailForm").modal({backdrop : 'static' });

		// set disclaimer html
		var disclaimer = "<br /><br /><b>--</b><br />" 
			+ "<b>The Small Claims Advisory Service</b><br />"
			+ "Phillips Brooks House, Harvard Yard, Cambridge, MA 02138<br />"
			+ "(617) 497-5690<br />"
			+ "<a href='http://www.masmallclaims.org'>http://www.masmallclaims.org</a><br /><br />"
			+ "<i><b>Disclaimer:</b>  Members of the Small Claims Advisory Service are <b><u>neither lawyers nor law students.</u></b>  We are volunteer undergraduates who have studied the small claims law in Massachusetts. The information included in this email is only information <b><u>and should not be considered legal advice,</u></b> which you can only receive from a lawyer.</i>"

		setTimeout(
			function() {
			tinymce.get('editor').setContent(disclaimer);
			}, 500
		);

		emailForm.onCancel = function() {
			// hide w/ form animation
			$("#emailForm").modal('hide');

			// after .5 seconds, remove email Form
			// allow time for form to animate/hide
			setTimeout(
				function() {
					emailForm.getOnCancelDefault()(); 
				
				}, 500 
			);
			state.emailShowing = false; 
		}

		emailForm.onSend = function() {
			// disable buttons
			$("#send").prop("disabled", true);
			$("#cancel").prop("disabled", true);

			$("#send").html("Sending");
			
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

			// transfer data from editor to message
			$("#message").val(tinymce.get('editor').getContent());

			var data = emailForm.getInputs(); 
			data.clientId = constants.clientId; 
	
			// store plaintext as well
			data.plaintext = tinymce.activeEditor.getContent({format : 'text'});
	
			ajaxBot.sendAjax({
				REQ : "emailForm", 
				data : emailForm.getInputs(), 
				success : function(r) {
					try {
						r = $.parseJSON(r); 					
						if(r.Success) {
							var id = emailForm.getId(); 
							setTimeout(function() {$("#emailSent" + id).remove()}, 5000);

							// if email sent to Client, add contacts
							if (data.from == "masmallclaims@gmail.com")
							{
								// log the plaintext version
								addEmailContact(data.subject, data.plaintext);	
							}		

							emailForm.onCancel(); 

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
		state.emailShowing = true;
		emailForm.inputFieldObj("from").prop("disabled", true);  		
		return emailForm; 
	}
});
	
function addEmailContact(subject, message) {
	
	var data = {}; 
	var newContact = {}; 
	newContact.UserName = {};
	newContact.Email = {}; 

	newContact.ContactID = 0; 
	newContact.UserName.Added = constants.userName;
	newContact.Email.Added = constants.userEmail; 
	newContact.ClientID = constants.clientId; 
	
	newContact.UserName.Edit = constants.userName; 
	newContact.Email.Edit = constants.userEmail; 
	newContact.ContactEditDate = currentSqlDate(); 
	newContact.ContactDate = currentSqlDate();
	newContact.ContactTypeID = 16; // 16 is "Email, Response Sent" 
	newContact.ContactSummary = message; 

	data = {}; 

	data.ID = constants.userId;  
	data.Contact = newContact; 
	data.Action = "Insert"; 
	
	ajaxBot.sendAjax({
		data : data, 
		REQ : "contact", 
		success : function(r) {
			try {
				var response = $.parseJSON(r); 
			}
			catch (e) {
				throw "Error: server response invalid."; 
			}

			if(response.Success) {
				newContact.ContactType = response.data.ContactType; 

				newContact.ContactID = response.data.ContactID; 
				contacts.push(newContact); 
				
				display();	
				updatePriority();
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
</script>

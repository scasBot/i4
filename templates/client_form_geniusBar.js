$(document).ready(function() {
	$(".actions").on("click", function() {
		actions[$(this).data("action")] (); 
	}); 	

	var actions = {
		del : function() {
			if(confirm("Are you sure you want to delete this client and all data " + 
				"associated with them?")) {
				window.location = "client.php?DELETE&ClientID=" + constants.clientId; 
			}
		}, 
		merge : function() {
			window.location = "merge.php?Client1=" + constants.clientId; 
		}, 		
		email : function() {
			var to = $("input[name='Email']").val(); 
			if(!isValidEmail(to)) {
				alert("Client email is invalid."); 
				return; 
			} else {
				addEmailHandler(function(emailForm) {
					emailForm.to(to); 
					emailForm.from("masmallclaims@gmail.org"); 
					emailForm.inputFieldObj("to").prop("disabled", true); 
				}); 
			}
		}, 
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
				emailForm.to(constants.legalResearchEmail); 
				emailForm.inputFieldObj("to").prop("disabled", true); 
				emailForm.subject("SCAS Referral: Client " + constants.clientId); 
				emailForm.inputFieldObj("message").focus(); 
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
		$("#clientActions").after(
			"<div class='row'>" + 
				"<div class='span2'></div>" + 
					emailForm.form() +
				"<div class='span2'></div>" + 
			"</div>"
		);
		emailForm.onCancel = function() {
			emailForm.getOnCancelDefault()(); 
			state.emailShowing = false; 
		}
		emailForm.onSend = function() {
			var data = emailForm.getInputs(); 
			data.clientId = constants.clientId; 
		
			ajaxBot.sendAjax({
				REQ : "emailForm", 
				data : emailForm.getInputs(), 
				success : function(r) {
					try {
						r = $.parseJSON(r); 					
						if(r.Success) {
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
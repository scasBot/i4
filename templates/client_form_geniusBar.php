<div class="row">
	<div class="span12">
		<div id="geniusBar">
			<!-- p><?php echo byi4("Actions") ?></p-->
			<div class="row">
				<div class="span12">
					<?php if(!COMPER) : ?>
						<div class='btn-group'>
							<button class="btn btn-danger actions" data-action="del">Delete Client</button>
						</div>
					<?php endif; ?>
					<div class="btn-group">
						<button class="btn btn-primary actions" data-action="merge">Merge Client</button>
						<button class="btn btn-inverse actions" data-action="email">Email Client</button>
					</div>
					<div class="btn-group">
						<button class="btn btn-warning actions"  data-action="grabEmails">Grab Email</button>
					</div>
					<div class="btn-group">
						<button class="btn btn-success actions" data-action="emaili4">Email i4 Users</button>
						<button class="btn btn-info actions" data-action="emailLegalResearch">Email LegalResearch</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
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
		<?php endif; ?>
		merge : function() {
			window.location = "merge.php?Client1=" + constants.clientId; 
		}, 		
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
		grabEmails : function() {
			function showClientEmails(emails) {
				if(state.emailShowing) {
					state.emailShowing.remove();
				} else if (state.clientEmailShowing) {
					state.clientEmailShowing.remove(); 
				}
				
				$("#grabEmails").empty(); 
				$("#grabEmails").append("<div class='row geniusBar-clientEmailHeader'><div class='span2'>Email</div>" + 
					"<div class='span2'>Name</div><div class='span2'>Subject</div><div class='span5'>Message</div></div>"); 
				for(n in emails) {
					$("#grabEmails").append(showClientEmail(emails[n])); 
				}
				$("#grabEmails").append("<div class='btn-group' style='margin-top: 4px'><button class='btn clientEmails' data-action='add'>Add</button>" + 
					"<button class='btn clientEmails' data-action='delete'>Delete</button><button class='btn clientEmails' data-action='cancel'>Cancel</button>" + 
					"</div>"); 
				$("#grabEmails").show(); 
				
				function toggle(obj) {
					if(obj.data("on") == "true") {
						obj.css("background-color", ""); 
						obj.data("on", "false"); 
					} else {
						obj.css("background-color", "#CCCCFF"); 
						obj.data("on", "true"); 
					}
				}
				$(".geniusBar-clientEmail").on("click", function() {
					toggle($(this)); 
				}); 
				
				$("button.clientEmails").on("click", function() {
					switch ($(this).data("action")) {
						case "add" : 
							allclientEmails(function(obj) {
								$(".contact-form-new").click(); 
								selectOption($("#EditContact0").find("[name='ContactType']"), "Email Received");
								var date = new Date(Number(obj.data("date")) * 1000); 
								$("#EditContact0").find("[name='ContactDate']").val(toSqlDate(date)); 
								$("#EditContact0").find("[name='ContactSummary']").text(obj.data("message")); 
							}); 
						break; 
						case "delete" :
							allclientEmails(function(obj) {
								ajaxBot.sendAjax({REQ : "clientEmails", 
									data : {action : "UPDATE", date : obj.data("date")}, 
									success : function(r) {
										$("button.clientEmails[data-action='cancel']").click(); 
									}}); 
							}); 
						break; 
						case "cancel" : 
							state.clientEmailShowing.remove(); 
						break; 
					}
				}); 
				
				function allclientEmails(fun) {
					$(".geniusBar-clientEmail").each(function() {
						if($(this).data("on") == "true") fun($(this)); 
					}); 
				}
				
				this.remove = function() {
					$("#grabEmails").empty(); 
					$("#grabEmails").hide(); 
				}
			}
			
			function showClientEmail(email) {
				return "<div data-date='" + email.date + "' data-subject='" + email.subject + "'" +
					"data-message='" + email.message + "' data-on='false' class='row geniusBar-clientEmail'>" + 
					"<div class='span2'><p>" + 
						email.email + 
					"</p></div>" + 
					"<div class='span2'><p>" + 
						email.name + 
					"</p></div>" + 
					"<div class='span2'><p>" + 
						email.subject +
					"</p></div>" + 
					"<div class='span5'><p>" + 
						email.message + 
					"</p></div>" + 
				"</div>"
			}

			ajaxBot.sendAjax({REQ: "clientEmails", 
				data : {action : "GET"}, 
				success : function(r) {
					state.clientEmailShowing = new showClientEmails($.parseJSON(r)); 
				}
			}); 
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
		clientEmailShowing : null, 
	}
	$("#geniusBar").after("<div class='row'><div class='span12' id='grabEmails'></div></div>"); 
	$("#grabEmails").hide(); 

	function addEmailHandler(fun) {
		if(state.emailShowing) {
			state.emailShowing.remove(); 
		} else if(state.clientEmailShowing) {
			state.clientEmailShowing.remove(); 
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
		$("#geniusBar").after(
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
</script>
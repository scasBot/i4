var emailBot = new EmailBot();
function EmailBot () {
	var id = 0; 
	var ids = []; 	
	this.getIds = function() {
		return ids.slice(0); 
	}	
	
	var onClickHelper = function(id, fun) {
		fun(ids[id]); 
	}
	this.onCancel = function(id) {
		onClickHelper(id, function(emailForm) {
			emailForm.onCancel(); 
		}); 
	}
	this.onReset = function(id) {
		onClickHelper(id, function(emailForm) {
			emailForm.onReset(); 
		}); 
	}
	this.onSend = function(id) {
		onClickHelper(id, function(emailForm) {
			emailForm.onSend(); 
		}); 
	}
	
	this.remove = function(id) {
		ids.splice(id, 1);			
	}
	
	this.newEmailForm = function() {
		var thisId = id++; 
		var emailForm = new EmailForm(thisId, this); 
		ids[thisId] = emailForm; 
		return emailForm; 
	}
}
// EmailForm is the class that creates an email form. Before using most functions, you must make a call to 
// EmailForm.form() and then put that html into the dom. 
function EmailForm(id, emailBot) {
	this.getId = function() {return id;}
	
	this.form = function() {
		var html = 
		"<form id='emailForm" + id + "' class='form-horizontal email-form span8'>" +
			"<div class='control-group'>" +
				"<label class='control-label' for='to'>To: </label>" +
				"<div class='controls'>" + 
					"<input name='to' type='email' />" + 
				"</div>" + 
			"</div>" +
			"<div class='control-group'>" + 
				"<label class='control-label' for='from'>From: </label>" + 
				"<div class='controls'>" + 
					"<input name='from' type='email' />" + 
				"</div>" + 
			"</div>" + 
			"<div class='control-group'>" + 
				"<label class='control-label' for='subject'>Subject: </label>" + 
				"<div class='controls'>" + 
					"<input name='subject' type='text' />" + 
				"</div>" + 
			"</div>" + 
			"<div class='control-group'>" + 
				"<label class='control-label' for='message'>Message: </label>" + 
				"<div class='controls'>" + 
					"<textarea name='message' rows='5' cols='5' style='font-size: 12px'></textarea>" + 
				"</div>" + 
			"</div>" + 
			"<div class='btn-group'>" + 
				"<button class='btn email-btn' data-action='send' type='button' data-id='" + id + "'" + 
					"onclick='emailBot.onSend(" + id + ");' >Send Email</button>" + 
				"<button class='btn email-btn' data-action='reset' type='button' data-id='" + id + "'" + 
					"onclick='emailBot.onReset(" + id + ");' >Reset</button>" + 
				"<button class='btn email-btn' data-action='cancel' type='button' data-id='" + id + "'" + 
					"onclick='emailBot.onCancel(" + id + ");' >Cancel</button>" + 
			"</div>" + 
		"</form>"; 
		return html;
	}

	this.formObj = function() {
		return $("#emailForm" + id);		
	} 
	var formObj = this.formObj; 
	
	this.inputFieldObj = function(fieldName) {
		return formObj().find("[name='" + fieldName + "']"); 
	} 
	var inputFieldObj = this.inputFieldObj; 

	this.remove = function() {
		formObj().remove(); 
		emailBot.remove(id); 
	} 
	var remove = this.remove; 

	var onCancelDefault = function() {remove();}
	var onResetDefault = function() {formObj()[0].reset(); }
	var onSendDefault = function() {formObj().submit(); }
	this.getOnCancelDefault = function() {return onCancelDefault;}
	this.getOnResetDefault = function() {return onResetDefault; }
	this.getOnSendDefault = function() {return onSendDefault;}
	this.onCancel = onCancelDefault;
	this.onReset = onResetDefault
	this.onSend = onSendDefault; 
	
	var inputHelper = function(field, val) {
		if(val == null) {
			return inputFieldObj(field).val();
		} else {
			inputFieldObj(field).val(val); 
			return true; 
		}
	}	
	this.to = function(val) {return inputHelper("to", val);}
	this.from = function(val) {return inputHelper("from", val);}
	this.subject = function(val) {return inputHelper("subject", val); }
	this.message = function(val) {return inputHelper("message", val); }

	this.getInputs = function() {
		return {
			to : this.to(),
			from : this.from(), 
			subject : this.subject(), 
			message : this.message(), 
		}
	}
}
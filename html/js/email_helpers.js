// email validator - http://www.w3resource.com/javascript/form/email-validation.php#sthash.YaiMT7Vz.dpuf
function isValidEmail(email) {  
	return (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)); 
}

// email object
var email = {}; 

// first id is zero, will change later
email.id = 0; 

// array to hold all currently displaying email forms
email.ids = [];

// because javascript copies arrays by reference, to get the email ids, we should always use this function: 
email.getIds = function() {
	return email.ids.slice(0); 
}

// this is the html of the id form that can be added
email.form = function() {
	var html = 
	"<form id='emailForm" + email.id + "' class='form-horizontal email-form span8'>" +
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
			"<button class='btn email-btn' data-action='send' type='button' data-id='" + email.id + "'" + 
				"onclick='email.onSend(" + email.id + ");' >Send Email</button>" + 
			"<button class='btn email-btn' data-action='reset' type='button' data-id='" + email.id + "'" + 
				"onclick='email.onReset(" + email.id + ");' >Reset</button>" + 
			"<button class='btn email-btn' data-action='cancel' type='button' data-id='" + email.id + "'" + 
				"onclick='email.onCancel(" + email.id + ");' >Cancel</button>" + 
		"</div>" + 
	"</form>"; 

	email.ids[email.ids.length] = email.id; 
	email.id++; 
	
	return html; 
}

email.remove = function(id) {
	email.formObj(id).remove(); 
	email.ids.splice(email.ids.indexOf(id), 1); 
}

email.onCancelDefault = function(id) {
	email.remove(id);
}

email.onResetDefault = function(id) {
	email.formObj(id)[0].reset(); 
}

email.onSendDefault = function(id) {
	email.formObj(id).submit(); 
}


email.onCancel = function(id) {
	email.onCancelDefault(id); 
};

email.onSend = function() {
	email.onSendDefault(id); 
}; 

email.onReset = function(id) {
	email.onResetDefault(id); 
}

email.formObj = function(id) {
	id = id || 0; 
	return $("#emailForm" + id); 
}

email.inputFieldObj = function(fieldName, id) {
	id = id || 0; 
	return email.formObj(id).find("[name='" + fieldName + "']"); 
}

email.inputHelper = function(field, val, id) {
	id = id || 0; 

	if(val == null) {
		return email.inputFieldObj(field, id).val();
	} else {
		email.inputFieldObj(field, id).val(val); 
		return true; 
	}
}

email.to = function(val, id) {
	return email.inputHelper("to", val, id); 
}

email.from = function(val, id) {
	return email.inputHelper("from", val, id); 
}

email.subject = function(val, id) {
	return email.inputHelper("subject", val, id); 
}

email.message = function(val, id) {
	return email.inputHelper("message", val, id); 
}

email.getInputs = function(id) {
	return {
		to: email.to(null, id), 
		from: email.from(null, id), 
		subject: email.subject(null, id), 
		message: email.message(null, id), 
	}
}
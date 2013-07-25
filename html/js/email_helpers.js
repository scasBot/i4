// email validator - http://www.w3resource.com/javascript/form/email-validation.php#sthash.YaiMT7Vz.dpuf
function isValidEmail(email) {  
	return (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)); 
}

var email = {}; 

email.id = 0; 

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
				"<textarea name='message' rows='5' cols='5'></textarea>" + 
			"</div>" + 
		"</div>" + 
		"<div class='btn-group'>" + 
			"<button class='btn email-btn' data-action='send' type='button' data-id='" + email.id + "'>Send Email</button>" + 
			"<button class='btn email-btn' data-action='reset' type='reset' data-id='" + email.id + "'>Reset</button>" + 
			"<button class='btn email-btn' data-action='cancel' type='button' data-id='" + email.id + "' style='font-size: 12px'" + 
				"onclick='$(\"#emailForm" + email.id + "\").remove()' >Cancel</button>" + 
		"</div>" + 
	"</form>"; 

	email.id++; 
	
	return html; 
}

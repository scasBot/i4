var emailBot = (function () {
	var Module = {}; 

	var id = 0; 
	var ids = []; 	
	Module.getIds = function() {
		return ids.slice(0); 
	}	
	
	var onClickHelper = function(id, fun) {
		fun(ids[id]); 
	}
	Module.onCancel = function(id) {
		onClickHelper(id, function(emailForm) {
			emailForm.onCancel(); 
		}); 
	}
	Module.onReset = function(id) {
		onClickHelper(id, function(emailForm) {
			emailForm.onReset(); 
		}); 
	}
	Module.onSend = function(id) {
		onClickHelper(id, function(emailForm) {
			emailForm.onSend(); 
		}); 
	}
	
	Module.remove = function(id) {
		ids.splice(id, 1);			
	}
	
	Module.newEmailForm = function() {
		var thisId = id++; 
		var emailForm = new EmailForm(thisId, this); 
		ids[thisId] = emailForm; 
		return emailForm; 
	}
	
	return Module; 
})(); 

// EmailForm is the class that creates an email form. Before using most functions, you must make a call to 
// EmailForm.form() and then put that html into the dom. 
function EmailForm(id, emailBot) {
	this.getId = function() {return id;}

	// a modal view	
	this.form = function() {
		var html = 
		"<div class='modal fade' id='emailForm' tabindex='-1' role='dialog' aria-labelledby='emailFormLabel' aria-hidden='true'>" +
		"<div class='modal-dialog'>" +
			"<div class='modal-content'>" +
				"<form id='emailForm" + id + "' class='form-horizontal'>" +
				"<div class='modal-header' style='text-align: left'>" +
					"<button type='button' class='close' data-dismiss='modal' aria-hidden='true' onclick='emailBot.onCancel(" + id + ");'>&times;</button>" +
					"<div class='row'>" +
						"<div class='control-group'>" +
							"<div class='col-sm-2' style='text-align: right'>" +
								"<label class='control-label' for='to'>To </label>" +
							"</div>" +
							"<div class='col-sm-9'>" +
								"<input type='email' name='to' class='form-control' style='border: 0'>" +
							"</div>" +
						"</div>" +
					"</div>" +
					"<div class='row'>" +
						"<div class='control-group'>" +
							"<div class='col-sm-2' style='text-align: right'>" +
								"<label class='control-label' for='from'>From </label>" +
							"</div>" +
							"<div class='col-sm-9'>" +
								"<input type='email' name='from' class='form-control' style='border: 0'>" +
							"</div>" +
						"</div>" +
					"</div>" +
					"<div class='row'>" +
						"<div class='control-group'>" +
							"<div class='col-sm-2' style='text-align: right'>" +
								"<label class='control-label' for='subject'>Subject </label>" +
							"</div>" +
							"<div class='col-sm-9'>" +
								"<input type='text' name='subject' class='form-control' style='border: 0' placeholder='Subject goes here...'>" +
							"</div>" +
						"</div>" +
					"</div>" +
				"</div>" +
				"<div class='modal-body'>" + 
						"<textarea name='editor' class='mceEditor' rows='6' style='width: 100%; height: 100%; font-size: 13px; border: 0;' placeholder='Type message here...'></textarea>" + 

				"</div>" +
				"<div class='modal-footer'>" +
						"<div id='progressBar'></div>" +
						"<button class='btn btn-primary' id='send' data-action='send' type='button' data-id='" + id + "'" + 
							"onclick='emailBot.onSend(" + id + ");' ><span class='glyphicon glyphicon-send'/> Send</button>" + 
						"<button class='btn btn-danger' id='cancel' data-dismiss='modal' data-action='cancel' type='button' aria-hidden='true' onclick='emailBot.onCancel(" + id + ");' data-id='" + id + "'>Cancel</button>" + 
				"</div>" + 
				"<input type='hidden' name='senderName' value='' />" +
				"<input type='hidden' id='message' name='message' value='' />" +
			"</form>" +
		"</div>" + // content
		"</div>" + // dialog
		"</div>" +  // modal
		"<script type='text/javascript'>" +
			"tinymce.init({" +
				"mode: 'specific_textareas'," +
				"editor_selector: 'mceEditor'," +
				"plugins: [" +
					"'advlist autolink lists link image charmap print preview anchor'," +
					"'searchreplace visualblocks code fullscreen'," +
					"'insertdatetime media table contextmenu paste'" +
				"]," +
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
				"}" +
			"});" +
		"</script>";

		return html;
	}

	this.formObj = function() {
		return $("#emailForm");		
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
	this.senderName = function(val) {return inputHelper("senderName", val); }
	this.from = function(val) {return inputHelper("from", val);}
	this.subject = function(val) {return inputHelper("subject", val); }
	this.message = function(val) {return inputHelper("message", val); }

	this.getInputs = function() {
		return {
			to : this.to(),
			senderName : this.senderName(),
			from : this.from(), 
			subject : this.subject(), 
			message : this.message(), 
		}
	}
}

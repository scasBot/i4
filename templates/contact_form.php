<form id="contactForm" class="form-horizontal">
	<legend>Contact Info</legend>
</form>
	<div class="row contact-form-header">
		<div class="span2">Contact Date</div>
		<div class="span2">Type</div>
		<div class="span6">Summary</div>
		<div class="span2">Added by</div>
	</div>
	<?php
		function contact_form_edit_html ($contact = NULL) {
			global $contact_types; 
			
			$id = ($contact ? $contact["ContactID"] : 0); 
			
			return 
				"
				<form id='EditContact".$id."' class='contact-edit-form form-horizontal' hidden>
					<div class='row contact-edit-row'>
						<div class='row'>
							<div class='span6'>
								<div class='control-group'>
									<label class='control-label'>Date: </label>
									<div class='controls'>
										<input type='text' name='ContactDate' data-title='Invalid' />
									</div>
								</div>
								<div class='control-group'>
									<label class='control-label'>Type: </label>
									<div class='controls'>
										<select name='ContactType' >
											". htmlOptions($contact_types) ."
										</select>
									</div>
								</div>
							</div>
							<div class='span6'>
								<textarea class='field span5' rows='6' name='ContactSummary'></textarea>
							</div>
						</div>
						<br />
						<div class='row'>
							<div class='span2'></div>
							<div class='span3'>
								<button type='button' id='contact-edit-row-update". $id ."' class='btn' onclick='updateContact(".$id.")'>Save</button>
							</div>
							<div class='span2'>
								<button type='button' id='contact-edit-row-undo" .$id ."' class='btn' onclick='undoContact(".$id.")'>Undo</button>
							</div>
							<div class='span3'>
								<button type='button' id='contact-edit-row-delete". $id ."' class='btn' ".
									($contact ? "onclick='deleteContact(".$id.")'" : "disabled").
									">Delete</button>
							</div>
							<div class='span2'></div>
						</div> 			
					</div>
				</form>
				";  
		}
	?>
	<div class='row contact-form-new' onclick="newContact()" data-title="Add New Contact" data-content="<?php echo random_quote()?>">Add New</div>
	<?php echo contact_form_edit_html() ?>
	<?php
		foreach($contacts as $contact) {
			echo 
			"<div id='Contact".$contact['ContactID']."' class='row contact-form-row' 
					onclick='showEdit(".$contact['ContactID'].")' 
					data-title='Last Edit' 
					data-content='". $contact["UserName"]["Edit"] 
					." on " .$contact["ContactEditDate"] ."'> 
				<div class='span2 divContactDate'>
					<span id='Contact".$contact['ContactID']."Date'>"
						.$contact['ContactDate']."</span>
				</div>
				<div class='span2 divContactType'>
					<span id='Contact".$contact['ContactID']."Type'>"
						.$contact['ContactType'] ."</span>
				</div>
				<div class='span6 contact-form-summary divContactSummary'>
					<span id='Contact".$contact['ContactID']."Summary'>"
						. $contact['ContactSummary'] ."</span>
				</div>
				<div class='span2'>
					". $contact["UserName"]["Added"] ."
				</div>
			</div><br />" . contact_form_edit_html($contact); 
		}

	?>
<script>	
	/* LAST EDITED POPOVER */
	// for last edit popovers
	$(function() {
		$(".contact-form-row").popover({trigger: 'hover'}); 
	}); 
	
	$(function() {
		$(".contact-form-new").popover({trigger: 'hover'}); 
	}); 
	
</script>

<script>
	/* EDIT ROW */
	$(".contact-edit-form").hide(); 
	
	function showEdit(id) {
		$("#Contact" + id).hide(); 
		populateEdit(id); 
		$("#EditContact" + id).show(); 
	}

	function populateEdit(id) {
		var editField = $("#EditContact" + id); 
		var displayField = $("#Contact" + id); 

		var contactType = $("#Contact" + id + "Type").text();
		selectOption(editField.find("select[name='ContactType']"), contactType); 
		
		var contactSummary = $("#Contact" + id + "Summary").text(); 
		editField.find("textarea[name='ContactSummary']").html(contactSummary); 
		
		var contactDate = $("#Contact" + id + "Date").text(); 
		editField.find("input[name='ContactDate']").val(contactDate); 
	}
	
	function myReset (id) {
		$("#EditContact" + id).find("[name='ContactDate']").popover('hide'); 
	}

	function undoContact (id) {
		document.getElementById("EditContact" + id).reset(); 
		myReset(id); 
		$("#EditContact" + id).hide(); 		
		
		if(id != 0) {
			$("#Contact" + id).show(); 
		}
	}

	function newContact() {
		$("#EditContact0").show();
		var now = currentSqlDate(); 
		$("#EditContact0").find("input[name='ContactDate']").val(now); 
	}

	function updateContact(id) {
		if(checkDateInput(id)) {
			var editDiv = $("#EditContact" + id); 
		
			var data = {}; 
			data.REQ = "contact"; 
			data.ContactID = id; 
			data.UserEditID = <?php echo $_SESSION["id"] ?>; 
			data.ContactEditDate = currentSqlDate(); 
			data.ContactDate = editDiv.find("[name='ContactDate']").val(); 
			data.ContactTypeID = editDiv.find("[name='ContactType']").val(); 
			data.ContactSummary = editDiv.find("[name='ContactSummary']").val(); 
		
			displayContactType = editDiv.find("[name='ContactType']")
				.find("[value='" + data.ContactTypeID + "']").text(); 
			
			$.ajax({
				url : "ajax.php",
				type: "POST",
				data : data,
				success : function(r) {
					try {
						var response = $.parseJSON(r); 
					}
					catch (e) {
						throw "Error: server repsonse invalid."; 
					}
					
					if(response.Success) {
						$("#Contact" + id).attr('data-content', "<?php echo $_SESSION["username"] ?> on " + data.ContactEditDate); 
						$("#Contact" + id + "Type").html(displayContactType); 
						$("#Contact" + id + "Summary").html(data.ContactSummary); 
						undoContact(id); 
					}
					else {
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
			var date_inputted = new Date(dateInput.val()); 
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
<br />
<br />
<?php
?>	
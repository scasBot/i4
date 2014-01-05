<?php
	function show_inbox($arr) {
		$i = 0;
		foreach($arr as $msg) {
			echo "<tr onclick='showMessage(" . $i . ");'><td id='timestamp'>" . $msg["timestamp"] . "</td><td id='sender'>" . $msg["sender"] . "</td><td id='subject'>" . $msg["subject"] . "</td></tr>"; 
			$i = $i + 1;
		}	
		// if empty, show it
		if (!isset($arr[0]))
		{
			echo "<tr id='empty'><td><i>Empty inbox</i></td><td></td><td></td></tr>";
		}
	}
?>
<div class="inbox-wrapper">
	<h1 align="center">Inbox</h1>
	<table class='table table-bordered table-hover' align="center">
	<thead>
		<tr>
			<th>Timestamp</th>
			<th>Sender</th>
			<th>Subject</th>
		</tr>
	</thead>
	<tbody>
		<?php show_inbox($mail) ?>
	</tbody>
	</table>
	<div id="modalHtml"></div>
</div>

<script>

	var mail_json = <? echo json_encode($mail) ?>;
	
	function showMessage(id) {
		var mail = mail_json[id];
		var html = modalHtml(mail);
		
		$("#modalHtml").html(html);
		$("#messageDiv").modal('show');
	}

	function hideMessage() {
		$("#messageDiv").modal('hide'); 

		// after .3 seconds, remove edit Form
		// allow time for form to animate/hide
		setTimeout(
			function() {
				$("#messageDiv").remove();		
			}, 500
		);

	}

	function assignMessage(id) {
		window.location = "assignEmail.php?id=" + id;
	}
	
	function modalHtml(mail) {
		var html = 
		"<div class='modal fade' id='messageDiv' tabindex='-1' role='dialog' aria-labelledby='messageViewLabel' aria-hidden='true'>" +
		"<div class='modal-dialog'>" +
			"<div class='modal-content'>" +
				"<div class='modal-header' style='text-align: left'>" +
					"<button type='button' class='close'  aria-hidden='true' onclick='hideMessage();'>&times;</button>" +
					"<div class='row'>" +
						"<div class='control-group'>" +
							"<div class='col-sm-2' style='text-align: right'>" +
								"<label class='control-label' for='timestamp'>Timestamp </label>" +
							"</div>" +
							"<div class='col-sm-9'>" +
								"<input type='text' name='timestamp' class='form-control' style='border: 0' value='" + mail.timestamp + "' disabled>" +
							"</div>" +
						"</div>" +
					"</div>" +
					"<div class='row'>" +
						"<div class='control-group'>" +
		"<div class='col-sm-2' style='text-align: right'>" +
								"<label class='control-label' for='sender'>Sender </label>" +
							"</div>" +
							"<div class='col-sm-9'>" +
								"<input type='text' name='sender' class='form-control' style='border: 0' value='" + mail.sender + "' disabled>" +
							"</div>" +
						"</div>" +
					"</div>" +
					"<div class='row'>" +
						"<div class='control-group'>" +
						"<div class='col-sm-2' style='text-align: right'>" +
								"<label class='control-label' for='subject'>Subject </label>" +
							"</div>" +
							"<div class='col-sm-9'>" +
								"<input type='text' name='subject' class='form-control' style='border: 0' value='" + mail.subject + "' disabled>" +
							"</div>" +
						"</div>" +
					"</div>" +
				"</div>" +
				"<div class='modal-body' style='text-align: left'>" + 
						 mail.message + 
				"</div>" +
				"<div class='modal-footer'>" +
						"<button class='btn btn-primary' id='assign' data-action='assign' id='cancel' type='button' aria-hidden='true' onclick='assignMessage(" + mail.id + ");'>Assign</button>" + 
						"<button class='btn btn-default' id='cancel' data-action='cancel' id='cancel' type='button' aria-hidden='true' onclick='hideMessage();'>Cancel</button>" + 
				"</div>" + 
		"</div>" + // content
		"</div>" + // dialog
		"</div>";  // modal
		
		return html;
	}

</script>

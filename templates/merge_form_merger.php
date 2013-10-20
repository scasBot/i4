<h3 style='border-bottom: 1px solid black' >Merged Client</h3>
<?php
	function printInfoField($title, $input) {
		echo "<div class='well' style='padding: 4px' >"; 
		echo "<p style='font-weight: bold'>$title: </p>"; 
		echo $input; 
		echo "</div>";
	}
	function printInfoField2($title, $input_type, $input_name) {
		printInfoField($title, 
			"<input id='" . $input_name . "' type='" 
			. $input_type . "' name='" . $input_name . "' class='merger-input' />"); 
	}
?>
<div class='row'>
	<div class='span4 mergeCenter'>
		<form id="merge_form_merger" method="post" action="merge.php">
			<input name="ClientID1" type="hidden" hidden />
			<input name="ClientID2" type="hidden" hidden />
			<?php 
				printInfoField2("First Name", "text", "FirstName"); 
				printInfoField2("Last Name", "text", "LastName"); 
				printInfoField2("Primary Phone", "tel", "Phone1Number");		
				printInfoField2("Secondary Phone", "tel", "Phone2Number");
				printInfoField2("Email", "email", "Email");
				printInfoField2("Address", "text", "Address");
				printInfoField2("City", "text", "City");
				printInfoField("State", 
					"<select id='State' name='State' class='merger-input'>" . htmlOptionsStates() . "</select>");
				printInfoField2("Zip", "text", "Zip");
				printInfoField2("Language", "text", "Language"); 	
				printInfoField("Notes",
					"<textarea id='ClientNotes' name='ClientNotes' class='merger-input'></textarea>"); 
			?>
		</form>
	</div>
</div>
<button class="btn" type="button" onclick="submitMerger()">Merge</button>
<script>
function submitMerger() {
	if(confirm("By merging the clients, the old clients will be deleted. Please confirm.")) {
		if(ClientID1 && ClientID2) {
			$("#merge_form_merger").find("input[name='ClientID1']").val(ClientID1); 
			$("#merge_form_merger").find("input[name='ClientID2']").val(ClientID2); 
			$("#merge_form_merger").submit(); 
		} else {
			alert("Error, must choose both clients."); 
		}
	}
}	
</script>
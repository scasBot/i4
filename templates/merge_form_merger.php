<h3 style='border-bottom: 1px solid black' >Merged Client</h3>
<?php
function printBtnGroup() {
	echo "<div class='btn-group'>"; 
	echo "<button class='btn btn-small btn-primary adopt-left'>Adopt Left</button>"; 
	echo "<button class='btn btn-small btn-success adopt-right'>Adopt Right</button>"; 
	echo "</div>"; 
}

function printInfoField($title, $input) {
	echo "<div class='well' style='padding: 4px' >"; 
	echo "<p style='font-weight: bold'>$title: </p>"; 
	echo $input; 
	echo "</div>";
}

function printInfoField2($title, $input_type, $input_name) {
	printInfoField($title, "<input id='" . $input_name . "' type='" . $input_type . "' name='" . $input_name . "' />"); 
}
?>

<div class='row'>
	<div class='span4 mergeCenter'>
		<?php 
			printInfoField2("First Name", "text", "FirstName"); 
			printInfoField2("Last Name", "text", "LastName"); 
			printInfoField2("Primary Phone", "tel", "Phone1Number");		
			printInfoField2("Secondary Phone", "tel", "Phone2Number");
			printInfoField2("Email", "email", "Email");
			printInfoField2("Address", "text", "Address");
			printInfoField2("City", "text", "City");
			printInfoField2("State", "text", "State"); // need to change to dropdown
			printInfoField2("Zip", "text", "Zip");
			printInfoField2("Language", "text", "Language"); 	
			printInfoField2("Notes", "text", "ClientNotes"); // need to change to textarea
		?>
	</div>
</div>
<style>

</style>
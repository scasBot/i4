<h1>Merged Client</h1>
<?php
    $info_field = array(
        array("First Name", "text", "FirstName"),
        array("Last Name", "text", "LastName"),
        array("Primary Phone", "tel", "Phone1Number"),		
        array("Secondary Phone", "tel", "Phone2Number"),
        array("Email", "email", "Email"),
        array("Address", "text", "Address"),
        array("City", "text", "City"),
        array("State", 
            "<select id='State' name='State' class='merger-input'>" . htmlOptionsStates() . "</select>"),
        array("Zip", "text", "Zip"),
        array("Language", "text", "Language"), 	
        array("Notes",
            "<textarea id='ClientNotes' name='ClientNotes' class='merger-input'></textarea>"),     
    ); 
    
    function isLevelTwo($arr) {
        return isset($arr[2]); 
    }
?>
<form id="merge_form_merger" method="post" action="merge.php">
	<input name="ClientID1" type="hidden" hidden />
	<input name="ClientID2" type="hidden" hidden />
	<table class="table table-bordered">
		<tbody>
			<?php foreach($info_field as $field) : ?>
					<tr>
						<td><?php echo $field[0] ?></td>
						<td>
						<?php if(isLevelTwo($field)): ?>
							<input id="<?php echo $field[2] ?>" type="<?php echo $field[1] ?>" 
								name="<?php echo $field[2] ?>" class='form-control merger-input' />
						<?php else : ?>
							<?php echo $field[1] ?>
						<?php endif; ?>  
						</td>
					</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</form>
<button class="btn btn-primary" style="margin-bottom: 20px" onclick="submitMerger()">Merge</button>
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

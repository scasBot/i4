<div class="row">
	<div class="span12">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th/>
					<th>Name</th>
					<th>Phone Number</th>
					<th>Email</th>
					<th>Priority</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach($cases as $case) {
						echo "<tr name='client' id='" . $case["ClientID"] . "' style='cursor : pointer'>"; 
						echo "<td/>"; 
						echo "<td>" . $case["LastName"]. ", " . $case["FirstName"] . "</td>"; 
						echo "<td>(" . $case["Phone1AreaCode"] . ") ". $case["Phone1Number"] . "</td>"; 
						echo "<td>" . $case["Email"] . "</td>";
						echo "<td>" . $case["Priority"] . "</td>"; 
						echo "</tr>"; 
					}
					
					if(!empty($addnew)) {
						echo "<tr name='newclient' style='cursor : pointer'>"; 
						echo "<td><b>Add New: </b></td>"; 
						echo "<td id='NewName'>" . $addnew["LastName"] . ", " . $addnew["FirstName"] . "</td>";
						echo "<td id='NewPhoneNumber'>" . $addnew["PhoneNumber"] . "</td>"; 
						echo "<td id='NewEmail' >" . $addnew["Email"] . "</td>"; 
						echo "</tr>"; 
					}
				?>
			</tbody>
		</table>
		<form id='javascript-form' method='post' style='display: none'>
		</form>
	</div>
</div>
<script>
	// for the clients now
	$("tr[name='client']").click(function () {		
		window.location.href = "client.php?ClientID=" + $(this).attr('id')
	}); 
	
	// for adding a new client
	$("tr[name='newclient']").click(function () {
		$("#javascript-form").attr("action", "newclient.php"); 
		
		var lastName = "<input type='hidden' name='LastName' value='<?php echo $addnew["LastName"] ?>' />"; 
		var firstName = "<input type='hidden' name='FirstName' value='<?php echo $addnew["FirstName"] ?>' />"; 
		var phoneNumber = "<input type='hidden' name='Phone1Number' value='<?php echo $addnew["PhoneNumber"] ?>' />"; 
		var email = "<input type='hidden' name='Email' value='<?php echo $addnew["Email"] ?>' />"; 
		
		$("#javascript-form").append(lastName + firstName + phoneNumber + email); 
		$("#javascript-form").submit(); 
	}); 
</script>
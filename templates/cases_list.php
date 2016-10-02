<?php if(empty($cases) && empty($addnew)) : ?>
	<a href="http://thecatapi.com"><img src="http://thecatapi.com/api/images/get?format=src&type=gif"></a>
<?php else : ?>
<div id="find">
	<section class="top">
		<form class="form-inline" style="padding-left: 10px">
			<input id="instantSearch" 
				style="width: 40%" 
				class="form-control" 
				type="text" 
				placeholder="<?php echo "  " . byi4("Instant Search") ?>" />
		</form>
	</section>
			<script>
				$(document).ready(function() {
					$("#instantSearch").focus(); 
				}); 

				function instantHandler() {
					if ($(this).val() == "") {
						$("tr[name='client']").each(function() {
							$(this).show(); 
						}); 
					} else {
						showRows($(this).val()); 
					}
				}
				
				function showRows(val) {
					$("tr[name='client']").each(function() {
						if($(this).html().toUpperCase().indexOf(val.toUpperCase()) > -1) {
							$(this).show(); 
						} else {
							$(this).hide(); 
						}
					}); 
				}
				
				$("#instantSearch").on("keydown", instantHandler); 
				$("#instantSearch").on("keyup", instantHandler);
				$("#instantSearch").on("click", instantHandler); 		
			</script>
	<section class="bottom" style="margin-top: 0">
		<div class="row">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Name</th>
						<th>Phone Number</th>
						<th>Email</th>
						<th>Priority</th>
						<th>Language</th>
					</tr>
				</thead>
				<tbody>		
					<?php foreach($cases as $case) : ?>
						<tr name='client' id='<?php echo $case["ClientID"] ?>' style='cursor : pointer'> 
						<td><?php echo $case["LastName"] . ", " . $case["FirstName"] ?>
							<?php if ($case["ContactTypeID"] == 15 && $case["CaseTypeID"] != 61) echo "&nbsp<span class='label label-primary'>New Email</span>"?>
							<?php if ($case["ContactTypeID"] == 21 && $case["CaseTypeID"] != 61
								&& $case["CaseTypeID"] != 11 && $case["CaseTypeID"] != 22) echo "&nbsp<span class='label label-info'>New Voicemail</span>"?>
						</td>
						<td><?php echo "(" . $case["Phone1AreaCode"] . ") ". $case["Phone1Number"] ?></td> 
						<td><?php echo $case["Email"] ?></td>
						<td><?php echo $case["Priority"] ?></td>
						<td><?php echo $case["Language"] ?></td>
						</tr> 					
					<?php endforeach; ?>
				</tbody>
			</table>
			<form id='javascript-form' method='post' style='display: none'>
			</form>
		</div>
	</section>
</div>
<script>
	// disable enter
	$("input").keypress(function (evt) {
		//Deterime where our character code is coming from within the event
		var charCode = evt.charCode || evt.keyCode;
		if (charCode  == 13) { //Enter key's keycode
			return false;
		}
	});

	// for the clients now
	$("tr[name='client']").click(function () {		
		window.location.href = "client.php?ClientID=" + $(this).attr('id')
	}); 

	<?php if(!empty($addnew)): ?>
	// for adding a new client
	$("tr[name='newclient']").click(function () {
		$("#javascript-form").attr("action", "newclient.php"); 
		
		var lastName = "<input type='hidden' name='LastName' value='<?php echo $addnew["LastName"] ?>' />"; 
		var firstName = "<input type='hidden' name='FirstName' value='<?php echo $addnew["FirstName"] ?>' />"; 
		var phoneNumber = "<input type='hidden' name='Phone1Number' value='<?php echo $addnew["PhoneNumber"] ?>' />"; 
		var email = "<input type='hidden' name='Email' value='<?php echo $addnew["Email"] ?>' />";
		var language = "<input type='hidden' name='Language' value='<?php echo $addnew["Language"] ?>' />";
		
		$("#javascript-form").append(lastName + firstName + phoneNumber + email + language); 
		$("#javascript-form").submit(); 
	}); 
	<?php endif; ?>
</script>
<?php endif; ?>
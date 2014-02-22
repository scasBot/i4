<div class="row">
	<div class="span3"></div>
	<div class="span6">
		<table>
			<tr>
				<td>Clients Assisted:</td>
				<td><?php echo $stats["clients_assisted"] ?></td>
			</tr>
			<tr>
				<td>Clients Assisted by Phone:</td>
				<td><?php echo $stats["clients_assisted_by_phone"] ?></td>
			</tr>
			<tr>
				<td>Clients Assisted by Email:</td>
				<td><?php echo $stats["clients_assisted_by_email"] ?></td>
			</tr>
			<tr>
				<td>Clients Assisted by Appointment:</td>
				<td><?php echo $stats["clients_assisted_by_appointment"] ?></td>
			</tr>			
			<tr>
				<td>Clients Assisted by Voicemail: </td>
				<td><?php echo $stats["clients_assisted_by_voicemail"] ?></td>
			</tr>
		</table>
	</div>
	<div class="span3"></div>
</div>
<?php
	require("cases_list.php"); 
?>
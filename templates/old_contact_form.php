<h1 style="margin-top: 0">Old i3 Contacts</h1>
<table class="table table-bordered" style="cursor: auto; margin-bottom: 20px;">	
	<thead>
		<tr><td colspan="3">
		<b>Notes: </b>
		<?php 
			$paragraphs = explode("\n", $i3_contacts["notes"]); 
			
			foreach($paragraphs as $paragraph) {
				echo "<p>" . $paragraph . "</p>"; 
			}
		?>
		</td></tr>
		<tr>
			<th>Type</th>
			<th>Date</th>
			<th>Added By</th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach($i3_contacts["contacts"] as $contact) {
			echo 
				"<tr><td>".$contact["ContactType"]."</td>" . 
				"<td>".$contact["ContactDate"]."</td><td>".$contact["UserName"]."</td></tr>"; 
		}
	?>
	</tbody>
</table>

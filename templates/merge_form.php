<?php 
	require("../includes/client_class.php"); 
	$client1 = new Client(16209); 
	$client2 = new Client(16200); 
	
	function createId($str) {
		global $clientNumber; 
		return $str . $clientNumber; 
	}
	
?>

<div class='row'>
	<div id='clientOne' class='span4'>
		<?php
			if($client1) {
				$client = $client1;
				$clientNumber = 1; 
				require("merge_form_fillable.php"); 
			} else {
				require("merge_form_searchable.php"); 
			}
		?>
	</div>
	<div id='clientMerged' class='span4'>
		<?php
			require("merge_form_merger.php"); 
		?>
	</div>
	<div id='clientTwo' class='span4'>
		<?php
			if($client2) {
				$client = $client2; 
				$clientNumber = 2; 
				require("merge_form_fillable.php"); 
			} else {
				require("merge_form_searchable.php"); 
			}
		?>
	</div>
</div>

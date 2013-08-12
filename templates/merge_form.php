<?php 
	require("../includes/client_class.php"); 
	$client1 = new Client(16209); 
	$client2 = new Client(16200); 	
	global $clientNumber; 
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
<script type='text/javascript'>
function MergeForm() {
	var numClients = $(".merge-form-fillable").length; 
	
	if(numClients == 1) 
		var mergeForm = new Merge1Form(); 
	else 
		var mergeForm = new Merge2Form(); 
		
	this.__proto__ = mergeForm; 
}
function Merge1Form() {
	$(".merger-input").each(function() {
		var id = $(this).attr("id") + "1";
		var input = $("#" + id).text(); 
		$(this).val(input); 
	}); 
}
function Merge2Form() {
	$(".merger-input").each(function() {
		var id = $(this).attr("id"); 
		var input = $("#" + id + "1").text();
		if(input == "")
			input = $("#" + id + "2").text(); 
		$(this).val(input); 
	}); 
}

var mergeForm = new MergeForm(); 

</script>
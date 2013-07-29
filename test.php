<?php
	$handle = fopen("data/emails.php", "r"); 
	
	$result = array(); 
	for($line = fgets($handle); $line; $line = fgets($handle)) {
		$result[] = json_decode($line); 
	}
?>
<script>
	var emails = <?php echo json_encode($result) ?>; 
</script>
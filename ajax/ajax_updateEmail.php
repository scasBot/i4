<?php
/*
 * ajax_updateEmail.php
 * 
 * created by Chris Lim
 *
 * deals with ajax request pertaining to 
 * emails
 */

	if ($data["Action"] == "Delete")
	{
		$id = $data["id"];
		$query = "DELETE FROM db_Emails WHERE id = $id";
		query($query);

	}
	
	echo json_encode(array("Success"=>true)); 
	die(); 
?>

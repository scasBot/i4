<h1><?php echo "Client " . $client->get_id(); ?></h1>
<?php
    if(!function_exists("createId")) {
        function createId($str) {
            global $clientNumber; 
            return $str . $clientNumber; 
        }	
    }

    $fields = array(
        array("First Name:", "FirstName", $client->get("info")->get("FirstName")), 
        array("Last Name:", "LastName", $client->get("info")->get("LastName")), 
        array("Primary Phone:", "Phone1Number", $client->get("info")->get("Phone1Number")), 
        array("Secondary Phone:", "Phone2Number", $client->get("info")->get("Phone2Number")), 
        array("Email:", "Email", $client->get("info")->get("Email")), 
        array("Address:", "Address", $client->get("info")->get("Address")), 
        array("City:", "City", $client->get("info")->get("Address")),
        array("State:", "State", $client->get("info")->get("State")),
        array("Referral Source:", "ReferralSource", $client->get("info")->get("ReferralSource")),
        array("Zip:", "Zip", $client->get("info")->get("Zip")),
        array("Language:", "Language", $client->get("info")->get("Language")), 
        array("Notes:", "ClientNotes", $client->get("info")->get("ClientNotes")),    
    ); 
?>

<table class="table table-bordered">
    <?php foreach($fields as $field) : ?>
		<tr>
             <td><?php echo $field[0] ?></td>
             <td id="<?php echo createId($field[1]) ?>"><?php echo $field[2] ?></td>
        </tr>
    <?php endforeach ?>
</table>
<script type="text/javascript">
	var ClientID<?php echo $clientNumber ?> = <?php echo $client->get_id() ?>; 
</script>

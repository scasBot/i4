<h3 style='border-bottom: 1px solid black'><?php echo "Client " . $client->get_id(); ?></h3>
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
        array("Zip:", "Zip", $client->get("info")->get("Zip")),
        array("Language:", "Language", $client->get("info")->get("Language")), 
        array("Notes:", "ClientNotes", $client->get("info")->get("ClientNotes")),    
    ); 
?>

<div class='merge-form-fillable' data-clientNumber='<?php echo $clientNumber ?>' >    
    <?php foreach($fields as $field) : ?>
        <div class='well well-small merginfo'>
            <div class='row'>
                <div class='span3'>
                    <p style='text-align: left; font-weigh: bold'><?php echo $field[0] ?></p>
                </div>
            </div>
            <div class='row'>
                <div class='span3'>
                    <p id="<?php echo createId($field[1]) ?>" style='text-align: left'><?php echo $field[2] ?></p>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>
<script type="text/javascript">
	var ClientID<?php echo $clientNumber ?> = <?php echo $client->get_id() ?>; 
</script>
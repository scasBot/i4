<?php
  require dirname(__DIR__) . "/vendor/twilio-php-main/src/Twilio/autoload.php";
  require dirname(__DIR__) . "/includes/constants.php";
  require dirname(__DIR__) . "/includes/constants_passwords.php";
  use Twilio\Rest\Client;

  $client = new Client(TWILIO_ACCOUNT_SID, TWILIO_AUTH_TOKEN);
  $client->messages->create(
    TWILIO_TO_NUMBER,
    array(
      "from" => TWILIO_FROM_NUMBER,
      "body" => "Hello world!"
    )
  );
?>

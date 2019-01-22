<?php
// the message
$msg = "keeeys";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email

mail("kai.gorg@tts.edu.sg","Award",$msg);
mail("kai.gorg@tts.edu.sg","Award",$msg);
echo "email sent";
?>
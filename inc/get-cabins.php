<?php
// Load in the class that will parse the XML from the URL
require_once('XMLtoJSON.class.php');

// Does the cabin object exist?
/*if(isset($_POST['cabin']))
{
*/
	// Put the post data into a variable
	$cabin = $_POST['cabin'];
	
	// Set the parameters for the cabin data
	$pw = 'pw=';
	$pw .= $cabin['pw'] ?  $cabin['pw'] : '5star';		// Password
	$sd = 'SD=' . $cabin['SD'];		// Start Date
	$ed = 'ED=' . $cabin['ED'];		// End Date
	$rt = 'RT=' . $cabin['RT'];		// Room Type
	
	// Create URL
	$url = 'https://secure.naturalbridgecabinrental.com/iqanywhere/xmlGetAvail.asp?'. $pw . '&' . $sd . '&' . $ed . '&' . $rt;

	// Parse the XML and encode to JSON from URL
	echo XMLtoJSON::Parse($url);
//}
?>
<?php
// Pull in the NuSOAP code
require ('../lib/nusoap/nusoap.php');
// Create the client instance
$client = new soapclient('http://wx.mim1314.com/raw/soap.php');
// Call the SOAP method
$result = $client->call('hello', array('8Scott'));
// Display the result
print_r($result);
?>
<?php
header("Content-Type:text/html;charset=UTF-8");
require ('../lib/nusoap/nusoap.php');

$server = new soap_server();

$server->configureWSDL('hello', 'hello');
$server->wsdl->schemaTargetNamespace = 'hello';

$server->register('hello', // method name
	array (
		'name' => 'xsd:string'
	), // input parameters
	array (
		'return' => 'xsd:string'
	), // output parameters
	'hello', // namespace
	'hello', // soapaction
	'rpc', // style
	'encoded', // use
	'Says hello to the caller' // documentation
	);

function hello($name) {
	if ($name == '') {
		return new soap_fault('Client', '', 'Must supply a valid name.');
	}
	return 'Hello' . $name;
}

$HTTP_RAW_POST_DATA = isset ($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';

$server->service($HTTP_RAW_POST_DATA);
exit;
?>
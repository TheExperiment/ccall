<?php

require('../vendor/autoload.php');
require("../libs/postmark.php");

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel to STDERR
$log = new Logger('ccall process handler');
$log->pushHandler(new StreamHandler('php://stderr', Logger::INFO));

$inbound = new \Postmark\Inbound(file_get_contents('php://input'));

if ($inbound->To() !== 'pam@ccall.me') {
	return;
}

$log->addInfo( 'Email received from: ' . $inbound->From() );


$re = "/(\\+?(?:(?:9[976]\\d|8[987530]\\d|6[987]\\d|5[90]\\d|42\\d|3[875]\\d|2[98654321]\\d|9[8543210]|8[6421]|6[6543210]|5[87654321]|4[987654310]|3[9643210]|2[70]|7|1)|\\((?:9[976]\\d|8[987530]\\d|6[987]\\d|5[90]\\d|42\\d|3[875]\\d|2[98654321]\\d|9[8543210]|8[6421]|6[6543210]|5[87654321]|4[987654310]|3[9643210]|2[70]|7|1)\\))[0-9. -]{4,14})(?:\\b|x\\d+)/"; 
$str = $inbound->TextBody(); 
$subst = ''; 
 
$detectedNumbers = preg_replace($re, $subst, $str);

// $inbound->TextBody();
// $inbound->HtmlBody();

// Response
$postmark = new Postmark( getenv('POSTMARK_API_KEY'), "bot@ccall.me" );

$result = $postmark	->to( $inbound->From() )
					->subject( $inbound->Subject() )
					->plain_message($detectedNumbers)
					->send();

if($result === true) {
	$log->addInfo( 'Response Sent, detected numbers in body: ' + $detectedNumbers);
} else {
	$log->addWarning( 'Response Failed to send: ' . $result);
}

//->attachment('File.pdf', $file_as_string, 'application/pdf')
	
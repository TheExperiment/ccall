<?php

require('../vendor/autoload.php');
require("../libs/postmark.php");

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel to STDERR
$log = new Logger('ccall process handler');
$log->pushHandler(new StreamHandler('php://stderr', Logger::INFO));

$inbound = new \Postmark\Inbound(file_get_contents('php://input'));

$log->addInfo( 'Email received with subject: ' . $inbound->Subject() );

// Response
$postmark = new Postmark( getenv('POSTMARK_API_KEY'), "bot@ccall.me" );

$result = $postmark	->to( $inbound->From() )
					->subject( $inbound->Subject() )
					->plain_message("This is a plain text message.")
					->send();

if($result === true) {
	$log->addInfo( 'Response Sent' );
} else {
	$log->addWarning( 'Response Failed to send: ' . $result);
}

//->attachment('File.pdf', $file_as_string, 'application/pdf')
	
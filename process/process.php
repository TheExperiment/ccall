<?php

require('../vendor/autoload.php');
require("../libs/postmark.php");

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel to STDERR
$log = new Logger('ccall process handler');
$log->pushHandler(new StreamHandler('php://stderr', Logger::INFO));

$inbound = new \Postmark\Inbound(file_get_contents('php://input'));

/* Waiting until To is available
if ($inbound->To() != 'pam@ccall.me') {
	exit(1);
}
*/

$log->addInfo( 'Email received from: ' . $inbound->FromEmail() );
$log->addInfo( 'Body plain content: ' . $inbound->TextBody() );
$log->addInfo( 'Body html content: ' . $inbound->HtmlBody() );

$re = "/(\\+?(?:(?:9[976]\\d|8[987530]\\d|6[987]\\d|5[90]\\d|42\\d|3[875]\\d|2[98654321]\\d|9[8543210]|8[6421]|6[6543210]|5[87654321]|4[987654310]|3[9643210]|2[70]|7|1)|\\((?:9[976]\\d|8[987530]\\d|6[987]\\d|5[90]\\d|42\\d|3[875]\\d|2[98654321]\\d|9[8543210]|8[6421]|6[6543210]|5[87654321]|4[987654310]|3[9643210]|2[70]|7|1)\\))[0-9. -]{4,14})(?:\\b|x\\d+)/mi";  
$str = $inbound->TextBody(); 
 
preg_match_all($re, $str, $matches);

$matchesList = '';
for ($i=0; $i < count($matches); $i++) {
	$matchesList += $matches . '\n';
}

$log->addInfo( 'detectedNumbers: ' . $matchesList);

// Response
$postmark = new Postmark( getenv('POSTMARK_API_KEY'), "pam@ccall.me" );

$result = $postmark	->to( $inbound->FromEmail() )
					->subject( $inbound->Subject() )
					->plain_message( $matchesList )
					->send();

if($result === true) {
	$log->addInfo( 'Response Sent' );
} else {
	$log->addWarning( 'Response Failed to send: ' . $result);
}

?>	
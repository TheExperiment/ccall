<?php

require('../vendor/autoload.php');

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel to STDERR
$log = new Logger('ccall process handler');
$log->pushHandler(new StreamHandler('php://stderr', Logger::INFO));

$inbound = new \Postmark\Inbound(file_get_contents('php://input'));

$log->addInfo( 'Email received with subject: ' . $inbound->Subject() );

// Response
$transport = Swift_PostmarkTransport::newInstance( getenv('POSTMARK_API_KEY') );

$mailer = Swift_Mailer::newInstance($transport);
$message = Swift_Message::newInstance();

// Add stuff to your message
// $message->setFrom('test@example.com');
$message->setTo( $inbound->FromEmail() );
$message->setSubject( $inbound->Subject() );
$message->setBody('My Reply');

$mailer->send($message);
<?php

require('../vendor/autoload.php');

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel to STDERR
$log = new Logger('ccall process handler');
$log->pushHandler(new StreamHandler('php://stderr', Logger::INFO));

$inbound = new \Postmark\Inbound(file_get_contents('php://input'));

$log->addInfo( 'Email received with subject: ' . $inbound->Subject() );
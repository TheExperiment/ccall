<?php

require('../vendor/autoload.php');

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel to STDERR
$log = new Logger('ccall process handler');
$log->pushHandler(new StreamHandler('php://stderr', Logger::INFO));

// add records to the log
$json = file_get_contents('php://input');
$obj = json_decode($json);

$log->addInfo($json);
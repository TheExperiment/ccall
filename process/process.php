<?php

require('../vendor/autoload.php');

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel to STDERR
$log = new Logger('ccall process handler');
$log->pushHandler(new StreamHandler('php://stderr', Logger::INFO));

// add records to the log
$arr = get_defined_vars();
$log->addInfo(print_r($arr));

/*
$json = '{"foo-bar": 12345}';

$obj = json_decode($json);
print $obj->{'foo-bar'}; // 12345
*/
?>
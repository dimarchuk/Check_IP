<?php

require_once 'Checkip.php';

$currentIp = '36.67.142.53';

$obj = Checkip::init();

try {

    $rez = $obj->checkIp($currentIp);
    $message = $rez ? 'good visitor' : 'not good visitor';
    echo $message;
    var_dump($obj->get());

} catch (Exception $e) {
    echo $e->getMessage();
}
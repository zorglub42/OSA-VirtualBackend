<?php
/**
 * OSA-VirtualBackend
 * 
 * PHP Version 7.0
 * 
 * @category OSA-Addon
 * @package  OSA-VirtualBackend
 * @author   Zorglub42 <contact@zorglub42.fr>
 * @license  http://www.apache.org/licenses/LICENSE-2.0.htm Apache 2 license
 * @link     https://github.com/zorglub42/OSA/
 * 
 * @codingStandardsIgnoreStart
*/
/*--------------------------------------------------------
 # Module Name : OSA-VirtualBackend
 # Version : 1.0.0
 #
 #
 # Copyright (c) 2018 Zorglub42
 # This software is distributed under the Apache 2 license
 # <http://www.apache.org/licenses/LICENSE-2.0.html>
 #
 #--------------------------------------------------------
 # File Name   : web/index.php
 #
 # Created     : 2018-04
 # Authors     : zorglub42 <contact(at)zorglub42.fr>
 #
 # Description :
 #      JS functions used by OSA-VirtualBackend addon 
 #--------------------------------------------------------
 # History     :
 # 1.0.0 - 2018-04-05 : Release of the file
*/


require_once dirname(__FILE__) .'/include/restler3/restler.php';
use Luracast\Restler\Restler;


Resources::$useFormatAsExtension = false;

//CORS Compliancy
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: X-Requested-With, Depth, Authorization");
header(
    "Access-Control-Allow-Methods: " .
    "OPTIONS, GET, HEAD, DELETE, PROPFIND, PUT, PROPPATCH, COPY, MOVE, ".
    "REPORT, LOCK, UNLOCK"
);
header("Access-Control-Allow-Origin: *");


$r = new Restler();
if (isset(getallheaders()["Public-Root-URI"])) {
    $r->setBaseUrl(getallheaders()["Public-Root-URI"] . "/addons/virtualbackend");
}

$r->setSupportedFormats('JsonFormat', 'UrlEncodedFormat');
$r->addAPIClass('Luracast\\Restler\\Resources');  

$r->addAPIClass('VBServices', 'services');
$r->addAPIClass('VBHosts', 'hosts');
$r->handle();

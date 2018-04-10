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
*/
/*--------------------------------------------------------
 # Module Name : OSA-VirtualBackend
 # Version : 1.0.0
 #
 #
 # Copyright (c) 2017 Zorglub42
 # This software is distributed under the Apache 2 license
 # <http://www.apache.org/licenses/LICENSE-2.0.html>
 #
 #--------------------------------------------------------
 # File Name   : web/include/DataModel.php
 #
 # Created     : 2017-03
 # Authors     : zorglub42 <contact(at)zorglub42.fr>
 #
 # Description :
 #      OSA-VirtualBackend objets definitions
 #--------------------------------------------------------
 # History     :
 # 1.0.0 - 2017-03-01 : Release of the file
*/

$curDir = getcwd();
chdir(OSA_INSTALL_DIR . '/ApplianceManager.php/api');
require_once '../objects/Service.class.php';
chdir($curDir);

/**
 * Services
 * 
 * PHP Version 7.0
 * 
 * @category OSA-Addon
 * @package  OSA-VirtualBackend
 * @author   Zorglub42 <contact@zorglub42.fr>
 * @license  http://www.apache.org/licenses/LICENSE-2.0.htm Apache 2 license
 * @link     https://github.com/zorglub42/OSA/
*/
class OSAVBService
{
    
    /**
     * Virtual host Identifier {@required true}
     * 
     * @var string 
    */
    public  $virtualHost;
    /**
     * OSA Sedrvice name (id) {@required true}
     * 
     * @var string 
     */
    public  $serviceName;
}
/**
 * Virtual backends
 * 
 * PHP Version 7.0
 * 
 * @category OSA-Addon
 * @package  OSA-VirtualBackend
 * @author   Zorglub42 <contact@zorglub42.fr>
 * @license  http://www.apache.org/licenses/LICENSE-2.0.htm Apache 2 license
 * @link     https://github.com/zorglub42/OSA/
*/
class OSAVBHost
{

    /**
     * Virtual host Identifier {@required true}
     * 
     * @var string 
    */
    public  $virtualHost;
    /**
     * Hostname, IP, Port....
     * Ex. backend-server.localdomain:1883, 172.16.0.3:5169
     * 
     * @var string 
    */
    public  $hostAddress;

    /**
     * Associated services
     * 
     * @var array {@type Service} 
     */
    var $services=Array();
}    

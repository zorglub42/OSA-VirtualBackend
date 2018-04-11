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
 # File Name   : web/include/ConfigDAO.php
 #
 # Created     : 2018-04
 # Authors     : zorglub42 <contact(at)zorglub42.fr>
 #
 # Description :
 #      OSA-VirtualBackend Config persitance management
 #--------------------------------------------------------
 # History     :
 # 1.0.0 - 2017-04-05 : Release of the file
*/
require_once 'include/Settings.php';


/**
 * Manage OSA-VirtualBackend config disk storage
 * 
 * PHP Version 7.0
 * 
 * @category OSA-Addon
 * @package  OSA-VirtualBackend
 * @author   Zorglub42 <contact@zorglub42.fr>
 * @license  http://www.apache.org/licenses/LICENSE-2.0.htm Apache 2 license
 * @link     https://github.com/zorglub42/OSA/
*/
class OSAVBConfigDAO
{
    static $config=null;
    /**
     * Load config from json file
     * 
     * @return void
     */
    function loadData()
    {
        if (OSAVBConfigDAO::$config === null) {
            OSAVBConfigDAO::$config=Array();
            if (file_exists(DATA_FILE)) {
                OSAVBConfigDAO::$config=json_decode(file_get_contents(DATA_FILE), true);
                ksort(OSAVBConfigDAO::$config);
                foreach (OSAVBConfigDAO::$config as $hostname => $config) {
                    ksort(OSAVBConfigDAO::$config[$hostname]["services"]);
                }
            }
        }
    }
    /**
     * Save config to json file
     * 
     * @return array
     */
    function saveData()
    {
        file_put_contents(DATA_FILE, json_encode(OSAVBConfigDAO::$config, JSON_PRETTY_PRINT));
    }
	
}
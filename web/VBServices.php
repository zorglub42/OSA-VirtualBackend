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
 # File Name   : web/VBServices.php
 #
 # Created     : 2018-04
 # Authors     : zorglub42 <contact(at)zorglub42.fr>
 #
 # Description :
 #      OSA-VirtualBackend REST API handler (services)
 #--------------------------------------------------------
 # History     :
 # 1.0.0 - 2017-04-05 : Release of the file
*/
require_once 'include/Settings.php';
require_once 'include/DataModel.php';
require_once 'include/ConfigDAO.php';


/**
 * Manage Services configuration for Virtual Backends
 * 
 * PHP Version 7.0
 * 
 * @category OSA-Addon
 * @package  OSA-VirtualBackend
 * @author   Zorglub42 <contact@zorglub42.fr>
 * @license  http://www.apache.org/licenses/LICENSE-2.0.htm Apache 2 license
 * @link     https://github.com/zorglub42/OSA/
*/
class VBServices
{

    /**
     * Get all configured services
     * 
     * Get all configured services
     * 
     * @url GET
     * 
     * @return array {@type OSAVBService} Services
     */
    function get()
    {
        $rc=array();

        OSAVBConfigDAO::loadData();
        foreach (OSAVBConfigDAO::$config as $hostname => $config) {
            $services=$config["services"];
            foreach ($services as $serviceName => $service) {
                array_push($rc, $service);
            }
        }
        return $rc;
    }

    /**
     * Get one configured services
     * 
     * Get one configured services
     * 
     * @param string $serviceName OSA Service ID
     * 
     * @url GET :serviceName
     * 
     * @return OSAVBService Services
     */
    function getOne($serviceName)
    {
        $rc = null;
        $services=$this->get();
        foreach ($services as $service){
            if ($service["serviceName"]==$serviceName){
                $rc=$service;
                break;
            }
        }
        if ($rc == null){
            throw new RestException(404, "Can't find service " . $serviceName);
        }
        return $rc;
    }


    /**
     * Store a service config
     * 
     * Store a service config
     * 
     * @param string $serviceName OSA Service ID
     * @param string $virtualHost Virtual host ID
     * 
     * @url POST
     * 
     * @return OSAVBService Service
     */
    function store($serviceName, $virtualHost)
    {
        OSAVBConfigDAO::loadData();
        try {
            $service = $this->getOne($serviceName);
            unset(OSAVBConfigDAO::$config[$service["virtualHost"]]["services"][$serviceName]);
        }catch (RestException $re){
            if (!$re->getCode() == 404){
                throw $re;
            }
        }
        OSAVBConfigDAO::$config[$virtualHost]["virtualHost"]=$virtualHost;
        OSAVBConfigDAO::$config[$virtualHost]["services"][$serviceName]["virtualHost"]=$virtualHost;
        OSAVBConfigDAO::$config[$virtualHost]["services"][$serviceName]["serviceName"]=$serviceName;
        OSAVBConfigDAO::saveData();
        return OSAVBConfigDAO::$config[$virtualHost]["services"][$serviceName];
    }


    /**
     * Delete a service config
     * 
     * Delete a service config
     * 
     * @param string $serviceName OSA Service ID
     * 
     * @url DELETE :serviceName
     * 
     * @return OSAVBService Service
     */
    function delete($serviceName)
    {
        OSAVBConfigDAO::loadData();
        $service = $this->getOne($serviceName);
        unset(OSAVBConfigDAO::$config[$service["virtualHost"]]["services"][$serviceName]);
        OSAVBConfigDAO::saveData();
        return $service;
    }


    
}

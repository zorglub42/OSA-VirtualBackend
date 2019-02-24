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
 # File Name   : web/VBHosts.php
 #
 # Created     : 2018-04
 # Authors     : zorglub42 <contact(at)zorglub42.fr>
 #
 # Description :
 #      OSA-VirtualBackend REST API handler (virtual backend hosts)
 #--------------------------------------------------------
 # History     :
 # 1.0.0 - 2017-04-05 : Release of the file
*/
require_once 'VBServices.php';
require_once 'include/Settings.php';
require_once 'include/DataModel.php';
require_once 'include/ConfigDAO.php';
require_once OSA_INSTALL_DIR . '/ApplianceManager.php/include/Func.inc.php';

$curDir = getcwd();
chdir(OSA_INSTALL_DIR . '/ApplianceManager.php/api');
require_once '../objects/Service.class.php';
require_once 'Services.php';
chdir($curDir);


/**
 * Manage Hots configuration for Virtual Backends
 * 
 * PHP Version 7.0
 * 
 * @category OSA-Addon
 * @package  OSA-VirtualBackend
 * @author   Zorglub42 <contact@zorglub42.fr>
 * @license  http://www.apache.org/licenses/LICENSE-2.0.htm Apache 2 license
 * @link     https://github.com/zorglub42/OSA/
*/
class VBHosts
{
    /**
     * Update backend endpoint on OSA Service 
     * 
     * @param Service $osaService  OSA Service
     * @param string  $hostAddress Virtual backend host address
     * 
     * @return Service Service updated
     */
    private function _updateBackendEndpoint($osaService, $hostAddress) {
        $newEndpoint=preg_replace(
            "/(.*):\/\/[^\/|^$]*(.*)/", 
            '$1://' . $hostAddress . '$2', 
            $osaService["backEndEndPoint"]
        );
        $osaService["backEndEndPoint"]=$newEndpoint;
        return $osaService;
    }





    /**
     * Get all configured hosts
     * 
     * Get all configured hosts
     * 
     * @url GET
     * 
     * @return array {@type OSAVBHost} Hosts
     */
    function get()
    {
        $osaService = new Services();
        $rc=array();

        OSAVBConfigDAO::loadData();
        foreach (OSAVBConfigDAO::$config as $hostname => $config) {
            $services=$config["services"];
            unset($config["services"]);
            $config["services"]=Array();
            // $services=$config["services"];
            // $publicServiceList=Array();
            foreach ($services as $serviceName => $service) {
                try {
                    $svc=$osaService->getOne($service["serviceName"]);
                    array_push($config["services"], $svc);
                }catch (RestException $re){
                    if ($re->getCode() != 404){
                        throw $re;
                    }else{
                        $vbSvc = new VBServices();

                        $vbSvc->delete($service["serviceName"]);
                    }
                }
            }
            array_push($rc, $config);
        }
        return $rc;
    }

    /**
     * Get one configured host
     * 
     * Get one configured host
     * 
     * @param string $virtualHost Virtual backend host ID
     * 
     * @url GET :virtualHost
     * 
     * @return OSAVBHost Virtual backend
     */
    function getOne($virtualHost)
    {
        $rc = null;
        $hosts=$this->get();
        foreach ($hosts as $host) {
            if ($host["virtualHost"] == $virtualHost) {
                $rc=$host;
                break;
            }
        }
        if ($rc == null) {
            throw new RestException(404, "Can't find host " . $virtualHost);
        }
        return $rc;
    }


    /**
     * Update host config
     * 
     * Update host config and apply apache config
     * 
     * @param string $virtualHost Virtual host ID {@from query}
     * @param string $hostAddress Virtual host address/IP/Port
     * 
     * @url POST :virtualHost
     * 
     * @return OSAVBHost Updated Host
     */
    function updateAndDeploy($virtualHost, $hostAddress)
    {
        $hostAddress=preg_replace("/.*:\/\/([^\/]*).*/", '$1', $hostAddress);
        OSAVBConfigDAO::loadData();
        $host = $this->getOne($virtualHost);
        $host["hostAddress"]=$hostAddress;
        OSAVBConfigDAO::$config[$virtualHost]["hostAddress"]=$hostAddress;
        OSAVBConfigDAO::saveData();

        $osaServicesAPI=new Services();

        foreach ($host["services"] as $service) {
            $osaService = $osaServicesAPI->getOne($service["serviceName"]);
            $osaService=$this->_updateBackendEndpoint($osaService, $hostAddress);

            if (isset($osaService["additionalBackendConnectionConfiguration"])) {
                // OSA > 4.1
                    $osaServicesAPI->update(
                        $osaService["serviceName"], $osaService["frontEndEndPoint"], $osaService["backEndEndPoint"],
                        $osaService["isPublished"], $osaService["additionalConfiguration"], $osaService["additionalBackendConnectionConfiguration"],
                        $osaService["isHitLoggingEnabled"], $osaService["onAllNodes"],
                        $osaService["isUserAuthenticationEnabled"], $osaService["groupName"],
                        $osaService["isIdentityForwardingEnabled"], $osaService["isAnonymousAllowed"],
                        $osaService["backEndUsername"], $osaService["backEndPassword"], $osaService["loginFormUri"],
                        $osaService["isGlobalQuotasEnabled"], $osaService["reqSec"], $osaService["reqDay"],
                        $osaService["reqMonth"], $osaService["isUserQuotasEnabled"], 1
                    );
            } else {
                // OSA <= 4.1
                $osaServicesAPI->update(
                    $osaService["serviceName"], $osaService["frontEndEndPoint"], $osaService["backEndEndPoint"],
                    $osaService["isPublished"], $osaService["additionalConfiguration"],
                    $osaService["isHitLoggingEnabled"], $osaService["onAllNodes"],
                    $osaService["isUserAuthenticationEnabled"], $osaService["groupName"],
                    $osaService["isIdentityForwardingEnabled"], $osaService["isAnonymousAllowed"],
                    $osaService["backEndUsername"], $osaService["backEndPassword"], $osaService["loginFormUri"],
                    $osaService["isGlobalQuotasEnabled"], $osaService["reqSec"], $osaService["reqDay"],
                    $osaService["reqMonth"], $osaService["isUserQuotasEnabled"], 1
                );
    
            }
        }
        if (!applyApacheConfiguration()) {
            throw new RestException(500, "Error while applying apache configuration");
        }
        return $host;
    }


    /**
     * Delete a host config
     * 
     * Delete a host config
     * 
     * @param string $serviceName OSA Service ID
     * 
     * @url DELETE :virtualHost
     * 
     * @return OSAVBHost virtualHost
     */
    function delete($virtualHost)
    {
        OSAVBConfigDAO::loadData();
        $host = $this->getOne($virtualHost);
        unset(OSAVBConfigDAO::$config[$virtualHost]);
        OSAVBConfigDAO::saveData();
        return $host;
    }


    
}

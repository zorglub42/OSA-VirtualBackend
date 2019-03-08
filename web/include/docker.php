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
 # Copyright (c) 2019 Zorglub42
 # This software is distributed under the Apache 2 license
 # <http://www.apache.org/licenses/LICENSE-2.0.html>
 #
 #--------------------------------------------------------
 # File Name   : web/include/docker.php
 #
 # Created     : 2019-03
 # Authors     : zorglub42 <contact(at)zorglub42.fr>
 #
 # Description :
 #      OSA-VirtualBackend docker helpers
 #--------------------------------------------------------
 # History     :
 # 1.0.0 - 2019-03-08 : Release of the file
*/


function getContainersNames() {
	$out=Array();
	exec("sudo docker ps | awk '{print \$NF}'|tail -n +2", $out);
	for ($i=0; $i < count($out); $i++){
		$out[$i]=trim($out[$i]);
	}
	return $out;
}

function getContainerIP($name) {
	$out = Array();
	exec("sudo docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' $name", $out);
	return $out[0];
}


function getContainerPorts($name) {
	$out = array();
	exec("sudo docker inspect $name | grep \"/tcp\" | sed 's/\"\\([0-9]*\\).*/\\1/'| sort -u", $out);
	for ($i=0; $i < count($out); $i++){
		$out[$i]=(int)trim($out[$i]);
	}
	return $out;
}

function containerExists($container) {
	exec("sudo docker inspect $container", $out , $res);
	return $res == 0;
}
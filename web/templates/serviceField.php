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
 # File Name   : web/templates/menuItem.php
 #
 # Created     : 2018-04
 # Authors     : zorglub42 <contact(at)zorglub42.fr>
 #
 # Description :
 #      Service detail form additinal field template
 #--------------------------------------------------------
 # History     :
 # 1.0.0 - 2018-04-05 : Release of the file
*/


require_once dirname(__FILE__) . '/../include/VB_Localization.php';
?>
<label for="backEndEndPoint"><?php echo VB_Localization::getString("label.overload") ?></label>
<input class="form-control" placeholder="<?php echo VB_Localization::getString("label.overload.placeholder") ?>" 
	   type="text" 
	   id="virtualBackendImageId" 
	   value="" 
	   onchange="setServiceModified(true)" 
	   onkeypress="setServiceModified(true)">
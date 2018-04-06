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
 #      Main menu Item HTML template
 #--------------------------------------------------------
 # History     :
 # 1.0.0 - 2018-04-05 : Release of the file
*/


require_once dirname(__FILE__) . '/../include/VB_Localization.php';
?>
<li>
	<a href="#" id="virtualBackenMenu" class="dropdown-toggle" data-toggle="dropdown"
		role="button" aria-haspopup="true" aria-expanded="false">
		<?php echo VB_Localization::getString("menu.label") ?>
	</a>
</li>
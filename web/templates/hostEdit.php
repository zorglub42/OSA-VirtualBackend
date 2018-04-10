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
 # File Name   : web/templates/hostsEdit.php
 #
 # Created     : 2018-04
 # Authors     : zorglub42 <contact(at)zorglub42.fr>
 #
 # Description :
 #      Host detail HTML template
 #--------------------------------------------------------
 # History     :
 # 1.0.0 - 2018-04-05 : Release of the file
*/
require_once "../include/VB_Localization.php";
require_once "../include/Settings.php";

require_once  OSA_INSTALL_DIR . '/ApplianceManager.php/include/Localization.php';

?>

		<div class="row" id="hostEdit">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><b><?php echo VB_Localization::getString("host.properties")?>: {host.virtualHost}</b></h3>
					</div>
					<div class="panel-body">
						<form accept-charset="UTF-8" role="form">
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="<?php echo VB_Localization::getString("host.virtualHost.placeholder")?>"  title="<?php echo VB_Localization::getString("host.virtualHost.tooltip")?>" type="hidden" id="vbVirtualHost" onchange="setVBHostModified(true)" onkeypress="setVBHostModified(true)" value="{host.virtualHost}">
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="<?php echo VB_Localization::getString("host.hostAddress.placeholder")?>"  title="<?php echo VB_Localization::getString("host.hostAddress.tooltip")?>" type='text' id='vbHostAddress' onchange="setVBHostModified(true)" onkeypress="setVBHostModified(true)" value="{host.hostAddress}">
							</div>

						</fieldset>
						</form>
						<hr>
						<div class="row " >
							<div class="col-xs-12 col-md-12 ellipsis"><label><?php echo VB_Localization::getString("service.list.name")?></label></div>
						</div>
						<div class="row list-group-item header" >
						<div class="col-xs-4 col-md-4 ellipsis"><?php echo Localization::getString("service.list.serviceName")?></div>
						<div class="col-xs-4 col-md-4 ellipsis"><?php echo Localization::getString("service.list.frontendEndpoint")?></div>
						<div class="col-xs-4 col-md-4 ellipsis"><?php echo Localization::getString("service.list.backendEndpoint")?></div>
						</div>
						<div class="list-group" id="data">
							<a class="list-group-item row" id="rowTpl" style="display:none">
							<div class="col-xs-4 col-md-4 ellipsis" title="{host.services[i].serviceName}">{host.services[i].serviceName}</div>
							<div class="col-xs-4 col-md-4 ellipsis" title="{host.services[i].frontendEndpoint}">{host.services[i].frontendEndpoint}</div>
							<div class="col-xs-4 col-md-4 ellipsis" title="{host.services[i].backendEndpoint}">{host.services[i].backendEndpoint}</div>
							</a>
						</div>
						
					</div>
					<div class="panel-footer">
							<div class="row">
								<div class="col-md-3 col-md-offset-5 col-xs-4 col-xs-offset-4">
									<button type="button" class="btn btn-default" id="saveVBHost" onclick="updateVBHost('{host.virtualHost}')">
										<span><?php echo VB_Localization::getString("button.ok")?></span>
									</button>
									<button type="button" class="btn btn-info" onclick="showVBHosts()">
										<span><?php echo VB_Localization::getString("button.cancel")?></span>
									</button>
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>

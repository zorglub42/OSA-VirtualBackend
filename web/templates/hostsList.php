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
 # File Name   : web/templates/hostsList.php
 #
 # Created     : 2018-04
 # Authors     : zorglub42 <contact(at)zorglub42.fr>
 #
 # Description :
 #      Host list HTML template
 #--------------------------------------------------------
 # History     :
 # 1.0.0 - 2018-04-05 : Release of the file
*/
require_once "../include/VB_Localization.php";
?>
<div class="row" id="vbHostsList">
	<div class="col-md-10 col-md-offset-1 col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><b>{hostsList.length} <?php echo VB_Localization::getString("hosts.list.found")?></b></h3>
			</div>
			<div class="panel-body">
				<div class="row list-group-item header" >
						<div class="col-xs-4 col-md-3 ellipsis"><?php echo VB_Localization::getString("hosts.list.virtualHost")?></div>
						<div class="col-xs-5 col-md-4 ellipsis"><?php echo VB_Localization::getString("hosts.list.hostAddress")?></div>
						<div class="col-xs-5 col-md-3 ellipsis"><?php echo VB_Localization::getString("hosts.list.servicesCount")?></div>
						<div class="col-xs-3 col-md-2	 ellipsis"><?php echo VB_Localization::getString("list.actions")?></div>
				</div>
				<div class="list-group" id="data">
					<a class="list-group-item row" id="rowTpl" style="display:none">
						<div ondblclick="startEditVBHost('{hostsList[i].virtualHost}')">
							<div class="col-xs-4 col-md-3 ellipsis" title="{hostsList[i].virtualHost}">{hostsList[i].virtualHost}</div>
							<div class="col-xs-5 col-md-4 ellipsis" title="{hostsList[i].hostAddress}">{hostsList[i].hostAddress}</div>
							<div class="col-xs-4 col-md-3 ellipsis" title="{hostsList[i].services.length}">{hostsList[i].services.length}</div>
							<div class="col-xs-3 col-md-2 ">
								<button type="button" class="btn btn-default" id="btnEdit" title="<?php echo VB_Localization::getString("hosts.edit.tooltip")?>" onclick="startEditVBHost('{hostsList[i].virtualHost}')">
								  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
								</button>
								<button type="button" class="btn btn-default" id="btnDelete" title="<?php echo VB_Localization::getString("hosts.delete.tooltip")?>" onclick="deleteVBHost('{hostsList[i].virtualHost}')">
								  <span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span>
								</button>
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-md-offset-5 col-md-2 col-xs-2 col-xs-offset-5">
					</div>
				</div>
			</div>
	</div>
</div>
<script>
$(
	function (){
		$('#addGroup').click(addGroup);
	}
);

</script>

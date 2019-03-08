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
 # File Name   : web/js/osa-virtualbackend.js
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


require_once dirname(__FILE__) . '/../include/VB_Localization.php';
?>
var saveServiceHandler;
var previousVH=null;
var vbHostModified=false;
var currendVBHost=null;

function deleteVBHost(virtualHost){

	if (confirm("<?php echo VB_Localization::getJSString("hosts.delete.confirm")?> " + virtualHost + "?")){
		$.ajax({
			url: "addons/virtualbackend/hosts/" + virtualHost ,
			dataType: 'json',
			type:'DELETE',
			success: showVBHosts,
			error: displayErrorV2
			});
	}

}

/* Load group properties template and display */
function editVBHost(vbHost){
	currentVBHost=vbHost;



	$.get( "addons/virtualbackend/templates/hostEdit.php", function( data ) {
			$( "#content" ).html( data.replaceAll("{host.virtualHost}", vbHost.virtualHost )
									  .replaceAll("{host.hostAddress}", vbHost.hostAddress)
							    );
			table=document.getElementById("data");
			rowPattern=document.getElementById("rowTpl");
			table.removeChild(rowPattern);

			for (i=0;i<vbHost.services.length;i++){

				newRow=rowPattern.cloneNode(true);
				newRow.removeAttribute('id');
				newRow.removeAttribute('style');
				newRow.className=newRow.className + " tabular_table_body" +  (i%2);
				newRow.innerHTML=newRow.innerHTML.replaceAll("{host.services[i].serviceName}", vbHost.services[i].serviceName)
												 .replaceAll("{host.services[i].frontendEndpoint}", vbHost.services[i].frontEndEndPoint)
												 .replaceAll("{host.services[i].backendEndpoint}", vbHost.services[i].backEndEndPoint);
				table.appendChild(newRow);
			}
			$.get(
				"addons/virtualbackend/hosts/docker/containers",
				function (data) {
					var autoCompleteList = new Array();
					for (i=0;i<data.length; i++){
						autoCompleteList.push(
								{
									"label": data[i].address + " (" + data[i].name + ")",
									"value" : data[i].address
								}
							);
						for (j=0;j<data[i].ports.length;j++){
							autoCompleteList.push(
								{
									"label": data[i].address +  ":" + data[i].ports[j] + " (" + data[i].name + ")",
									"value" : data[i].address +  ":" + data[i].ports[j]
								}
							);
						}
					}
					autoCompleteList.sort();
					$("#vbHostAddress").autocomplete({
							source: autoCompleteList,
							minLength: 0
					});

				}
			)
								
			setVBHostModified(true);
	});

}


function startEditVBHost(virtualHost){
	$.getJSON("addons/virtualbackend/hosts/" + virtualHost, editVBHost).error(displayErrorV2);

}

function executeDefaultSaveHandler(){
	$("#saveService").attr("onclick",saveServiceHandler)
	$("#saveService").click();

}

function saveService4VB(){
	if (previousVH != null && previousVH != "" && !	doServiceClone && previousVH != $("#serviceName").val()){
		$.ajax({
			url: "addons/virtualbackend/services/" + $("#serviceName").val(),
			dataType: 'json',
			type:'DELETE',
			error: displayErrorV2
		});
	}
	if ($("#virtualBackendImageId").val() != ""){
		conf={
			virtualHost: $("#virtualBackendImageId").val(),
			serviceName: $("#serviceName").val()
		}
		$.ajax({
			url: "addons/virtualbackend/services/",
			dataType: 'json',
			type:'POST',
			data: conf,
			success: executeDefaultSaveHandler,
			error: displayErrorV2
		});
	}else{
		executeDefaultSaveHandler()
	}
	
}

function addVirtualBackendToService(){
	$.get(
		"addons/virtualbackend/templates/serviceField.php",
		function (data){
			saveServiceHandler=$("#saveService").attr("onclick")

			orgHTML = $("#backEndEndPoint").parent().html()
			$("#backEndEndPoint").parent().html('<div class="row"><div class="col-md-7">' + orgHTML + '</div><div class="col-md-5">' + data + '</div></div>')
			$("#saveService").attr("onclick", "saveService4VB()")
			previousVH=null
			if (currentService.serviceName != ""){
				$.get(
					"addons/virtualbackend/services/" + currentService.serviceName,
					function (conf){
						$("#virtualBackendImageId").val(conf.virtualHost)
						previousVH=conf.virtualHost
					}
				);
			}
		}
	)
}


function setVBHostModified(isModified){
	vbHostModified=isModified;

	setActionButtonEnabled('saveVBHost', isModified);
}



/* Load hosts list template and display */
function displayVBHostsList(hostsList){

	$.get(
		"addons/virtualbackend/templates/hostsList.php",
		function(data) {
			$( "#content" ).html( data.replaceAll("{hostsList.length}", hostsList.length));
			table=document.getElementById("data");
			rowPattern=document.getElementById("rowTpl");
			table.removeChild(rowPattern);



			for (i=0;i<hostsList.length;i++){


				newRow=rowPattern.cloneNode(true);
				newRow.removeAttribute('id');
				newRow.removeAttribute('style');
				newRow.className=newRow.className + " tabular_table_body" +  (i%2);
				newRow.innerHTML=newRow.innerHTML.replaceAll("{hostsList[i].virtualHost}", hostsList[i].virtualHost)
												 .replaceAll("{hostsList[i].hostAddress}", hostsList[i].hostAddress)
												 .replaceAll("{hostsList[i].services.length}", hostsList[i].services.length);
				table.appendChild(newRow);
				edit=document.getElementById("btnEdit");
				del=document.getElementById("btnDelete");
				del.removeAttribute("id");
				edit.removeAttribute("id");
			}

			setVBHostModified(false);
			hideWait();
	});
}

/* Search group list and display */
function showVBHosts(){


	$.ajax({
		url : 'addons/virtualbackend/hosts',
		dataType : 'json',
		type : 'GET',
		success : displayVBHostsList,
		error : displayErrorV2
	});

}

function addVirtualBackendMenu(){
	if ($("#virtualBackenMenu").length==0){
		$.get(
			"addons/virtualbackend/templates/menuItem.php",
			function (data){
				$("#mainMenu").append(data)	
				$('#virtualBackenMenu').click(showVBHosts);

			}
		)
	}

}




function updateVBHost(virtualHost){
	conf={
		hostAddress: $("#vbHostAddress").val()
	}
	showWait();
	$.ajax({
		  url: "addons/virtualbackend/hosts/" + virtualHost,
		  dataType: 'json',
		  type:'POST',
		  data: conf,
		  success: showVBHosts,
		  error: displayErrorV2
		});
}









//Triggers addLEButton where dom object with id=tabb-SSL is available
addonAddGUIHook("#mainMenu", addVirtualBackendMenu);
addonAddGUIHook("#backEndEndPoint", addVirtualBackendToService);

//Add OSA-VirtualBackend API doucmentation menu item
addonAddDocURI("virtualbackend", "doc/");


#!/bin/bash
##--------------------------------------------------------
 # Module Name : OSA-VirtualBackend
 # Version : 1.0.0
 #
 #
 # Copyright (c) 2017 Zorglub42
 # This software is distributed under the Apache 2 license
 # <http://www.apache.org/licenses/LICENSE-2.0.html>
 #
 #--------------------------------------------------------
 # File Name   : bin/install.sh
 #
 # Created     : 2018-04
 # Authors     : zorglub42 <contact(at)zorglub42.fr>
 #
 # Description :
 #      OSA-VirtualBackend installer
 #--------------------------------------------------------
 # History     :
 # 1.0.0 - 2017-04-05 : Release of the file
##
######################################################################
# changeProperty
######################################################################
# Change the value of a particular propertie in a properties file
#	$1: file
#	$2: property name
#   $3: property value
######################################################################
function changeProperty(){
	PROP=`echo $2| sed 's/\./\\\./g'`
	PROP_VALUE=`echo $3| sed 's/\./\\\./g'`
	
	egrep ".*define.*$PROP.,.*" $1 > /dev/null
	if [ $? -eq 0 ] ; then
		sed -i 's|^\(.*\)define("'$PROP'",.*|\1define("'$PROP'", '$PROP_VALUE');|g' $1
	else
		echo "Property $2 not found in $1"
	fi
}

[ ! -f /etc/ApplianceManager/Settings.ini.php ] && echo "It seems that there's not OSA here..... exiting....." && exit 1


cd `dirname $0`
INSTALL_DIR=`pwd|sed 's/\/bin//'` 
OSA_INSTALL_DIR=`grep '"runtimeApplianceConfigScript"' /etc/ApplianceManager/Settings.ini.php |awk -F '"' '{print $4}'  | sed 's|/RunTimeAppliance/shell/doAppliance.sh||'`
[ ! -d $OSA_INSTALL_DIR -o ! -d $OSA_INSTALL_DIR/ApplianceManager.php -o ! -d $OSA_INSTALL_DIR/ApplianceManager.php/addons -o ! -d $OSA_INSTALL_DIR/RunTimeAppliance  ] && echo "OSA Not found at $OSA_INSTALL_DIR" && exit 1


#Configure general settings
changeProperty $INSTALL_DIR/web/include/Settings.php OSA_VB_INSTALL_DIR '"'$INSTALL_DIR'"'
changeProperty $INSTALL_DIR/web/include/Settings.php OSA_INSTALL_DIR '"'$OSA_INSTALL_DIR'"'




#Configure OSA to use ths addon
[ -L $OSA_INSTALL_DIR/ApplianceManager.php/addons/virtualbackend ] && rm $OSA_INSTALL_DIR/ApplianceManager.php/addons/virtualbackend
ln -s $INSTALL_DIR/web $OSA_INSTALL_DIR/ApplianceManager.php/addons/virtualbackend
chmod 777 $INSTALL_DIR/data


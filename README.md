# OSA-Virtualbackend
Addons for Open Services Access (OSA)

OSA-Virtualbackend is an addon for OSA (https://github.com/zorglub42/OSA) to update backend points of one or many services by using a kingd of virtual host (including port).

It allow to update only the domain part (i.e host[:port]) of backend url of one or many publish services by linking them to a virtual backend host.

This feature is available from services propertie form and with a dedicated item in the main menu.

As results, with a single HTTP POST on VirtualBackend API, you can update and deploy the configuration of backend endpoint of many services.

This functionnaly is particulary usefull when your backend are running with docker with dynamic IPs:
- start your container and get it's IP
- call OSA-VirtualBackend API to update in one shop all published service on this container
- enjoy

##Install
Install scripts are developped for debian, but, with few changes, should be compliant with RedHat too...


**IMPORTANT NOTE:** To have OSA-Virtualbackend working properly on your box, it must satisfy the following pre-requisites.
  - OSA Installed and running


Installation process:
  - connect as root
  - goto to wished install dir (Ex.) 

		Ex:
	    		cd /usr/local/src

  - clone git repo

		git clone https://github.com/zorglub42/OSA-VirtualBackend
  - Go to OSA-VirtualBackend/bin folder
  
		cd OSA-VirtualBackend/bin

Then, run the installer  

		./install.sh
		
Congratulations! 
You may now use OSA-VirtualBackend addon from OSA GUI.

## Update
To deploy a new version of OSA-VirtualBackend addon from github do the following
  - connect as root
  - goto to install dir 
	
		Ex:
			cd /usr/local/src/OSA-VirtualBackend
			./bin/update.sh

Enjoy!


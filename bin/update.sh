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
 # File Name   : install.sh
 #
 # Created     : 2018-04
 # Authors     : zorglub42 <contact(at)zorglub42.fr>
 #
 # Description :
 #      OSA-VirtualBackend updater
 #--------------------------------------------------------
 # History     :
 # 1.0.0 - 2017-04-05 : Release of the file
##


cd `dirname $0`
git reset --hard
git pull
./install.sh

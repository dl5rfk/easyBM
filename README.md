# easyBM

#What is easyBM ?
It is our goal to allow every hamradio operator setting up a personal DVMega hotspot within shortest time, by applying this easy to install SD-Card image. So using digital voice communications is easily accomplished.
The main focus is to build a SD-Image for the Raspberry Pi Hardware combined with the DVMega shield. Some of our scripts can be also used by an ordinary MMDVM-Repeater Setup, as well. 

## The Idea
A SD-Image including a dashboard ( like MMDVMHost-Dashboard by DG9VH) and a web interface is everything you need to setup a DVMega Hotspot. Therefore you need an Raspberry RPi who is connected to your local network and can be reached via the DHCP-assigned IP address. Of course, the ip-adresse must first be determined with the help of your internet-router.

## How to install ?
Your can use  our prebuild SD-Card image. You can find it at our german website [http://www.bm262.de](http://www.bm262.de)
But, if you think it is a good idea to build it step-by-step, you can clone from the repo.  

### Requirements
* Raspbian Image [https://www.raspberrypi.org/downloads/raspbian/](Download page)
* git
* Linux basic skills
* And all together  up and running for the next step.

### Installation
Go to the Website [https://www.raspberrypi.org/downloads/raspbian/] and download the debian jessie light image for Raspberry Pi. Then, windows user can use the Software Rufus to transfer the image to a new blank SD-Card and create a bootable SD-Card.

On a fresh and clean Raspberry Pi Debian Jessi light installation goto the directory /opt and clone the repository from github. 
Login into the Raspberry with the default password "raspberry" and do the following steps:

	sudo su - 
	# do the following steps as user root, you can use the command sudo  
	apt install git 
	cd /opt
	git clone https://github.com/dl5rfk/easyBM.git
	cd /opt/easyBM/
	chmod 755 /opt/easyBM/easyBM-install.sh
	/opt/easyBM/easyBM-install.sh
	# now follow the description, if everything looks good, you have a ready to use DVMega Hotspot

BUT NOTICE, the script easyBM-install.sh does mostly all the needed steps. Please be carefull, because this install script is still in development. Of course your can help to improve easyBM. 

## Additional Informations
In most parts, easyBM is a collection of software, scripts, programms, so for us it is important, that you have the possibility to get in details.

- Visit the main website for the MMDVM project at http://mmdvm.blogspot.de/ 
- Read the description of the MMDVMHost-Dashboard at https://github.com/dg9vh/MMDVMHost-Dashboard/blob/master/README.md 
- Read the ircddbgateway instructions at https://github.com/dl5di/OpenDV/blob/master/Documentation/ircDDBGateway-DEB-instructions-ENG.pdf
- Read the description of the MMDVMHost-Dashboard at https://github.com/dg9vh/MMDVMHost-Dashboard/blob/master/README.md 
DVMega 
- Read also something about the YSFGateway, maybe at https://github.com/g4klx/YSFClients 
 

## Contact
Please do not hesitiate to give us your feedback for improvements or be a part of the development. see http://www.bm262.de

## Support or Development 
For some discussion, please have a look at https://groups.yahoo.com/neo/groups/easybm/info

## Special Thanks
- A special thanks to DG9VH who has build the [MMDVMHost-Dashboard](https://github.com/dg9vh/) which was a great inspiration and example for this project.
- A special thanks to 


##Licence
Distributed under the GNU General Public License version 3 or later
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
You should have received a copy of the GNU General Public License along with this program. If not, see http://www.gnu.org/licenses/.

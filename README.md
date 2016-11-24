# easyBM

The SSD-Image includes a dashboard (MMDVMHost-Dashboard by DG9VH) and a web interface for configuration with the necessary personal data. This is done with your normal web browser, for example with your notebook. Therefore the RPi is connected with a network cable to your LAN and can be reached via the DHCP-assigned IP address.


#What is easyBM ?
It is our goal to allow every amateur radio operator setting up a personal DVMega hotspot within shortest time, by applying this easy to install image. So using digital voice communications is easily accomplished.

The main focus is to build a SSD-Image for the Raspberry Pi Hardware combined with the DVMega shield. Some of our scripts can be also used by an ordinary MMDVM-Repeater Setup, as well. 

## Contact
Please do not hesitiate to give us your feedback for improments or be a part of the development. see http://www.bm262.de


## How to install ?

First of all, please use a SD-Card image. You can find it at our german website [http://www.bm262.de](http://www.bm262.de)
But, if you think it is a good idea to build it step-by-step, you can clone from the repo.  
On a fresh and clean Raspberry Pi Debian installation goto /opt and clone the repository from github. 

### Requirements
* Raspbian jessie light Image [https://www.raspberrypi.org/downloads/raspbian/](Download page)
* git
* Linux basic skills
* An up and running Raspberry Pi with Debian Jessi Light

### Installation
Login into the Raspberry and do the following steps:

	apt install git 
	cd /opt
	git clone https://github.com/dl5rfk/easyBM.git
	cd /opt/easyBM/
	./easyBM-install-from-scratch.sh

The script easyBM-install-from-scratch.sh does mostly all needed steps. But please be carefull.

## Support or Development 
For some discussion, please have a look at https://groups.yahoo.com/neo/groups/easybm/info

##Licence
Distributed under the GNU General Public License version 3 or later
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
You should have received a copy of the GNU General Public License along with this program. If not, see http://www.gnu.org/licenses/.

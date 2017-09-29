# s42-pxe-server
S42 PXE Server - PHP based Web Interface for PXE Server based on iPXE running on CentOS 7
The Boot Menu will be provided by iPXE

## Installation
```shell
mkdir /var/www
git clone https://github.com/sysadmin42de/s42-pxe-server.git 
cd ./install
chmod+x ./install.sh
./install.sh
```
## the Future
* PHP SUPERGLOBALS will be secured
* PHP MySQL Requests will be secured
* PHP Shell Injection will be hunted down and fixed
* LDAP AD Authentication & Group Image Assignments
* MAC Based Image Auto Boot
* DB Schema will be improved
* PHP Code will be cleaned

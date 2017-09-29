#!/bin/bash
if ! [[ $(whoami) == "root" ]]; then
echo "Please run as root"
exit
fi
echo "###################################################"
echo "Configure Network"
nmtui

echo "###################################################"
echo "Install Prerequirements:"
echo "-> epel-release"
echo "-> httpd, mod_ssl"
echo "-> dnsmasq"
echo "-> mariadb, mariadb-server"
echo "-> gawk"
echo "-> sed"
echo "-> cockpit"
echo "-> php, php-mysql"
yum install epel-release -y -q
yum install httpd mod_ssl php php-mysql mariadb mariadb-server dnsmasq cockpit gawk sed -y -q

echo "###################################################"
echo "Configuring System"
echo "-> Disable SELINUX"
sed 's/enforcing/disabled/g' /etc/selinux/config -i
echo "-> Configure Firewall"
firewall-cmd --permanent --zone=public --add-service=http -q
firewall-cmd --permanent --zone=public --add-service=https -q
firewall-cmd --permanent --zone=public --add-service=tftp -q
firewall-cmd --permanent --zone=public --add-service=ssh -q
firewall-cmd --permanent --zone=public --add-service=dns -q
firewall-cmd --permanent --zone=public --add-service=dhcp -q
firewall-cmd --permanent --zone=public --add-service=cockpit -q
echo "-> Enable Services"
systemctl enable mariadb dnsmasq httpd cockpit sshd
echo "-> Starting Services"
systemctl restart mariadb dnsmasq httpd cockpit sshd
echo "-> Configure HTTPD"
chown apache:apache -R /var/www
cat ./sudoers >> /etc/sudoers
mv /etc/httpd/conf.d/welcome.conf /etc/httpd/conf.d/welcome.conf.orig -v
echo "-> Configure SSH"
ssh-keygen
touch /var/www/authorized_files
echo "-> Configure DNSMASQ"
echo "1) Operate in Standalone DHCP Mode"
echo "2) Operate in Proxy DHCP Mode"
echo "3) Operate in External DHCP Mode"
read -n 1 choice
echo ""
case $choice in
1)
echo 'port=0' > /etc/dnsmasq.d/pxe.conf
read -p "Enter Start IP: " -e ipstart
read -p "Enter End IP: " -e ipend
read -p "Enter IP Address to Listen on: " -e ip
read -p "Enter Interface Name to Listen on: " -e intname
echo "dhcp-range=$ipstart, $ipend, 1h" >> /etc/dnsmasq.d/pxe.conf
echo "dhcp-boot=pxelinux.0,´hostname´,$ip" >> /etc/dnsmasq.d/pxe.conf
echo "interface=$intname" >> /etc/dnsmasq.d/pxe.conf
echo 'pxe-service=x86PC,"Netzwerk Boot",pxelinux' >> /etc/dnsmasq.d/pxe.conf
echo "enable-tftp" >> /etc/dnsmasq.d/pxe.conf
echo 'tftp-root=/var/lib/tftpboot' >> /etc/dnsmasq.d/pxe.conf
;;
2)
echo 'port=0' > /etc/dnsmasq.d/pxe.conf
read -p "Enter Network ID: " -e netid
read -p "Enter IP Address: " -e ip
echo "dhcp-range=$netid, proxy" >> /etc/dnsmasq.d/pxe.conf
echo "dhcp-boot=pxelinux.0,$ip,$netid" >> /etc/dnsmasq.d/pxe.conf
echo 'pxe-service=x86PC,"Netzwerk Boot",pxelinux' >> /etc/dnsmasq.d/pxe.conf
echo "enable-tftp" >> /etc/dnsmasq.d/pxe.conf
echo 'tftp-root=/var/lib/tftpboot' >> /etc/dnsmasq.d/pxe.conf
;;
3)
systemctl disable dnsmasq
;;
*)
echo "ERROR: Wrong Choice entered, aborting..."
exit
;;
esac

echo "###################################################"
echo "Configure Database"
mysql_secure_installation
read -p "Database root password: " -s -e ROOTDBPW
echo ""
echo "-> Importing Database"
mysql -u root -p"$ROOTDBPW" < ./db.sql
mysql -u root -p"$ROOTDBPW" s42pxeserver -e "SHOW TABLES;"
echo "-> Creating Database User"
DBPW=$(date | md5sum)
mysql -u root -p"$ROOTDBPW" -e "CREATE USER 's42pxeserver'@'localhost' IDENTIFIED BY '$DBPW';"
mysql -u root -p"$ROOTDBPW" s42pxeserver -e "GRANT ALL PRIVILEGES ON s42pxeserver TO 's42pxeserver'@'localhost';"
mysql -u root -p"$ROOTDBPW" mysql -e "SELECT Host,User FROM user WHERE User='s42pxeserver';"
sed "s/dbpw/$DBPW/g" ../config.php -i
unset DBPW
unset ROOTDBPW

echo "###################################################"
echo "Configure S42 PXE Server"
echo "-> Web UI Access"
read -p "Your Admin Username: " -e ADMINUSER
read -p "Your Admin Password: " -s -e ADMINPW
ADMINPW=$(php -r "echo hash('sha256',$ADMINPW);")
echo ""
sed "s/admin/$ADMINUSER/g" ../config.php -i
sed "s/8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918/$ADMINPW/g" ../config.php -i
echo "-> Generating Boot Environment"
cp -R tftpboot /var/lib/
echo "-> Configure Boot Environment"
echo 'DEFAULT iPXE' > /var/lib/tftpboot/pxelinux.cfg/default
echo 'TIMEOUT 0' > /var/lib/tftpboot/pxelinux.cfg/default
echo 'MENU TITLE S42 PXE Boot Server' >> /var/lib/tftpboot/pxelinux.cfg/default
echo 'LABEL iPXE' >> /var/lib/tftpboot/pxelinux.cfg/default
echo 'MENU LABEL iPXE Boot' >> /var/lib/tftpboot/pxelinux.cfg/default
echo 'KERNEL ipxe.lkrn' >> /var/lib/tftpboot/pxelinux.cfg/default
if [ -z ${ip} ]
then 
read -p "Enter IP of this PXE Server: " -e $ip
else 
echo "APPEND dhcp && chain http://$ip/ipxe.php" >> /var/lib/tftpboot/pxelinux.cfg/default
fi

echo "Performing Reboot"
sleep 5
reboot
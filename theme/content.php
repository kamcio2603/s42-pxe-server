<?php

echo '<div class="container-fluid">';
if ($_SESSION['login'] != true) {
    if ($_GET['view'] != "help") {
        $_GET['view'] = "";
    }
}
switch ($_GET['view']) {
    case "images":
        echo '<h2>Images</h2>';
            echo '<h3><a href="?view=add&type=kernelboot"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a> Kernel Boot </h3>';
            echo '<table class="table table-hover table-condensed table-responsive">';
                echo '<tr>';
                    echo '<th></th>';
                    echo '<th>Name</th>';
                    echo '<th>Kernel</th>';
                    echo '<th>Ramdisk</th>';
                    echo '<th>Options</th>';
                echo '</tr>';
                $kernelboot = getKernelboot();
                for ($i = 0; $i < sizeof($kernelboot); $i++) {
                    echo '<tr>';
                        echo '<td>';
                            echo '<a href="?view=edit&type=kernelboot&image=' . $kernelboot[$i]['id'] . '"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a> ';
                            echo '<a href="?view=remove&type=kernelboot&image=' . $kernelboot[$i]['id'] . '"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';
                        echo '</td>';
                        echo '<td>' . $kernelboot[$i]['name'] . '</td>';
                        echo '<td>' . $kernelboot[$i]['kernel'] . '</td>';
                        echo '<td>' . $kernelboot[$i]['ramdisk'] . '</td>';
                        echo '<td>' . $kernelboot[$i]['options'] . '</td>';
                    echo '</tr>';
                }
            echo '</table>';
            echo '<h3><a href="?view=add&type=sanboot"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a> ISO (sanboot) </h3>';
            echo '<table class="table table-hover table-condensed table-responsive">';
                echo '<tr>';
                    echo '<th></th>';
                    echo '<th>Name</th>';
                    echo '<th>File</th>';
                echo '</tr>';
                $sanboot = getSanboot();
                for ($i = 0; $i < sizeof($sanboot); $i++) {
                    echo '<tr>';
                        echo '<td>';
                                echo '<a href="?view=edit&type=sanboot&image=' . $sanboot[$i]['id'] . '"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a> ';
                                echo '<a href="?view=remove&type=sanboot&image=' . $sanboot[$i]['id'] . '"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';
                        echo '</td>';
                        echo '<td>' . $sanboot[$i]['name'] . '</td>';
                        echo '<td>' . $sanboot[$i]['file'] . '</td>';
                    echo '</tr>';
                }
            echo '</table>';
            echo '<h3><a href="?view=add&type=memdiskboot"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a> ISO (memdisk) </h3>';
            echo '<table class="table table-hover table-condensed table-responsive">';
                echo '<tr>';
                    echo '<th></th>';
                    echo '<th>Name</th>';
                    echo '<th>File</th>';
                echo '</tr>';
                $memdiskboot = getMemDiskBoot();
                for ($i = 0; $i < sizeof($memdiskboot); $i++) {
                    echo '<tr>';
                        echo '<td>';
                            echo '<a href="?view=edit&type=memdiskboot&image=' . $memdiskboot[$i]['id'] . '"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a> ';
                            echo '<a href="?view=remove&type=memdiskboot&image=' . $memdiskboot[$i]['id'] . '"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';
                        echo '</td>';
                        echo '<td>' . $memdiskboot[$i]['name'] . '</td>';
                        echo '<td>' . $memdiskboot[$i]['file'] . '</td>';
                    echo '</tr>';
                    }
            echo '</table>';
            echo '<h3><a href="?view=add&type=chainload"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a> Chainloads </h3>';
            echo '<table class="table table-hover table-condensed table-responsive">';
                echo '<tr>';
                    echo '<th></th>';
                    echo '<th>Name</th>';
                    echo '<th>Server</th>';
                echo '<th>File</th>';
                echo '</tr>';
                $chainloads = getChainloads();
                for ($i = 0; $i < sizeof($chainloads); $i++) {
                    echo '<tr>';
                        echo '<td>';
                            echo '<a href="?view=edit&type=chainload&image=' . $chainloads[$i]['id'] . '"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a> ';
                            echo '<a href="?view=remove&type=chainload&image=' . $chainloads[$i]['id'] . '"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';
                        echo '</td>';
                        echo '<td>' . $chainloads[$i]['name'] . '</td>';
                        echo '<td>' . $chainloads[$i]['server'] . '</td>';
                        echo '<td>' . $chainloads[$i]['file'] . '</td>';
                    echo '</tr>';
                }
            echo '</table>';
        break;
    case "browse":
        echo '</div><iframe src="/images/index.php" frameborder="0" style="margin-top: -20px;" height="90%" width="100%"></iframe> ';
        break;
    case "config":
        echo '<h2>Configuration</h2>';
        echo '<table class="table table-hover table-condensed table-responsive">';
            echo '<tr>';
                echo '<th>Name</th>';
                echo '<th>Value</th>';
                echo '<th></th>';
            echo '</tr>';
            echo '<tr>';
                echo '<td>Hostname</td>';
                echo '<td>' . gethostname() . '</td>';
                echo '<td><a href="?view=edit&type=config&option=hostname" class="btn btn-success btn-xs" role="button">Edit</a></td>';
            echo '</tr>';
            echo '<tr>';
                echo '<td>Username</td>';
                echo '<td>' . $username . '</td>';
                echo '<td><a href="?view=edit&type=config&option=username" class="btn btn-success btn-xs" role="button">Edit</a></td>';
            echo '</tr>';
            echo '<tr>';
                echo '<td>Password</td>';
                echo '<td>';
                for ($i = 0;$i < strlen($password);$i++) {echo "*";} 
                echo '</td>';
                echo '<td><a href="?view=edit&type=config&option=password" class="btn btn-success btn-xs" role="button">Edit</a></td>';
            echo '</tr>';
            echo '<tr>';
                echo '<td>SSH Keys</td>';
                echo '<td>'. shell_exec("sudo head /root/.ssh/authorized_keys -n1") .'</td>';
                echo '<td><a href="?view=edit&type=config&option=sshkeys" class="btn btn-success btn-xs" role="button">Edit</a></td>';
            echo '</tr>';
        echo '</table>';
        break;
    case "overview":
        echo '<meta http-equiv="refresh" content="5; URL=/?view=overview">';
        echo '<h2>Overview</h2>';
        echo '<div class="row">';
        echo '<div class="col-md-6">';
        echo '<h3>Information</h3>';
        echo '<table class="table table-hover">';
        echo '<tr>';
        echo '<td>CPU</td>';
        echo '<td>' . getCPUInfo() . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>Hostname</td>';
        echo '<td>' . gethostname() . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>IP Address</td>';
        echo '<td>' . $_SERVER['SERVER_ADDR'] . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>Uptime</td>';
        echo '<td>' . getUptime() . '</td>';
        echo '</tr>';
        echo '</table>';
        echo '<h3>Services</h3>';
        echo '<table class="table table-hover">';
        echo '<tr>';
        echo '<td>' . getServiceDNSMASQ() . '</td>';
        echo '<td>dnsmasq</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>' . getServiceTFTPD() . '</td>';
        echo '<td>TFTP Server</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>' . getServiceHTTPD() . '</td>';
        echo '<td>HTTP Server</td>';
        echo '</tr>';
        echo '<td>' . getServiceMARIADB() . '</td>';
        echo '<td>MariaDB Server</td>';
        echo '</tr>';
        echo '</table>';
        echo '</div>';
        echo '<div class="col-md-6">';
        echo '<h3>System</h3>';
        echo '<table class="table table-hover">';
        echo '<tr>';
        echo '<td>CPU Load</td>';
        echo '<td>' . getCPULoad() . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>RAM Load</td>';
        echo '<td>' . getRAMLoad() . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>SWAP Load</td>';
        echo '<td>' . getSWAPLoad() . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>DISK Load</td>';
        echo '<td>' . getDISKLoad() . '</td>';
        echo '</tr>';
        echo '</table>';
        echo '</div>';
        echo '</div>';
        break;
    case "help":
        echo file_get_contents('docs/README.html');
        break;
    case "cockpit":
        echo '</div><iframe src="https://'. $_SERVER['SERVER_ADDR'] .':9090" frameborder="0" style="margin-top: -20px;" height="95%" scrolling="no" width="100%"></iframe> ';
    case "add":
        switch ($_GET['type']) {
            case 'kernelboot':
                echo '<h2>Images <small>Add Kernelboot Image</small></h2>';
                echo '
                        <form action="save.php" method="POST" enctype="multipart/form-data" class="col-md-4">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <label>Kernel</label>
                            <input type="file" class="form-control" name="kernel" required>
                        </div>
                        <div class="form-group">
                            <label>Ramdisk</label>
                            <input type="file" class="form-control" name="ramdisk" required>
                        </div>
                        <div class="form-group">
                            <label>Options</label>
                            <input type="text" class="form-control" name="options" placeholder="Options">
                        </div>
                        <input type="hidden" name="type" value="add">
                        <input type="hidden" name="imagetype" value="kernelboot">
                        <input type="submit" class="btn btn-default" value="Upload/Add">
                    </form>';
                break;
            case 'sanboot':
                echo '<h2>Images <small>Add ISO (sanboot) Image</small></h2>';
                echo '
                        <form action="save.php" method="POST" enctype="multipart/form-data" class="col-md-4">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <label>ISO</label>
                            <input type="file" class="form-control" name="iso" accept=".iso" required>
                        </div>
                        <input type="hidden" name="type" value="add">
                        <input type="hidden" name="imagetype" value="sanboot">
                        <input type="submit" class="btn btn-default" value="Upload/Add">
                    </form>';
                break;
            case 'memdiskboot':
                echo '<h2>Images <small>Add ISO (memdisk) Image</small></h2>';
                echo '
                        <form action="save.php" method="POST" enctype="multipart/form-data" class="col-md-4">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <label>ISO</label>
                            <input type="file" class="form-control" name="iso" accept=".iso" required>
                        </div>
                        <input type="hidden" name="type" value="add">
                        <input type="hidden" name="imagetype" value="memdiskboot">
                        <input type="submit" class="btn btn-default" value="Upload/Add">
                    </form>';
                break;
            case 'chainload':
                echo '<h2>Images <small>Add Chainload</small></h2>';
                echo '
                        <form action="save.php" method="POST" class="col-md-4">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <label>Server</label>
                            <input type="text" class="form-control" name="server" placeholder="0.0.0.0" required>
                        </div>
                        <div class="form-group">
                            <label>File</label>
                            <input type="text" class="form-control" name="file" placeholder="pxelinux.0" required>
                        </div>
                        <input type="hidden" name="type" value="add">
                        <input type="hidden" name="imagetype" value="chainload">
                        <input type="submit" class="btn btn-default" value="Add">
                    </form>';
                break;
        }
        break;
    case "edit":
        switch ($_GET['type']) {
            case 'config':
                switch ($_GET['option']) {
                    case "hostname":
                        echo '<h2>Configuration <small>Hostname</small></h2>';
                        echo '<div class="alert alert-danger" role="alert">System reboots after save automatically</div>';
                        echo '
							<form class="form-inline" action="save.php" method="POST">
							<input type="text" class="form-control" name="hostname" value="' . gethostname() . '">
							<input type="hidden" name="type" value="config">
							<input type="hidden" name="option" value="hostname">
							<input type="submit" value="Save" class="btn btn-default">
							</form>';
                        break;
                    case "username":
                        echo '<h2>Configuration <small>Username</small></h2>';
                        echo '
							<form class="form-inline" action="save.php" method="POST">
							<input type="text" class="form-control" name="username" value="' . $username . '">
							<input type="hidden" name="type" value="config">
							<input type="hidden" name="option" value="username">
							<input type="submit" value="Save" class="btn btn-default">
							</form>';
                        break;
                    case "password":
                        echo '<h2>Configuration <small>Password</small></h2>';
                        echo '
							<form class="form-inline" action="save.php" method="POST">
							<input type="password" class="form-control" name="password">
							<input type="hidden" name="type" value="config">
							<input type="hidden" name="option" value="password">
							<input type="submit" value="Save" class="btn btn-default">
							</form>';
                        break;
                    case "sshkeys":
                        echo '<h2>Configuration <small>SSH Keys</small></h2>';
                        echo '
							<form class="form-inline" action="save.php" method="POST">
							<textarea class="form-control" cols="250" rows="15"  name="sshkeys">'. shell_exec("sudo cat /root/.ssh/authorized_keys") .'</textarea><br />
							<input type="hidden" name="type" value="config">
							<input type="hidden" name="option" value="sshkeys">
							<input type="submit" value="Save" class="btn btn-default">
							</form>';
                        break;
                }
                break;
            case 'kernelboot':
                $kernelboot = queryDB("SELECT * FROM kernelboot WHERE id = '" . $_GET['image'] . "';");
                echo '<h2>Images <small>Edit Kernelboot Image</small></h2>';
                echo '
                        <form action="save.php" method="POST" class="col-md-4">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="' . $kernelboot['name'] . '">
                        </div>
                        <div class="form-group">
                            <label>Options</label>
                            <input type="text" class="form-control" name="options" value="' . $kernelboot['options'] . '">
                        </div>
                        <input type="hidden" name="type" value="edit">
                        <input type="hidden" name="imagetype" value="kernelboot">
                        <input type="hidden" name="image" value="' . $_GET['image'] . '">
                        <input type="submit" class="btn btn-default" value="Save">
                    </form>';
                break;
            case 'sanboot':
                $sanboot = queryDB("SELECT * FROM sanboot WHERE id = '" . $_GET['image'] . "';");
                echo '<h2>Images <small>Edit ISO (sanboot) Image</small></h2>';
                echo '
                        <form action="save.php" method="POST" class="col-md-4">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="' . $sanboot['name'] . '">
                        </div>
                        <input type="hidden" name="type" value="edit">
                        <input type="hidden" name="imagetype" value="sanboot">
                        <input type="hidden" name="image" value="' . $_GET['image'] . '">
                        <input type="submit" class="btn btn-default" value="Save">
                    </form>';
                break;
            case 'memdiskboot':
                $memdiskboot = queryDB("SELECT * FROM memdiskboot WHERE id = '" . $_GET['image'] . "';");
                echo '<h2>Images <small>Edit ISO (memdisk) Image</small></h2>';
                echo '
                        <form action="save.php" method="POST" class="col-md-4">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="' . $memdiskboot['name'] . '">
                        </div>
                        <input type="hidden" name="type" value="edit">
                        <input type="hidden" name="imagetype" value="memdiskboot">
                        <input type="hidden" name="image" value="' . $_GET['image'] . '">
                        <input type="submit" class="btn btn-default" value="Save">
                    </form>';
                break;
            case 'chainload':
                $chainload = queryDB("SELECT * FROM chainloads WHERE id = '" . $_GET['image'] . "';");
                echo '<h2>Images <small>Edit Chainload</small></h2>';
                echo '
                        <form action="save.php" method="POST" class="col-md-4">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="' . $chainload['name'] . '">
                        </div>
                        <div class="form-group">
                            <label>Server</label>
                            <input type="text" class="form-control" name="server" value="' . $chainload['server'] . '">
                        </div>
                        <div class="form-group">
                            <label>File</label>
                            <input type="text" class="form-control" name="file" value="' . $chainload['file'] . '">
                        </div>
                        <input type="hidden" name="type" value="edit">
                        <input type="hidden" name="imagetype" value="chainload">
                        <input type="hidden" name="image" value="' . $_GET['image'] . '">
                        <input type="submit" class="btn btn-default" value="Save">
                    </form>';
                break;
        }

        break;
    case "remove":
        switch ($_GET['type']) {
            case "kernelboot":
                $kernelboot = queryDB("SELECT * FROM kernelboot WHERE id = '" . $_GET['image'] . "';");
                shell_exec("rm -rf /var/www/html/images/kernelboot/" . $kernelboot['name']);
                queryDB("DELETE FROM kernelboot WHERE id = '" . $_GET['image'] . "';");
                break;
            case "sanboot":
                $sanboot = queryDB("SELECT * FROM sanboot WHERE id = '" . $_GET['image'] . "';");
                shell_exec("rm /var/www/html/images/iso/" . $sanboot['file']);
                queryDB("DELETE FROM sanboot WHERE id = '" . $_GET['image'] . "';");
                break;
            case "memdiskboot":
                $memdiskboot = queryDB("SELECT * FROM memdiskboot WHERE id = '" . $_GET['image'] . "';");
                shell_exec("rm /var/www/html/images/iso/" . $memdiskboot['file']);
                queryDB("DELETE FROM memdiskboot WHERE id = '" . $_GET['image'] . "';");
                break;
            case "chainload":
                $chainload = queryDB("SELECT * FROM chainload WHERE id = '" . $_GET['image'] . "';");
                queryDB("DELETE FROM chainloads WHERE id = '" . $_GET['image'] . "';");
                break;
        }
        echo '<meta http-equiv="refresh" content="0; URL=/?view=images">';
        break;
    case "system":
        switch ($_GET['action']) {
            case "reboot":
                $_SESSION['login'] = false;
                echo '<div class="alert alert-danger" role="alert">System is rebooting in a minute...</div>';
                shell_exec("sudo shutdown -r +1");
                echo '<meta http-equiv="refresh" content="10; URL=/?">';
                break;
            case "shutdown":
                $_SESSION['login'] = false;
                echo'<div class="alert alert-danger" role="alert">System is powering off in a minute...</div>';
                shell_exec("sudo shutdown -h +1");
                echo '<meta http-equiv="refresh" content="10; URL=/?">';
                break;
            case "start-dnsmasq":
                echo'<div class="alert alert-warning" role="warning">Starting DNSMASQ Service...</div>';
                shell_exec("sudo systemctl start dnsmasq");
                echo '<meta http-equiv="refresh" content="5; URL=/?view=overview">';
                break;
            case "stop-dnsmasq":
                echo'<div class="alert alert-warning" role="warning">Stopping DNSMASQ Service...</div>';
                shell_exec("sudo systemctl stop dnsmasq");
                echo '<meta http-equiv="refresh" content="5; URL=/?view=overview">';
                break;
            case "start-tftp":
                echo'<div class="alert alert-warning" role="warning">Starting TFTP Service...</div>';
                shell_exec("sudo systemctl start dnsmasq");
                echo '<meta http-equiv="refresh" content="5; URL=/?view=overview">';
                break;
            case "stop-tftp":
                echo'<div class="alert alert-warning" role="warning">Stopping TFTP Service...</div>';
                shell_exec("sudo systemctl stop dnsmasq");
                echo '<meta http-equiv="refresh" content="5; URL=/?view=overview">';
                break;
            case "start-httpd":
                echo'<div class="alert alert-warning" role="warning">Starting HTTPD Service...</div>';
                shell_exec("sudo systemctl start httpd");
                echo '<meta http-equiv="refresh" content="5; URL=/?view=overview">';
                break;
            case "stop-httpd":
                echo'<div class="alert alert-warning" role="warning">Stopping HTTPD Service...</div>';
                shell_exec("sudo systemctl stop httpd");
                echo '<meta http-equiv="refresh" content="5; URL=/?view=overview">';
                break;
            case "start-db":
                echo'<div class="alert alert-warning" role="warning">Starting MariaDB Service...</div>';
                shell_exec("sudo systemctl start mariadb");
                echo '<meta http-equiv="refresh" content="5; URL=/?view=overview">';
                break;
            case "stop-db":
                echo'<div class="alert alert-warning" role="warning">Stopping MariaDB Service...</div>';
                shell_exec("sudo systemctl stop mariadb");
                echo '<meta http-equiv="refresh" content="5; URL=/?view=overview">';
                break;
            case "logout":
                $_SESSION['login'] = false;
                echo '<meta http-equiv="refresh" content="0; URL=/?">';
                break;
        }
        break;
    case "":
        if ($_SESSION['login'] == true) {
            echo '<meta http-equiv="refresh" content="0; URL=/?view=overview">';
        }
        echo '
	<div class="col-md-4 col-md-offset-4">
	<div class="jumbotron">';
        #<img src="theme/img/logo.png" width="250px" align="center">
        echo'<h2>Login to PXE Server</h2>
	<form action="login.php" method="POST">
	<div class="form-group">
    <label>Username</label>
    <input type="text" class="form-control" name="username" id="username" placeholder="Username">
	</div>
	<div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
	</div>
	<input type="submit" class="btn btn-default">
	</form>
	</div>
	</div>
	';
        break;
}

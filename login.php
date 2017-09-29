<?php
session_start();
require './config.php';
if ($_POST['username'] == $username and hash('sha256',$_POST['password']) == $password) {
	$_SESSION['login'] = true;
	echo '<meta http-equiv="refresh" content="0; URL=/?view=overview">';
} else {
	echo '<meta http-equiv="refresh" content="0; URL=/?">';
}
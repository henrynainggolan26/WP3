<?php
session_start();
	unset($_SESSION['username']);
	unset($_SESSION['password']);
	unset($_SESSION['id_user']);
session_destroy();
?>
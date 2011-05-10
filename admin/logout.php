<?php
session_start();
	unset($_SESSION['Logedin']);
	session_destroy();
?>
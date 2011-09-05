<?php

require 'Mysql.php';
require_once 'classes/class.db.php';
$db = new MySQL(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME, false);

class Membership {
	
	function validate_user($un, $pwd) {
	global $db;
		$mysql = New Mysql2();
		$ensure_credentials = $mysql->verify_Username_and_Pass($un, md5($pwd));
		$roli = mysql_fetch_array($db->query("SELECT * FROM users WHERE username='$un' LIMIT 1"));
		
		if($ensure_credentials) {
			$_SESSION['status'] = 'authorized';
			$_SESSION['username'] = $un;
			$_SESSION['roli'] = $roli['status'];
			setcookie('lang','sq');
			header("location: index.php");
		} else return "Ju lutem shënoni Pseudonim dhe fjalëkalim të saktë!";
		
	} 
	
	function log_User_Out() {
		if(isset($_SESSION['status'])) {
			unset($_SESSION['status']);
			
			if(isset($_COOKIE[session_name()])) 
				setcookie(session_name(), '', time() - 1000);
				session_destroy();
		}
	}
	
	function confirm_Member() {
		session_start();
		if($_SESSION['status'] !='authorized') header("location: login.php");
	}
	
}
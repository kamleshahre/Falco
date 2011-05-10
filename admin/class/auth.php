<?php session_start();
/*
global $db;
$username = $_POST['username'];
$password = $_POST['password'];
		$row = $db->query("SELECT username, password FROM users WHERE username = '$username' AND password = '$password'");
		
		while ($rows = mysql_fetch_array($row)) {
			if($username == $rows['username'] && $password == $rows['password']) {
			 $_SESSION['Logedin'] == true;
			 header("Location: index.php");
			}else{
				echo 'Neh';
			};
		}
*/

class auth {


function login_form() {
	return <<<BFX
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Paneli Administratues | Hyrja</title>
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
<link href="css/login.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
/* <![CDATA[ */
	$(document).ready(function(){
			$(".block").fadeIn(1000);				   
			$(".idea").fadeIn(1000);
			$('.idea').supersleight();
			$('#username').example('Username');	
			$('#password').example('Password');
	});
/* ]]> */
</script>
</head>

<body>
    <div id="wrap">
<div class="block">
            <form action="index.php" method="post">
            <div class="left"></div>
            <div class="right">
                <div class="div-row">

                	<input type="text" id="username" name="username"  onfocus="this.value='';" onblur="if (this.value=='') {this.value='Username';}" value="Username" />
                                    </div>
                <div class="div-row">
                     <input type="password" id="password" name="password" onfocus="this.value='';" onblur="if (this.value=='') {this.value='************';}" value="************" />
                </div>
                <div class="rm-row">
                    <!-- ktu eshte dashur te jet REMEMBER ME  -->
                </div>

                <div class="send-row">
                    <button id="login" value="" type="submit" name="submit"></button>
                </div>
                            </div>
            </form>
        </div>                
    </div>
</body>
</html>
BFX;
}

function do_login($username, $password) {
global $db;
		$row = $db->query("SELECT username, password FROM users WHERE username = '$username' AND password = '$password'");
		
		while ($rows = mysql_fetch_array($row)) {
			if($username == $rows['username'] && $password == $rows['password']) {
				$_SESSION['Logedin'] == true;
			 '<script type="text/javascript">
				window.location.href=\'index.php\';</script>';
			}else{
				echo 'Neh';
			};
		}
}

}//endof auth

?>
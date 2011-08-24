<?php
session_start();
require_once 'classes/Membership.php';
$membership = new Membership();

// If the user clicks the "Log Out" link on the index page.
if(isset($_GET['status']) && $_GET['status'] == 'loggedout') {
	$membership->log_User_Out();
}

// Did the user enter a password/username and click submit?
if($_POST && !empty($_POST['username']) && !empty($_POST['pwd'])) {
	$response = $membership->validate_User($_POST['username'], $_POST['pwd']);
}
														

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo WEB_NAME.':'; ?> Hyrja</title>
<LINK REL="SHORTCUT ICON" HREF="favicon.png">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
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
            <form action="" method="post">
            <div class="left"></div>
            <div class="right">
                <div class="div-row">

                	<input type="text" id="username" name="username"  onfocus="this.value='';" onblur="if (this.value=='') {this.value='Pseudonimi';}" value="Pseudonimi" />
                                    </div>
                <div class="div-row">
                     <input type="password" id="password" name="pwd" onfocus="this.value='';" onblur="if (this.value=='') {this.value='************';}" value="************" />
                </div>
                <div class="rm-row">
                    <!-- ktu eshte dashur te jet REMEMBER ME  -->
                </div>

                <div class="send-row">
                    <button id="login" value="" type="submit" name="login"></button>
                </div>
                            </div>
            </form>
            <?php if(isset($response)) echo "<h4 class='alert'>" . $response . "</h4>"; ?>
        </div>                
    </div>
    
</body>
</html>
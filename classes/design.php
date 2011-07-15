<?php

class HTML{

	
public function header() {
global $control;
	return '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<LINK REL="SHORTCUT ICON" HREF="favicon.png">
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="css/calendar.css">
<script language="JavaScript" src="js/calendar_db.js"></script>
<script language="JavaScript">
function toggleVisibility(id,visible) {
	document.getElementById(id).style.visibility=(visible)?"visible":"hidden";
}
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
     			$(\'#disable_form input[type=submit]\', this).attr(\'disabled\', \'disabled\');
				$(\'.lightbox\').click(function(){
					$(\'.backdrop, .box\').animate({\'opacity\':\'.50\'}, 300, \'linear\');
					$(\'.box\').animate({\'opacity\':\'1.00\'}, 300, \'linear\');
					$(\'.backdrop, .box\').css(\'display\', \'block\');
				});
				
				$(\'.close\').click(function(){
					close_box();
				});
 
				$(\'.backdrop\').click(function(){
					close_box();
				});
				
				$("#firstpane p.menu_head").click(function(){
    				$(this).next("div.menu_body").slideToggle(300).siblings("div.menu_body").slideUp("slow");
    				$(this).siblings();
				});
			});
 
			function close_box()
			{
				$(\'.backdrop, .box\').animate({\'opacity\':\'0\'}, 300, \'linear\', function(){
					$(\'.backdrop, .box\').css(\'display\', \'none\');
				});
			}
</script>
<script language="javascript" type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
    }
	
	function getState(countryId) {		
		
		var strURL="findState.php?country="+countryId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById(\'statediv\').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
</script>
<title>'.WEB_NAME.' | Paneli administrues</title>
</head>
<body>
<div id="wrapper">
	<div id="header">
	<div class="BigLogo"></div>
		<div class="logoWrapper">
			<img class="logo" src="css/images/logo.png" alt="Falco System" />
			<p class="slogan">Administrimi i rezervimeve ...</p>
		</div>
		<div class="RightSettingsWrapper">
			<p class="Welcome">Mirësevini <strong>'.ucfirst($_SESSION['username']).'</strong></p>
			<a class="shutdown" href="login.php?status=loggedout"><img style="border:0;" src="css/images/shutdown.png" /></a>
		</div>
		<div class="topNavigation">
		'.funksionet::menu_for_reservations().'
		</div>
	</div>
	
';
}

public function LeftSide() {
return funksionet::left_menu();
}

public function RightSide() {
global $control;
	
return '
<div id="rightside">
'.$control->menu_switcher().'
<div class="footeri">
	<div class="RightFooter">Copyright '.date("Y").' © Falco System</div>
</div>
</div>
';	
}

public function footer() {
return '
</div><!--end wrapper-->

</body>
</html>
';	
	
}
	
}//endof HTML

?>
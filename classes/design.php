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
			<p class="Welcome">Mirėsevini <strong>'.ucfirst($_SESSION['username']).'</strong></p>
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
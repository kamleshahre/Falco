<?php

class HTML{

	
public function header() {
global $control;
	return '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="css/calendar.css">
<script language="JavaScript" src="js/calendar_db.js"></script>
<script language="JavaScript">
function toggleVisibility(id,visible) {
	document.getElementById(id).style.visibility=(visible)?"visible":"hidden";
}
</script>
<script type="text/javascript">
function showUser(str)
{
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","classes/ajaxed/reservation_functions.php?q="+str,true);
xmlhttp.send();
}
</script>
<title>'.WEB_NAME.' | Paneli administrues</title>
</head>
<body>
<div id="wrapper">
	<div id="header">
		<div class="logoWrapper">
			<img class="logo" src="css/images/logo.png" alt="Falco System" />
			<p class="slogan">Administrimi i rezervimeve ...</p>
		</div>
		<div class="RightSettingsWrapper">
			<p class="Welcome">Mirësevini <strong>'.ucfirst($_SESSION['username']).'</strong></p>
			<a class="shutdown" href="login.php?status=loggedout"><img style="border:0;" src="css/images/shutdown.png" /></a>
		</div>
		<div class="topNavigation">
		'.$control->TopMenu().'
		</div>
	</div>
	
';
}

public function LeftSide() {
return '
<div id="leftside">
	<a  class="menu_links" href="index.php?menu=rezervimet&submenu=rezervo"><p class="menus">Rezervimet</p></a>
	<a  class="menu_links" href="index.php?menu=agjentet"><p class="menus">Agjentët</p></a>
	<a  class="menu_links" href="index.php?menu=destinacionet"><p class="menus">Destinacionet</p></a>
</div><!-- endof leftside -->
';
}

public function RightSide() {
global $control;
	
return '
<div id="rightside">
'.$control->menu_switcher().'
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



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

<link rel="stylesheet" href="css/style.css" />

<link rel="stylesheet" href="css/calendar.css">

<script language="JavaScript" src="js/calendar_db.js"></script>

<script language="javascript">

function toggleVisibility(id,visible) {

    //document.getElementById(id).style.color=(white)?"white":"#c1c1c1";

}

window.onload = setActive;

	function setActive() {

  aObj = document.getElementById("ca").getElementsByTagName("a");

  for(i=0;i<aObj.length;i++) {

    if(document.location.href.indexOf(aObj[i].href)>=0) {

      aObj[i].className="topNavigationLinksA";

    }

  }

}

</script>

<title>FALCO | Paneli administrues</title>

</head>

<body>

<div id="wrapper">

	<div id="header">

		<div class="logoWrapper">

			<img class="logo" src="css/images/logo.png" alt="Falco System" />

			<p class="slogan">Administrimi i rezervimeve ...</p>

		</div>

		<div class="RightSettingsWrapper">

			<p class="Welcome">Mirësevini <strong>Admin</strong></p>

			<a class="shutdown" href="login.php?status=loggedout"><img style="border:0;" src="css/images/shutdown.png" /></a>

		</div>

		<div class="topNavigation" id="ca">

			<a  class="topNavigationLinks" href="index1.php">Rezervo</a>

			<a  class="topNavigationLinks" href="index2.php">test</a>

			<a  class="topNavigationLinks" href="index.php?menu=rezervimet&submenu=rezervo">test11</a>

		</div>

	</div>

	



<div id="leftside">
	
	<span style='width: 199px;height: 42px;color:#000000;border-bottom:1px solid #CECECE;border-right:1px solid #cecece;float:left;text-decoration: none;background-color:#cecece'><p class="menus"><b>Options</b></p></span>
	<a  class="menu_links" href="index.php?menu=rezervimet"><p class="menus">Rezervimet</p></a>

	<a class="menu_links" href="index.php?menu=agjentet"><p class="menus">Agjentët</p></a>

	<a class="menu_links" href="index.php?menu=destinacionet"><p class="menus">Destinacionet</p></a>

</div><!-- endof leftside -->



<div id="rightside">

rezervo

</div>



</div><!--end wrapper-->



</body>

</html>


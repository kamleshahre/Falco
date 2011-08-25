<?php
header('Content-Type: text/html; charset=ISO-8859-1');
//// Here below we its all about errors and how we handle them
error_reporting (E_ALL ^E_NOTICE);
//require_once 'classes/errors_handler.php';
//set_error_handler('handle_errors');
////////////////////////////////////////////////////////////////////////////////////////////////////////////
$page = $_GET['menu'];
$subpage = $_GET['submenu'];
$lang = stripslashes($_GET['language']); 
////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Here we check which langauge the user chosed
	if ($lang == 'sq') {
		setcookie("lang","sq");
	}
	elseif ($lang == 'en') {
		setcookie("lang","en");
	}
	elseif ($lang == 'mk') {
		setcookie("lang","mk");
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_SESSION['username'])) $perdorues = $_SESSION['username'];
//// Here we decide which sub page to be active the first time when we click on the page in the left 
if(empty($page) && empty($subpage)){
	if (LANG == 'sq') {
	header("Location: index.php?menu=rezervimet&submenu=rezervo");
	} elseif (LANG == 'en') {
	header("Location: index.php?menu=rezervimet&submenu=book");	
	}
}elseif($page == 'perdoruesit' && empty($subpage)){
	header("Location: index.php?menu=perdoruesit&submenu=agjentet");
}elseif($page == 'rezervimet' && empty($subpage)){
	header("Location: index.php?menu=rezervimet&submenu=rezervo");
}elseif($page == 'menaxhment' && empty($subpage)){
	header("Location: index.php?menu=menaxhment&submenu=destinacionet");
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
require_once 'classes/Membership.php';
$membership = New Membership();
$membership->confirm_Member();

//echo '<strong>'.$_SESSION['roli'].'</strong>'; //here I check if we are agent or admin
require_once 'classes/design.php';
$design = new HTML();
require_once 'classes/functions.php';
require_once 'classes/class.help.php';
require_once 'classes/controller.php';
$control = new controller();

require_once 'classes/class.db.php';
$db = new MySQL(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME, false);



echo $design->header();
echo '<div id="contentWrapper">'.$design->LeftSide().$design->RightSide().'</div>';
echo $design->footer();

?>
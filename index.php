<?php
header('Content-Type: text/html; charset=ISO-8859-1');
//error_reporting (E_ALL ^ E_NOTICE);
//ini_set('error_log','error_history.log'); //here we set the file where the errors should be loged
$page = $_GET['menu'];
$subpage = $_GET['submenu'];
//$act = $_GET['action']; 
if(isset($_SESSION['username'])) $perdorues = $_SESSION['username'];

//// Here we decide which sub page to be active the first time when we click on the page in the left //////
if(empty($page) && empty($subpage))
	header("Location: index.php?menu=rezervimet&submenu=rezervo");
elseif($page == 'perdoruesit' && empty($subpage))
	header("Location: index.php?menu=perdoruesit&submenu=agjentet");
elseif($page == 'rezervimet' && empty($subpage))
	header("Location: index.php?menu=rezervimet&submenu=rezervo");
elseif($page == 'menaxhment' && empty($subpage))
	header("Location: index.php?menu=menaxhment&submenu=destinacionet");
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
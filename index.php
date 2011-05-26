<?php

$page = $_GET['menu'];
$subpage = $_GET['submenu'];
$act = $_GET['action']; 

if(empty($page) && empty($subpage))
	header("Location: index.php?menu=rezervimet&submenu=rezervo");
elseif($page == 'perdoruesit' && empty($subpage))
	header("Location: index.php?menu=perdoruesit&submenu=agjentet");
elseif($page == 'rezervimet' && empty($subpage))
	header("Location: index.php?menu=rezervimet&submenu=rezervo");


//$page = 'rezervimet' && $subpage = 'rezervo';
	
require_once 'classes/Membership.php';
$membership = New Membership();
$membership->confirm_Member();


require_once 'classes/design.php';
$design = new HTML();
require_once 'classes/functions.php';
require_once 'classes/controller.php';
$control = new controller();

require_once 'classes/class.db.php';
$db = new MySQL(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME, false);



echo $design->header();
echo $design->LeftSide();
echo $design->RightSide();
echo $design->footer();
?>
<?php

require_once 'classes/Membership.php';
$membership = New Membership();
$membership->confirm_Member();


require_once 'classes/design.php';
$design = new HTML();

require_once 'classes/controller.php';
$control = new controller();

$page = $_GET['menu'];
$subpage = $_GET['submenu'];
$act = $_GET['action'];

echo $design->header();
echo $design->LeftSide();
echo $design->RightSide();
echo $design->footer();
?>
<?php
$page = $_GET['page'];
$action = $_GET['act'];
$id = $_GET['id'];
$sid = $_GET['sid'];
(empty($page)) ? $page = 'dashboard' : ''; //when user opens for the first time the page DASHBOARD is going to be first opened

require_once 'config/setup.php';
require_once 'class/design.class.php';
require_once 'class/controllers.class.php';
require_once 'class/class.db.php';
$db = new MySQL(DB_HOST, DB_USER, DB_PASS, DB_NAME, false);
$design = new HTML();

echo $design->head();
echo $design->LeftSide();
echo $design->RightSideTop();
echo $design->RightSide();
echo $design->footer();

?>
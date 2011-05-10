<?php 
session_start();
require_once 'config/setup.php';
require_once 'class/class.db.php';
$db = new MySQL(DB_HOST, DB_USER, DB_PASS, DB_NAME, false);
require_once 'class/auth.php';
$auth = new auth();

if($_SESSION['Logedin'] == false && !isset($_POST['submit'])) {
 echo $auth->login_form();
 exit();
} elseif(isset($_POST['submit'])){
	return $auth->do_login($_POST['username'], $_POST['password']);
} elseif($_SESSION['Logedin'] == true) {


$page = $_GET['page'];
$action = $_GET['act'];
$id = $_GET['id'];
$sid = $_GET['sid'];
(empty($page)) ? $page = 'dashboard' : ''; //when user opens for the first time the page DASHBOARD is going to be first opened


//here goes the design
require_once 'class/design.class.php';
require_once  'class/controllers.class.php';
$design = new HTML();

echo $design->head();
echo $design->LeftSide();
echo $design->RightSideTop();
echo $design->RightSide();
echo $design->footer();

}
?>
<?php
$delete = $_GET['q'];
require_once '../class.db.php';
$db = new MySQL('localhost', 'root', 'test', 'falco_db', false);

$db->query("DELETE FROM orders WHERE order_id = $delete;") or die(mysql_error());
echo 'DONE';
?>
<?php 

$country = $_GET['country'];
$link = mysql_connect('localhost', 'root', 'test'); //changet the configuration in required
if (!$link) {
    die('Could not connect: ' . mysql_error("1"));
}
mysql_select_db('falco_db');
$query="SELECT * FROM costs WHERE prej = '$country';";
$result=mysql_query($query) or die("2");
?>
<select class="selectDest" name="Deri">
 <option></option>
  <?php while($row = mysql_fetch_array($result)) { 
  	print'<option>'.$row['deri'].'</option>';
  	 
  }
 ?>
</select>
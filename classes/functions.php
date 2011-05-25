<?php
class funksionet {

public function TopMenu() {
	global $page, $subpage;
$topNavigation = array('Rezervo','Listat','Ndihmë');

	foreach ($topNavigation as $row) {
		if(funksionet::SpecialcharsCleaner($row) == ucfirst($_GET['submenu']))
			$css = 'topNavigationCurrent';
		else 	
			$css = 'topNavigationLinks'; 
			
		$topnavi.= '<a  class="'.$css.'" href="index.php?menu=rezervimet&submenu='.funksionet::SpecialcharsCleaner(strtolower($row)).'">'.$row.'</a>';
	}	
	return $topnavi;
}			
	
//here we select the direction accoring to the numbers 1 (this is for the cities from here) or 2 (this is for the cities abroad)
function directions($direction) {
	global $db;
	$query = $db->query("SELECT * FROM destinations WHERE direction = $direction");
	while($row = mysql_fetch_array($query)){
	$city .= '<option>'.$row['name'].'</option>';
	}
	return $city;
}	
	
//here we format the date from db format to human readable format	
function formato_daten($data) {
	
	$data = explode('-', $data);
	return $data[2].'.'.$data[1].'.'.$data[0];
}


//here we format all the manual made errors
function show_error($message) {
	return '<div class="ErrorWrapper">'.$message.'</div>';
}


//This is the BACK button
function back() {
	return '
	<FORM><INPUT TYPE="BUTTON" VALUE="Go Back" ONCLICK="history.go(-1)"></FORM>';
}


//here are the functions for the reservations
function list_actions($id,$value='',$name='',$date='') {
return '
	<form action="" method="POST">
<input type="hidden" name="date" value="'.$date.'">
<input type="hidden" name="id" value="'.$id.'">
<input type="hidden" name="action" value="'.$value.'">
<input type="submit" value="'.$name.'" style="float:left;" >
	</form>';
}

//here is the function that filters special characters
function SpecialcharsCleaner($string) {

$patterns = array();				$replacements = array();
$patterns[0] = '/ë/';				$replacements[2] = 'e';
$patterns[1] = '/ç/';				$replacements[1] = 'c';
$patterns[2] = '/fox/';				$replacements[0] = 'slow';

return preg_replace($patterns, $replacements, $string);
 
}


	
}//end of funksionet
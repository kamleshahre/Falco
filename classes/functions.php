<?php
class funksionet {

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


function back() {
	return '
	<FORM><INPUT TYPE="BUTTON" VALUE="Go Back" ONCLICK="history.go(-1)"></FORM>';
}


	
}//end of funksionet
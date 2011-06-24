<?php
class funksionet {

//here goes the navigation in the top	
public function menu_for_reservations() {
	global $page, $subpage;
	
switch ($page) {
	case 'rezervimet':
		$topNavigation = array('Rezervo','Listat','Profit','Ndihmë');
	break;

	case 'perdoruesit':
		$topNavigation = array('Agjentët','Administratorët','Ndihmë');
	break;	

	case 'menaxhment':
		$topNavigation = array('Destinacionet','Stacionet','Ndihmë');
	break;	
	
	default:
		;
	break;
}
	

	foreach ($topNavigation as $row) {
		if(funksionet::SpecialcharsCleaner($row) == ucfirst($_GET['submenu']))
			$css = 'topNavigationCurrent';
		else 	
			$css = 'topNavigationLinks'; 
			
		$topnavi.= '<a  class="menu_top  '.$css.'" href="index.php?menu='.$page.'&submenu='.funksionet::SpecialcharsCleaner(strtolower($row)).'">'.$row.'</a>';
	}	
	return $topnavi;
}		


//here goes the navigation in the left side
function left_menu() {
$page = $_GET['menu'];
	$leftNavigation = array('Rezervimet','Përdoruesit','Menaxhment');
	
	foreach($leftNavigation as $row){
		
		
		
		if(funksionet::SpecialcharsCleaner($row) == ucfirst($_GET['menu']))
			$css = 'leftNavigationCurrent';
		else 	
			$css = 'LeftNavigationLinks'; 
		
		$navi .= '<a  class="menu_links '.$css.'" href="index.php?menu='.funksionet::SpecialcharsCleaner(strtolower($row)).'"><p class="menus">
					<img src="images/'.funksionet::SpecialcharsCleaner(strtolower($row)).'.png" class="left_menu_icon" >
					'.$row.'</p></a>';	
	}
		
		return '<div id="leftside">
				'.$navi.'	
				</div><!-- endof leftside -->
				';


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

function all_directions() {
	global $db;
	$query = $db->query("SELECT * FROM destinations;");
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
$patterns[2] = '/Ç/';				$replacements[0] = 'C';

return preg_replace($patterns, $replacements, $string);
 
}

//here is the function that transforms integer months into strings
function dateFROMintTOstr($string) {

$patterns = array();				$replacements = array();
$patterns[0] = '/01/';				$replacements[11] = 'Janar';
$patterns[1] = '/02/';				$replacements[10] = 'Shkurt';
$patterns[2] = '/03/';				$replacements[9] = 'Mars';
$patterns[3] = '/04/';				$replacements[8] = 'Prill';
$patterns[4] = '/05/';				$replacements[7] = 'Maj';
$patterns[5] = '/06/';				$replacements[6] = 'Qershor';
$patterns[6] = '/07/';				$replacements[5] = 'Korrik';
$patterns[7] = '/08/';				$replacements[4] = 'Gusht';
$patterns[8] = '/09/';				$replacements[3] = 'Shtator';
$patterns[9] = '/10/';				$replacements[2] = 'Tetor';
$patterns[10] = '/11/';				$replacements[1] = 'Nentor';
$patterns[11] = '/12/';				$replacements[0] = 'Dhjetor';

return preg_replace($patterns, $replacements, $string);
 
}

//

function formulari_new_user($tipi="",$roli="") {
 		($roli == 'agent') ? $agent_provis ='<tr>
							<td style="text-align:right;">Provision:</td>
							<td><input type="text" size="3" name="provis"> %</td>
						</tr>' : $agent_provis = "";
		return '
		<div class="formulariNeLightBox">
 		<form action="" method="post">
		<table cellpading="4" cellspacing="5">
		<tr>
			<td style="text-align:right;">Pseudonimi:</td>
			<td><input type="text" name="pseudonimi"></td>
		</tr>
		<tr>
			<td style="text-align:right;">Fjalkalimi:</td>
			<td><input type="password" name="fjalkalimi" value=""></td>
		</tr>
		<tr>
			<td style="text-align:right;">Emri:</td>
			<td><input type="text" name="emri" ></td>
		</tr>
		<tr>
			<td style="text-align:right;">Mbiemri:</td>
			<td><input type="text" name="mbiemri"></td>
		</tr>
		<tr>
			<td style="text-align:right;">Adresa:</td>
			<td><input type="text" name="adresa"></td>
		</tr>
		'.$agent_provis.'
		</table>
		<input type="hidden" name="tipi_i_rolit" value="'.$roli.'">
		<input type="submit" class="close" value="Shto '.$tipi.'" name="new_user" style="float:right;margin-right:10px;">
		</form>
		</div>
		';
}

	
}//end of funksionet
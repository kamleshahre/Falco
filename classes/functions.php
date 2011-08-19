<?php
class funksionet {

//here goes the navigation in the top	
static function menu_for_reservations() {
	global $page, $subpage;
	
if ($_SESSION['roli'] == 'admin') {	
	
	switch ($page) {
		case 'rezervimet':
			$topNavigation = array('Rezervo','Listat','Profit','Ndihmë');
		break;
	
		case 'perdoruesit':
			$topNavigation = array('Agjentët','Administratorët','Ndihmë');
		break;	
	
		case 'menaxhment':
			$topNavigation = array('Destinacionet','Stacionet','Ndihmë'); //edhe njo: 'Udhëtimet'
		break;	
		
		default:
			;
		break;
	} 

}elseif($_SESSION['roli'] == 'agent') {
	
	switch ($page) {
		case 'rezervimet':
			$topNavigation = array('Rezervo','Listat','Profit','Ndihmë');
		break;
	
		default:
			$topNavigation = array('Rezervo','Listat','Profit','Ndihmë');;
		break;
	}
}
	
	$topnavi = '';
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
static function left_menu() {
$page = $_GET['menu'];
	//here we check if the user is admin or agent and then we show the navigation according to his status
	if($_SESSION['roli'] == 'agent') {
		$leftNavigation = array('Rezervimet');
	}
	else {
		$leftNavigation = array('Rezervimet','Përdoruesit','Menaxhment');
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////
	$navi = '';
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
static function directions($direction) {
	global $db;
	$query = $db->query("SELECT * FROM destinations WHERE direction = $direction");
	$city='';
	while($row = mysql_fetch_array($query)){
	$city .= '<option>'.$row['name'].'</option>';
	}
	return $city;
}

static function all_directions() {
	global $db;
	$query = $db->query("SELECT * FROM destinations;");
	$city = '';
	while($row = mysql_fetch_array($query)){
	$city .= '<option value="'.$row['name'].'">'.$row['name'].'</option>';
	}
	return $city;
}	
	
//here we format the date from db format to human readable format	
static function formato_daten($data) {
	
	$data = explode('-', $data);
	return $data[2].'.'.$data[1].'.'.$data[0];
}

//here we format the date from human format to db readable format	
function cformato_daten($data) {
	
	$data = explode('.', $data);
	return $data[0].'.'.$data[1].'.'.$data[2];
}


//here we format all the manual made errors
static function show_error($message) {
	return '<div class="ErrorWrapper"><img style="border:0;margin:5px;" src="images/warning_logo.png"><span style="vertical-align:super;position:relative;bottom:7px;">'.$message.'</span></div>';
}


//This is the BACK button
function back() {
	return '
	<FORM><INPUT TYPE="BUTTON" VALUE="Go Back" ONCLICK="history.go(-1)"></FORM>';
}


//here are the functions for the reservations
static function list_actions($id,$value='',$name='',$date='',$from='',$to='') {
if($date < date("Y-m-d")) {
$class = 'id="disable_form"';
}else{
$class = '';
}
	return '
	<form action="" method="POST" '.$class.'>
<input type="hidden" name="datum" value="'.$date.'">
<input type="hidden" name="from" value="'.$from.'">
<input type="hidden" name="to" value="'.$to.'">
<input type="hidden" name="id" value="'.$id.'">
<input type="hidden" name="action" value="'.$value.'">
<input type="submit" value="'.$name.'" style="float:left;" >
	</form>';
}

//here is the function that filters special characters
static function SpecialcharsCleaner($string) {

$patterns = array();				$replacements = array();
$patterns[0] = '/ë/';				$replacements[2] = 'e';
$patterns[1] = '/ç/';				$replacements[1] = 'c';
$patterns[2] = '/Ç/';				$replacements[0] = 'C';

return preg_replace($patterns, $replacements, $string);
 
}

//here is the function that transforms integer months into strings
static function dateFROMintTOstr($string) {

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

//here is the function that adds a 0 before the numbers from the number 1 until number 9
static function add_zero($string) {
($string == '0.1' && $string != '0.10') ? $string = '0.01' : $string = $string ;
($string == '0.2') ? $string = '0.02' : $string = $string ;
($string == '0.3') ? $string = '0.03' : $string = $string ;
($string == '0.4') ? $string = '0.04' : $string = $string ;
($string == '0.5') ? $string = '0.05' : $string = $string ;
($string == '0.6') ? $string = '0.06' : $string = $string ;
($string == '0.7') ? $string = '0.07' : $string = $string ;
($string == '0.8') ? $string = '0.08' : $string = $string ;
($string == '0.9') ? $string = '0.09' : $string = $string ;
($string == '0.0') ? $string = '0.00' : $string = $string ;
($string == '0.00') ? $string = '0.00' : $string = $string ;
 return $string;
}

//here is the html form that we use to add admin or agent with jquery
static function formulari_new_user($tipi="",$roli="") {
 		($roli == 'agent') ? $agent_provis ='<tr>
							<td style="text-align:right;">Provision:</td>
							<td><input type="text" size="3" name="provis" maxlength="2"> %</td>
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
		<input type="submit" class="button_right" value="Shto '.$tipi.'" name="new_user" style="float:right;margin-right:10px;">
		</form>
		</div>
		';
}

static function filters_travelers() {
return '<form action="" method="post">
<table  style="margin:10px 10px 0 10px;float:left;" cellspacing="1" cellpadding="5" border="0" >
<tr>
	<td>	
<input type="text" id="dataZgjedhur" name="dataZgjedhur">
				<script language="JavaScript">

				
	// whole calendar template can be redefined per individual calendar
	var A_CALTPL = {
		\'months\' : [\'Janar\', \'Shkurt\', \'Mars\', \'Prill\', \'Maj\', \'Qershor\', \'Korrik\', \'Gusht\', \'Shtator\', \'Tetor\', \'Nentor\', \'Dhjetor\'],
		\'weekdays\' : [\'Di\', \'He\', \'Ma\', \'Me\', \'Ej\', \'Pr\', \'Sh\'],
		\'yearscroll\': true,
		\'weekstart\': 1,
		\'centyear\'  : 70,
		\'imgpath\' : \'images/\'
	}
	
	new tcal ({
		// if referenced by ID then form name is not required
		\'controlname\': \'dataZgjedhur\'
	}, A_CALTPL);
	</script>
	</td>
	<td>
		<select class="selectDest" name="Prej" onChange="getState(this.value)">
			<option></option>
			'.funksionet::all_directions().'
		</select>
	</td>
	<td>
		<div id="statediv"><select class="selectDest" name="Deri">
			<option></option>
		</select></div>
	<td><input type="submit" value="Shfaqe listen"></td>
	
</tr>
</table>
</form>';
}

	
}//end of funksionet
<?php
class controller {
	
public function TopMenu() {
	global $page, $subpage;
$topNavigation = array('Rezervo','Lista','Test');

	foreach ($topNavigation as $row) {
		if($row == ucfirst($_GET['submenu']))
			$css = 'topNavigationCurrent';
		else 	
			$css = 'topNavigationLinks'; 
			
		$topnavi.= '<a  class="'.$css.'" href="index.php?menu=rezervimet&submenu='.strtolower($row).'">'.$row.'</a>';
	}	
	return $topnavi;
}		
	
function menu_switcher() {
global $page;	
	switch ($page) {
			case 'rezervimet':
			return $this->rezervimet_switcher();
			break;
			
			case 'agjentet':
			return 'agjentet';
			break;
			
			case 'destinacionet':
			return 'Destinacionet';
			break;			
			
			default:
			return 'rezervimet';
			break;
		}
		
	}
	
function rezervimet_switcher() {
global $subpage;
	switch ($subpage) {
		case 'rezervo':
		return '<div id="Formulari">'.Modelet::rezervo().'</div>';
		break;
		
		case 'lista':
		return Modelet::lista();
		break;
		
		default:
			return '<div id="Formulari">'.Modelet::rezervo().'</div>';
		break;
	}
	
}
	
}//endof controller

class Modelet {
	
function directions($direction) {
	global $db;
	$query = $db->query("SELECT * FROM destinations WHERE direction = $direction");
	while($row = mysql_fetch_array($query)){
	$city .= '<option>'.$row['name'].'</option>';
	}
	return $city;
}

function rezervo() {
	global $db;
if (isset($_POST['rezervo'])) {
	
	// Variables that come from the Reservations form
	$emri 	  = $_POST['emri'];					$mbiemri     = $_POST['mbiemri'];
	$prej     =	$_POST['Prej'];					$KthyesePrej = $_POST['KthyesePrej'];
	$deri 	  =	$_POST['Deri'];					$KthyeseDeri = $_POST['KthyeseDeri'];
	$data     =	$_POST['data1drejtim'];			$dataKthyese = $_POST['dataKthyese'];
	$drejtimi =	$_POST['drejtimi'];
	
	//Here we get the last cost for the reserved destination
	$result = $db->query("SELECT * FROM costs WHERE prej = '$prej' AND deri = '$deri' ORDER by date ASC LIMIT 1");
	$cost = mysql_fetch_array($result);
	$cmimi = $cost['cost'];
	$cmimiKthyes = $cmimi * 2;
	
	//Here we put all informations into database
	if($drejtimi == 'kthyese') {
		if (empty($data) && !empty($dataKthyese)){
			return '<strong>Gabim në zgjedhjen tuaj:</strong> Ju lutem zgjdhni daten e nisjes!';
			exit();
		} elseif(empty($dataKthyese) && !empty($data)) {
			return '<strong>Gabim në zgjedhjen tuaj:</strong> Ju lutem zgjdhni daten e nisjes kthyese!';
			exit();
		}elseif(empty($data) && empty($dataKthyese)){
			return '<strong>Gabim në zgjedhjen tuaj:</strong> Ju lutem zgjdhni datat e nisjeve!';
			exit();
		}elseif($data >= $dataKthyese){
			return '<strong>Gabim në zgjedhjen tuaj:</strong> Data e kthimit nuk mundet te jetë para datës së nisjes, ju lutem korigjoni gabimin!';
			exit(); 
		}elseif($data < date('Y-m-d') || $dataKthyese < date('Y-m-d')){
			return '<strong>Gabim në zgjedhjen tuaj:</strong> data nuk mund te jet me heret se sot!';
			exit(); 			
		} else {
			$db->query("INSERT INTO orders 
							   (name,surname,prej,deri,KthyesePrej,KthyeseDeri,date,data_kthyese,cost) 
						VALUES ('$emri','$mbiemri','$prej','$deri','$KthyesePrej','$KthyeseDeri','$data','$dataKthyese','$cmimiKthyes')") or die(mysql_error());
			$infos = '<strong>Ju keni rezervuar nje udhetim me keto te dhena:</strong><br />';
			$infos .=  'Drejtimi: '.$drejtimi.'<br />';
			$infos .=  'Prej: '.$prej.'<br />';
			$infos .=  'Deri: '.$deri.'<br />';
			$infos .=  'Data: '.$data.'<br />';
			$infos .=  'Kthimi prej: '.$KthyesePrej.'<br />';
			$infos .=  'Kthimi deri: '.$KthyeseDeri.'<br />';
			$infos .=  'Data kthyese:'.$dataKthyese.'<br />';
			$infos .=  '&Ccedil;mimi: '.$cmimiKthyes.'<br />';
			$infos .=  '<a href="GeneratePDF.php" target="_blank">Gjenero tiket</a>';
		}
	return $infos;
		
	} elseif($drejtimi == 'një drejtim') {
		$db->query("INSERT INTO orders 
						   (name,surname,prej,deri,date,cost) 
					VALUES ('$emri','$mbiemri','$prej','$deri','$data','$cmimi')") or die(mysql_error());	
		$infos = '<strong>Ju keni rezervuar nje udhetim me keto te dhena:</strong><br />';
		$infos .= 'Drejtimi: '.$drejtimi.'<br />';
		$infos .= 'Prej: '.$prej.'<br />';
		$infos .= 'Deri: '.$deri.'<br />';
		$infos .= 'Data: '.$data.'<br />';
		$infos .= '&Ccedil;mimi: '.$cmimi.'<br />';
		$infos .= '<a href="GeneratePDF.php">Gjenero tiket</a>';
	return $infos;	
	}

}else {
	return '
<div class="WraperForForm">	
<form action="index.php?menu=rezervimet&submenu=rezervo" method="post">

<table  cellspacing="5" cellpadding="0" border="0" >
<tr>
	<td width="100">
		Emri:
	</td>
	<td width="190">
		<input type="text" id="emri" name="emri">
	</td>

	<td width="100">
		Mbiemri:
	</td>
	<td width="190">
		<input type="text" id="mbiemri" name="mbiemri">
	</td>
</tr>
</table>

<table width="300" cellspacing="5" cellpadding="0" border="0" style="float:left;">
<tr>
	<td width="100">
		Prej:
	</td>
	<td>
		<select class="selectDest" name="Prej">
			'.Modelet::directions(1).'
		</select>
	</td>
	
</tr>
<tr>
	<td width="80">
		Deri:
	</td>
	<td>
		<select class="selectDest" name="Deri">
			'.Modelet::directions(2).'
		</select>
	</td>
</tr>
<tr>
	<td>
	
			<form name="Data1Drejtim">
			<label for="data1drejtim">Data e nisjes:</label>
	</td>
		<td>
			<input type="text" id="data1drejtim" name="data1drejtim">
			<script language="JavaScript">

				
	// whole calendar template can be redefined per individual calendar
	var A_CALTPL = {
		\'months\' : [\'Janar\', \'Shkurt\', \'Mars\', \'Prill\', \'Maj\', \'Qershor\', \'Korrik\', \'Gusht\', \'Shtator\', \'Tetor\', \'Nentor\', \'Dhjetor\'],
		\'weekdays\' : [\'Di\', \'He\', \'Ma\', \'Me\', \'Ej\', \'Pr\', \'Sh\'],
		\'yearscroll\': true,
		\'weekstart\': 0,
		\'centyear\'  : 70,
		\'imgpath\' : \'images/\'
	}
	
	new tcal ({
		// if referenced by ID then form name is not required
		\'controlname\': \'data1drejtim\'
	}, A_CALTPL);
	</script>
				
	</td>
		
	</tr>
</table>

<!-- ___________________Return table_____________________________________ -->
<table width="300" cellspacing="5" cellpadding="0" border="0" style="float:left;" id="hideThis" >
<tr>
	<td width="100">
		Prej:
	</td>
	<td>
		<select class="selectDest" name="KthyesePrej" >
				'.Modelet::directions(2).'
		</select>
	</td>
</tr>
<tr>
	<td width="40">
		Deri:
	</td>
	<td>
		<select class="selectDest" name="KthyeseDeri">
			'.Modelet::directions(1).'
		</select>
	</td>

<tr>
	<td>
		<label for="dataKthyese">Data kthyese:</label>
	</td>		

	<td>
			
			<input type="text" id="dataKthyese" name="dataKthyese">
				<script language="JavaScript">

				
	// whole calendar template can be redefined per individual calendar
	var A_CALTPL = {
		\'months\' : [\'Janar\', \'Shkurt\', \'Mars\', \'Prill\', \'Maj\', \'Qershor\', \'Korrik\', \'Gusht\', \'Shtator\', \'Tetor\', \'Nentor\', \'Dhjetor\'],
		\'weekdays\' : [\'Di\', \'He\', \'Ma\', \'Me\', \'Ej\', \'Pr\', \'Sh\'],
		\'yearscroll\': true,
		\'weekstart\': 0,
		\'centyear\'  : 70,
		\'imgpath\' : \'images/\'
	}
	
	new tcal ({
		// if referenced by ID then form name is not required
		\'controlname\': \'dataKthyese\'
	}, A_CALTPL);
	</script>
			</form>
		</td>

</tr>
</table>

<table width="585" cellspacing="0" cellpadding="3" border="0 " style="float:left;">
<tr>
	<td width="100">
		<input type="radio" id="1drejtim" name="drejtimi"  value="një drejtim" onclick="toggleVisibility(\'hideThis\',0)">
		<label for="1drejtim">Një drejtim</label>
	</td>

	<td >
		<input type="radio" id="kthyese" name="drejtimi" checked="checked" value="kthyese"  onclick="toggleVisibility(\'hideThis\',1)">
		<label for="1drejtim">Kthyese</label>
	</td>
	
	<td>
	<input style="float:right;" type="submit" value="Rezervo" name="rezervo" />
	</td>
</tr>
</table>
</form><!-- end of the reservation form-->
</div>
';
	} 	
	
}	

function lista() {
	global $db;
	
$i = 1; 
$cost = 0;
$query = $db->query("SELECT * FROM orders");
while ($row = mysql_fetch_array($query)) {
 $cost += $row['cost'];
	
if ($i % 2 != "0") # An odd row
  $rowColor = "bgC1";
else # An even row
  $rowColor = "bgC2";	
  	
	$lista .= 
	'<tr class="'.$rowColor.'" id="'.$i.'">
	<td>'.$row['name'].'</td>
	<td>'.$row['surname'].'</td>
	<td>'.$row['prej'].'</td>
	<td>'.$row['deri'].'</td>
	<td>'.$row['cost'].' &euro;</td>
	</tr>
	';
	  $i++; 
}
return '
	<table style="margin:10px 0 0 10px;float:right;" class="extra" cellspacing="1" cellpadding="5" border="0" >
		<tr class="bgC2">
			<td><strong>Total:</strong></td>
			<td>'.$cost.' &euro;</td>
		</tr>
	</table>
	
		<table width="100%" style="margin:10px 10px 0 10px;" class="extra" cellspacing="1" cellpadding="5" border="0" >
	   <tr class="bgC3">
	   		<td><strong>Emri</strong></td>
	   		<td><strong>Mbiemri</strong></td>
	   		<td><strong>Prej</strong></td>
	   		<td><strong>Deri</strong></td>
	   		<td><strong>&Ccedil;mimi</strong></td>
	   </tr>
	   '.$lista.'
	   </table>';
	
}
	
}//endof Modelet

?>
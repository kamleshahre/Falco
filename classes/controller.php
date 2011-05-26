<?php
class controller {
	
	
function menu_switcher() {
global $page;	
	switch ($page) {
			case 'rezervimet':
			return $this->rezervimet_switcher();
			break;
			
			case 'agjentet':
			return $this->agjentet_switcher();
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
		
		case 'listat':
		return Modelet::lista();
		break;
		
		case 'ndihme':
		return 'Qendra per ndihm shkon ktu';
		break;
		
		default:
			return '<div id="Formulari">'.Modelet::rezervo().'</div>';
		break;
	}
	
}

function agjentet_switcher() {
global $subpage;	
	switch ($subpage) {
		case 'rezervo':
		return '<div id="Formulari">'.Modelet::rezervo().'</div>';
		break;
		
		case 'listat':
		return Modelet::lista();
		break;
		
		case 'ndihme':
		return 'Qendra per ndihm shkon ktu';
		break;
		
		default:
			return '<div id="Formulari">'.Modelet::rezervo().'</div>';
		break;
	}
}
	
}//endof controller

class Modelet {
	
function rezervo() {
	global $db;
	
if (isset($_POST['rezervo'])) {
	
	// Variables that come from the Reservations form
	$emri 	  = $_POST['emri'];					$mbiemri     = $_POST['mbiemri'];
	$prej     =	$_POST['Prej'];					$KthyesePrej = $_POST['KthyesePrej'];
	$deri 	  =	$_POST['Deri'];					$KthyeseDeri = $_POST['KthyeseDeri'];
	$data     =	$_POST['data1drejtim'];			$dataKthyese = $_POST['dataKthyese'];
	$persona  = $_POST['persona'];
	$femij 	  = $_POST['femij'];		
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
							   (name,surname,prej,deri,KthyesePrej,KthyeseDeri,date,data_kthyese,persona,femij,cost) 
						VALUES ('$emri','$mbiemri','$prej','$deri','$KthyesePrej','$KthyeseDeri','$data','$dataKthyese','$persona','$femij','$cmimiKthyes')") or die(mysql_error());
			$infos = '<strong>Ju keni rezervuar nje udhetim me keto te dhena:</strong><br />';
			$infos .=  'Drejtimi: '.$drejtimi.'<br />';
			$infos .=  'Prej: '.$prej.'<br />';
			$infos .=  'Deri: '.$deri.'<br />';
			$infos .=  'Data: '.$data.'<br />';
			$infos .=  'Kthimi prej: '.$KthyesePrej.'<br />';
			$infos .=  'Kthimi deri: '.$KthyeseDeri.'<br />';
			$infos .=  'Data kthyese:'.$dataKthyese.'<br />';
			$infos .= 'Persona: '.$persona.'<br />';
			(isset($femij)) ? $infos .= 'Femij: '.$femij.'<br />' : $infos .= '';
			$infos .=  '&Ccedil;mimi: '.$cmimiKthyes.'<br />';
			$infos .=  '<a target="_blank" href="GeneratePDF.php" target="_blank">Gjenero tiket</a>';
		}
	return $infos;
		
	} elseif($drejtimi == 'një drejtim') {
		$db->query("INSERT INTO orders 
						   (name,surname,prej,deri,date,persona,femij,cost) 
					VALUES ('$emri','$mbiemri','$prej','$deri','$data','$persona','$femij','$cmimi')") or die(mysql_error());	
		$infos = '<strong>Ju keni rezervuar nje udhetim me keto te dhena:</strong><br />';
		$infos .= 'Drejtimi: '.$drejtimi.'<br />';
		$infos .= 'Prej: '.$prej.'<br />';
		$infos .= 'Deri: '.$deri.'<br />';
		$infos .= 'Data: '.$data.'<br />';
		(empty($persona)) ? $infos .= 'Persona: 1 <br />' : $infos .= 'Persona: '.$persona.'<br />';
		(!empty($femij)) ? $infos .= 'Femij: '.$femij.'<br />' : $infos .= '';
		$infos .= '&Ccedil;mimi: '.$cmimi.'<br />';
		$infos .= '<a target="_blank" href="GeneratePDF.php">Gjenero tiket</a>';
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
			'.funksionet::directions(1).'
		</select>
	</td>
	
</tr>
<tr>
	<td width="80">
		Deri:
	</td>
	<td>
		<select class="selectDest" name="Deri">
			'.funksionet::directions(2).'
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
				'.funksionet::directions(2).'
		</select>
	</td>
</tr>
<tr>
	<td width="40">
		Deri:
	</td>
	<td>
		<select class="selectDest" name="KthyeseDeri">
			'.funksionet::directions(1).'
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
	<td >Persona:</td>
	<td><input type="text" size="3" name="persona"></td>
</tr>
<tr>
	<td width="30" >Fëmij:</td>
	<td><input type="text" size="3" name="femij"></td>
</tr>
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
	global $db,$act;
	
$dataZgjedhur = $_POST['dataZgjedhur'];	//selected date
$delete = $_POST['Anulo'];
$PostedID = $_POST['id'];
$PostedDATE = $_POST['date'];
$action = $_POST['action'];
	
$i = 1; 
$cost = 0;

	if(isset($PostedID) && $action == 'delete'){
		$db->query("DELETE FROM orders WHERE order_id = $PostedID;");
		$query = $db->query("SELECT * FROM orders WHERE date = '$PostedDATE'") or die(mysql_error());
		//return funksionet::show_error('Rezervimi u anulua!');
	}elseif(isset($PostedID) && $action == 'printo') {
		echo '<script type="text/javascript">
				<!--
				window.location = "GeneratePDF.php?id='.$PostedID.'"
				//-->
				</script>
		';
		exit();
	}elseif(isset($PostedID) && $action == 'edito' || isset($_POST['editoket'])){
		return '<div id="Formulari">'.Modelet::edito($PostedID).'</div>';
	}elseif(isset($dataZgjedhur)) {
		$query = $db->query("SELECT * FROM orders WHERE date = '$dataZgjedhur'");
	}else { 
		$query = $db->query("SELECT * FROM orders WHERE date = curdate()") or die(mysql_error());
	}


	
while ($row = mysql_fetch_array($query)) {
		
 $cost += $row['cost'];
 $data = funksionet::formato_daten($row['date']);
 $id = $row['order_id'];	
		if ($i % 2 != "0") # An odd row
		  $rowColor = "bgC1";
		else # An even row
  		  $rowColor = "bgC2";	
  	
	$lista .= 
	'<tr class="'.$rowColor.'"">
	<td style="text-align:center;"><strong>'.$i.'</strong></td>
	<td>'.$row['name'].' '.$row['surname'].'</td>
	<td>'.$row['prej'].' - '.$row['deri'].'</td>
	<td  style="text-align:center;">'.$row['persona'].'</td>
	<td  style="text-align:center;"> '.$row['femij'].'</td>
		<td width="172"  style="text-align:center;">
			'.funksionet::list_actions($id,'delete','Anulo', $row['date']).
			  funksionet::list_actions($id,'printo','Printo').
			  funksionet::list_actions($id,'edito','Edito').
			'
		</td>
	<td>'.$row['cost'].' &euro;</td>
	</tr>
	';
	  $i++; 
}
return '
<form action="" method="post">
<table  style="margin:10px 10px 0 10px;" cellspacing="1" cellpadding="5" border="0" >
<tr>
	<td>	
<input type="text" id="dataZgjedhur" name="dataZgjedhur">
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
		\'controlname\': \'dataZgjedhur\'
	}, A_CALTPL);
	</script>
	</td>
	<td><input type="submit" value="Shfaqe listen"></td>
	
</tr>
</table>
</form>
	

		<table width="100%" style="margin:10px 10px 0 10px;" class="extra" cellspacing="1" cellpadding="5" border="0" >
	   <tr class="bgC3" style="font-weight:bold;">
	   		<td width="20" > </td>
	   		<td> Emri Mbiemri </td>
	   		<td> Destinacioni </td>
	   		<td width="20">Persona</td>
	   		<td width="20">Fëmij</td>
	   		<td> Opsionet </td>
	   		<td width="50"> &Ccedil;mimi </td>
	   </tr>
	   '.$lista.'
	   </table>
	   
	   	<table style="margin:10px -10px 0 10px;float:right;" class="extra" cellspacing="1" cellpadding="5" border="0" >
		<tr class="bgC2">
			<td><strong>Total:</strong></td>
			<td>'.$cost.' &euro;</td>
		</tr>
		<tr class="bgC2">
			<td><strong>Data:</strong></td>
			<td>'.$data.'</td>
		</tr>
	</table>
	   
	   ';
	
}

function edito($IDtoEdit='') {
global $db;
	if (isset($_POST['editoket'])) {
	
	// Variables that come from the Reservations form
	$emri 	  = $_POST['emri'];					$mbiemri     = $_POST['mbiemri'];
	$prej     =	$_POST['Prej'];					$KthyesePrej = $_POST['KthyesePrej'];
	$deri 	  =	$_POST['Deri'];					$KthyeseDeri = $_POST['KthyeseDeri'];
	$data     =	$_POST['data1drejtim'];			$dataKthyese = $_POST['dataKthyese'];
	$persona  = $_POST['persona'];
	$femij 	  = $_POST['femij'];		
	$drejtimi =	$_POST['drejtimi'];
	
	$id 	  = $_POST['id_to_edit'];
	
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
			$db->query("UPDATE orders SET
						name='$emri',surname='$mbiemri',prej='$prej',deri='$deri',KthyesePrej='$KthyesePrej',
						KthyeseDeri='$KthyeseDeri',date='$data',data_kthyese='$dataKthyese',persona='$persona',
						femij='$femij',cost='$cmimiKthyes' WHERE order_id='$id'");
			$infos = '<strong>Ndryshimet e juaja janë ruajtur me sukses!</strong><br />';
			$infos .=  '<a target="_blank" href="GeneratePDF.php?id='.$id.'">Gjenero tiket</a>';
		}
	return $infos;
		
	} elseif($drejtimi == 'një drejtim') {
		$db->query("UPDATE orders 
					SET name='$emri',surname='$mbiemri',prej='$prej',deri='$deri',
					date='$data',persona='$persona',femij='$femij',cost='$cmimi' 
					WHERE order_id = '$id'") or die(mysql_error());	
		$infos = '<strong>Ndryshimet e juaja janë ruajtur me sukses!</strong><br />';
		$infos .= '<a target="_blank" href="GeneratePDF.php?id='.$id.'">Gjenero tiket</a>';
	return $infos;	
	}

}else {
	
	global $db;

	$values = mysql_fetch_array($db->query("SELECT * FROM orders WHERE order_id = '$IDtoEdit';"));

// Variables that come from the database
	$emri 	  = $values['name'];					$mbiemri     = $values['surname'];
	$id 	  = $values['order_id'];
	return '
<div class="WraperForForm">	
<form action="index.php?menu=rezervimet&submenu=listat" method="post">
<input type="hidden" name="id_to_edit" value="'.$id.'">
<table  cellspacing="5" cellpadding="0" border="0" >
<tr>
	<td width="100">
		Emri:
	</td>
	<td width="190">
		<input type="text" id="emri" name="emri" value="'.$emri.'">
	</td>

	<td width="100">
		Mbiemri:
	</td>
	<td width="190">
		<input type="text" id="mbiemri" name="mbiemri" value="'.$mbiemri.'">
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
			'.funksionet::directions(1).'
		</select>
	</td>
	
</tr>
<tr>
	<td width="80">
		Deri:
	</td>
	<td>
		<select class="selectDest" name="Deri">
			'.funksionet::directions(2).'
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
				'.funksionet::directions(2).'
		</select>
	</td>
</tr>
<tr>
	<td width="40">
		Deri:
	</td>
	<td>
		<select class="selectDest" name="KthyeseDeri">
			'.funksionet::directions(1).'
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
	<td >Persona:</td>
	<td><input type="text" size="3" name="persona"></td>
</tr>
<tr>
	<td width="30" >Fëmij:</td>
	<td><input type="text" size="3" name="femij"></td>
</tr>
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
	<input style="float:right;" type="submit" value="Ruaj te dhënat" name="editoket" />
	</td>
</tr>
</table>
</form><!-- end of the reservation form-->
</div>
';
	} 	
	
}	
	
}//endof Modelet

?>
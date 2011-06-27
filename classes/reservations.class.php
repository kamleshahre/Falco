<?php
class reservations {
function rezervo() {
	global $db;
	//here we get the provision from the current agent
	$perdorues = $_SESSION['username'];
	$selected_provision = mysql_fetch_array($db->query("SELECT selected_provis FROM users where username='$perdorues'"));
	$provis = $selected_provision['selected_provis'];
if (isset($_POST['rezervo'])) {
	
	// Variables that come from the Reservations form
	$emri 	  = $_POST['emri'];					$mbiemri     = $_POST['mbiemri'];
	$prej     =	$_POST['Prej'];					$deri 	  	 = $_POST['Deri'];
	$data     =	$_POST['data1drejtim'];			$dataKthyese = $_POST['dataKthyese'];
	$drejtimi =	$_POST['drejtimi'];
	//$femij 	  = $_POST['femij'];
	if(empty($_POST['persona'])) {
		$persona = 1;
	}else{
		$persona = $_POST['persona'];
	}
	
	
	
	//Here we get the last cost for the reserved destination
	$result = $db->query("SELECT * FROM costs WHERE prej = '$prej' AND deri = '$deri' ORDER by date ASC LIMIT 1");
	$cost = mysql_fetch_array($result);
	$cmimi = $cost['cost'] * $persona;
	$cmimiKthyes = ($cmimi * 2);
	$provision = $provis * $cmimi;
	$provisionKthyes = $provis * $cmimiKthyes;
	
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
							   (name,surname,prej,deri,KthyesePrej,KthyeseDeri,date,data_kthyese,persona,rezervues,cost,provision) 
						VALUES ('$emri','$mbiemri','$prej','$deri','$deri','$prej','$data','$dataKthyese','$persona','$perdorues','$cmimiKthyes','$provisionKthyes')") or die(mysql_error());
			$infos = '<strong>Ju keni rezervuar nje udhetim me keto te dhena:</strong><br />';
			$infos .=  'Drejtimi: '.$drejtimi.'<br />';
			$infos .=  'Prej: '.$prej.'<br />';
			$infos .=  'Deri: '.$deri.'<br />';
			$infos .=  'Data: '.$data.'<br />';
			$infos .=  'Kthimi prej: '.$deri.'<br />';
			$infos .=  'Kthimi deri: '.$prej.'<br />';
			$infos .=  'Data kthyese:'.$dataKthyese.'<br />';
			$infos .= 'Persona: '.$persona.'<br />';
			(isset($femij)) ? $infos .= 'Femij: '.$femij.'<br />' : $infos .= '';
			$infos .=  '&Ccedil;mimi: '.$cmimiKthyes.'<br />';
			$infos .=  '<a target="_blank" href="GeneratePDF.php" target="_blank">Gjenero tiket</a>';
		}
	return $infos;
		
	} elseif($drejtimi == 'një drejtim') {
		$db->query("INSERT INTO orders 
						   (name,surname,prej,deri,date,persona,rezervues,cost,provision) 
					VALUES ('$emri','$mbiemri','$prej','$deri','$data','$persona','$perdorues','$cmimi','$provision')") or die(mysql_error());	
		$infos = '<strong>Ju keni rezervuar nje udhetim me keto te dhena:</strong><br />';
		$infos .= 'Drejtimi: '.$drejtimi.'<br />';
		$infos .= 'Prej: '.$prej.'<br />';
		$infos .= 'Deri: '.$deri.'<br />';
		$infos .= 'Data: '.$data.'<br />';
		$infos .= 'Persona: '.$persona.'<br />';
		(!empty($femij)) ? $infos .= 'Femij: '.$femij.'<br />' : $infos .= '';
		$infos .= '&Ccedil;mimi: '.$cmimi.'<br />';
		$infos .= '<a target="_blank" href="GeneratePDF.php">Gjenero tiket</a>';
	return $infos;	
	}

}else {
	return '
<div class="WraperForForm">	
<form action="index.php?menu=rezervimet&submenu=rezervo" method="post">

<div class="elementsLabelBox">
		Emri:
</div>
<div class="elementsBox">
		<input type="text" id="emri" name="emri">
</div>

<div class="elementsLabelBox">
		Mbiemri:
</div>
<div class="elementsBox">
		<input type="text" id="mbiemri" name="mbiemri">
</div>

<div class="elementsLabelBox">
		Prej:
	</div>
<div class="elementsBox">
		<select class="selectDest" name="Prej" onChange="getState(this.value)">
			<option></option>
			'.funksionet::all_directions().'
		</select>
</div>
	
<div class="elementsLabelBox">
		Deri:
</div>
<div class="elementsBox">
		<div id="statediv"><select class="selectDest" name="deri">
			<option></option>
		</select></div>
</div>
<div class="elementsLabelBox">
	
			<form name="Data1Drejtim">
			<label for="data1drejtim">Data e nisjes:</label>
</div>
<div class="elementsBox">
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
				
</div>
<!-- ___________________ RETURN DATE _____________________________________ -->
<div id="hideThis">
<div class="elementsLabelBox">
		<label for="dataKthyese">Data kthyese:</label>
</div>	

<div class="elementsBox">			
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
</div>
</div>	




<div class="elementsLabelBox">
	Persona:
</div>
<div class="elementsBox">
		<select name="persona">
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
		</select>
</div>
<!-- <tr>
	<td width="30" >Fëmij:</td>
	<td><input type="text" size="3" name="femij"></td>
</tr> -->

<div class="elementsBox">
</div>
<div class="elementsLabelBox">
</div>

<div class="elementsLabelBox">
		<label for="1drejtim">Një drejtim</label>
		<input type="radio" id="1drejtim" name="drejtimi"  value="një drejtim" onclick="toggleVisibility(\'hideThis\',0)">
<br/>
		<label for="1drejtim">Kthyese</label>
		<input type="radio" id="kthyese" name="drejtimi" checked="checked" value="kthyese"  onclick="toggleVisibility(\'hideThis\',1)">
</div>
	
	
	<input style="float:right;margin:15px 49px 0 0;" type="submit" value="Rezervo" name="rezervo" />
	

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


	if(isset($PostedID) && $action == 'printo') {
		echo '<script type="text/javascript">
				<!--
				window.location = "GeneratePDF.php?id='.$PostedID.'"
				//-->
				</script>
		';
		exit();
	}if(isset($PostedID) && $action == 'edito'){
		return '<div id="Formulari">'.reservations::edito($PostedID).'</div>';
	}
	if(isset($dataZgjedhur)) {
		$PrejZgjedhur = $_POST['Prej'];
		$DeriZgjedhur = $_POST['Deri'];
		$query = $db->query("SELECT * FROM orders WHERE prej='$PrejZgjedhur' AND deri='$DeriZgjedhur' AND (date = '$dataZgjedhur' OR data_kthyese = '$dataZgjedhur')") or die(mysql_error());
		$data = $dataZgjedhur;
	}elseif(isset($PostedID) && $action == 'delete'){
		$from = $_POST['from'];
		$to = $_POST['to'];
		$data = $_POST['date'];
		$db->query("DELETE FROM orders WHERE order_id = $PostedID;");
		$query = $db->query("SELECT * FROM orders WHERE prej='$from' AND deri='$to' AND (date = '$data' OR data_kthyese = '$data')") or die(mysql_error());
		$error =  funksionet::show_error('Rezervimi u anulua me sukses!');
	}
	else { 
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
	<td>
		<select class="selectDest" name="Prej">
		'.funksionet::directions(1).'
		</select>
	</td>
	<td>
		<select class="selectDest" name="Deri">
		'.funksionet::directions(2).'</td>
		</select>
	<td><input type="submit" value="Shfaqe listen"></td>
	
</tr>
</table>
</form>'.funksionet::show_error('Zgjedhni listën e udhëtarëve!');
		
		//$query = $db->query("SELECT * FROM orders WHERE date = curdate()") or die(mysql_error());
		//$dat = mysql_fetch_array($query);
		//$data = $dat['date'];
	}


	
while ($row = mysql_fetch_array($query)) {
		
 $cost += $row['cost'];
 $provisionTotal += $row['provision'];
 $costNOPROVISION = $cost - $provisionTotal;
 $date = funksionet::formato_daten($data);
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
	<!-- <td  style="text-align:center;"> '.$row['femij'].'</td> -->
	<td>'.$row['rezervues'].'</td>
		<td width="172"  style="text-align:center;">
			'.funksionet::list_actions($id,'delete','Anulo', $row['date'],$row['prej'],$row['deri']).
			  funksionet::list_actions($id,'printo','Printo').
			  funksionet::list_actions($id,'edito','Edito').
			'
		</td>
	<td style="text-align:right;">'.substr($row['provision'], 0, 4).' &euro;</td>
	<td style="text-align:right;">'.$row['cost'].' &euro;</td>
	</tr>
	';
	  $i++; 
}
return $error.'
<form action="" method="post">
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
	<td>
		<select class="selectDest" name="Prej">
		'.funksionet::directions(1).'
		</select>
	</td>
	<td>
		<select class="selectDest" name="Deri">
		'.funksionet::directions(2).'</td>
		</select>
	<td><input type="submit" value="Shfaqe listen"></td>
	
</tr>
</table>
</form>
	

		<table width="100%" style="margin:10px 10px 0 10px;" class="extra" cellspacing="1" cellpadding="5" border="0" >
	   <tr class="bgC3" style="font-weight:bold;">
	   		<td width="20" > </td>
	   		<td>Pasagjeri</td>
	   		<td> Destinacioni </td>
	   		<td width="20">Persona</td>
	   		<!-- <td width="20">Fëmij</td> -->
	   		<td>E kreu</td>
	   		<td> Opsionet </td>
	   		<td>Provision</td>
	   		<td width="50">Çmimi</td>
	   </tr>
	   '.$lista.'
	   </table>
	   
	   	<table style="margin:10px -10px 0 10px;float:right;" class="extra" cellspacing="1" cellpadding="5" border="0" >
		<tr class="bgC2">
			<td><strong>Data:</strong></td>
			<td>'.$date.'</td>
		</tr>
	   	<tr class="bgC2">
			<td><strong>Provisioni total:</strong></td>
			<td style="text-align:right;">'.$provisionTotal.' &euro;</td>
		</tr>
		<tr class="bgC2">
			<td><strong>Profit pa provision:</strong></td>
			<td style="text-align:right;">'.$costNOPROVISION.' &euro;</td>
		</tr>
	   	<tr class="bgC2">
			<td><strong>Profit Total:</strong></td>
			<td style="text-align:right;font-weight:bold;">'.$cost.' &euro;</td>
		</tr>
	</table>
	   
	   ';
	
}

function profit() {
	global $db;
	$i = 1;
	
	//here we make the years for filters
	$SelectYears	= '<option>Zgjidhe vitin:</option>';
	for ($vite = 2011; $vite <= 2050; $vite++) {
		$SelectYears	.= '<option value="'.$vite.'">'.$vite.'</option>';
	}
		
	
	
	
	$usersQuery = $db->query("SELECT username FROM users WHERE status='agent';");
	while ($rows = mysql_fetch_array($usersQuery)) {
			$users = $rows['username'];
			
							if(isset($_POST['ZgjedhMuaj'])) {
								$viti = $_POST['viti'];
								$muaj = $_POST['muaj'];
								$query = $db->query("SELECT rezervues, SUM(cost) AS sumaTotale, date, SUM(provision) AS provs
													FROM orders
													WHERE rezervues='$users' AND (EXTRACT(MONTH FROM date)='$muaj' AND EXTRACT(YEAR FROM date)='$viti');");
							} else {
								 $viti = date('Y');
								 $muaj = date('m');
								 $query = $db->query("SELECT rezervues, SUM(cost) AS sumaTotale, date, SUM(provision) AS provs
													FROM orders
													WHERE rezervues='$users' AND (EXTRACT(MONTH FROM date)='$muaj' AND EXTRACT(YEAR FROM date)='2011');");
							}
							
			while($row = mysql_fetch_array($query)) {
				
				if ($i % 2 != "0") # An odd row
				  $rowColor = "bgC1";
				else # An even row
		  		  $rowColor = "bgC2";	
				
		  		  $GjithsejProfit += $row['sumaTotale'];
		  		  $GjithsejProvis += $row['provs'];
		  		  $GjithsejPAProvis = $GjithsejProfit - $GjithsejProvis;
		  		  $lista .= '
					<tr class="'.$rowColor.'">
						<td style="text-align:center;font-weight:bold;">'.$i.'</td>
						<td>'.ucfirst($row['rezervues']).'</td>
						<td style="text-align:right;">'.substr($row['provs'], 0, 4).'  &euro;</td>
						<td style="text-align:right;">'.$row['sumaTotale'].' &euro;</td>
					</tr>
					';
				$i++;
			}
	}
			
	
	return '
		<form action="" method="POST">
			
		<table cellspacing="1" cellpadding="5" border="0" style="margin: 10px 10px 0pt;">			
		<tr>
		<td><select name="muaj">
				<option value="00">Zgjidhe muajn:</option>
				<option value="01">Janar</option>
				<option value="02">Shkurt</option>
				<option value="03">Mars</option>
				<option value="04">Prill</option>
				<option value="05">Maj</option>
				<option value="06">Qershor</option>
				<option value="07">Korrik</option>
				<option value="08">Gusht</option>
				<option value="09">Shtator</option>
				<option value="10">Tetor</option>
				<option value="11">Nëntor</option>
				<option value="12">Dhjetor</option>
		</td></select>
		<td>
			<select name="viti">
			'.$SelectYears.'
			</select>
		</td>
		<td><input type="submit" name="ZgjedhMuaj" value="Shfaqe listen"></td>
		</tr>
		</table>
		
		</form>
			<table width="100%" style="margin:10px 10px 0 10px;" class="extra" cellspacing="1" cellpadding="5" border="0">
				<tr class="bgC3" style="font-weight:bold;">
					<td width="20"></td>
					<td>Agjenti</td>
					<td width="80">Provision</td>
					<td width="80">Profit</td>
				</tr>
				
					'.$lista.'
			</table>
			
   	<table style="margin:10px -10px 0 10px;float:right;" class="extra" cellspacing="1" cellpadding="5" border="0" >
		<tr class="bgC2">
			<td><strong>Periudha:</strong></td>
			<td>'.funksionet::dateFROMintTOstr($muaj).' '.$viti.'</td>
		</tr>
		<tr class="bgC2">
			<td><strong>Provisioni total:</strong></td>
			<td style="text-align:right;">'.$GjithsejProvis.' &euro;</td>
		</tr>	
		<tr class="bgC2">
			<td><strong>Profit pa provision:</strong></td>
			<td style="text-align:right;">'.$GjithsejPAProvis.' &euro;</td>
		</tr>	
		<tr class="bgC2">
			<td><strong>Profit Total:</strong></td>
			<td style="text-align:right;font-weight:bold;">'.$GjithsejProfit.' &euro;</td>
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


}//endof reservations
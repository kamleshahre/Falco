<?php
class reservations {
static function rezervo() {
	global $db;
//here we get the provision from the current agent
	$perdorues = $_SESSION['username'];
	$selected_provision = mysql_fetch_array($db->query("SELECT selected_provis FROM users where username='$perdorues'"));
	$provis = $selected_provision['selected_provis'];
//here we check if we want to delete the last made reservation 
if(isset($_POST['storno'])){
	$last_order_id = mysql_fetch_array($db->query("SELECT  MAX(order_id) as last_order_id FROM orders"));
	$last_id = $last_order_id['last_order_id'];
	$db->query("DELETE FROM orders WHERE order_id = '$last_id';");
	return funksionet::show_error('Rezervimi u anulua me sukes!');
	exit();}
/////////////////////////////////////////////////////////////////////////////
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
	$cmimiKthyes = $cost['return_cost'] * $persona;
	$provision = $provis * $cmimi;
	$provisionKthyes = $provis * $cmimiKthyes;
	
	//Here we put all informations into database
	if($drejtimi == 'kthyese') {
		if (empty($data) && !empty($dataKthyese)){
			return funksionet::show_error('Gabim n� zgjedhjen tuaj: Ju lutem zgjdhni daten e nisjes!');
			exit();
		} elseif(empty($dataKthyese) && !empty($data)) {
			return funksionet::show_error('Gabim n� zgjedhjen tuaj: Ju lutem zgjdhni daten e nisjes kthyese!');
			exit();
		}elseif(empty($data) && empty($dataKthyese)){
			return funksionet::show_error('Gabim n� zgjedhjen tuaj: Ju lutem zgjdhni datat e nisjeve!');
			exit();
		}elseif($data >= $dataKthyese){
			return funksionet::show_error('Gabim n� zgjedhjen tuaj: Data e kthimit nuk mundet te jet� para dat�s s� nisjes, ju lutem korigjoni gabimin!');
			exit(); 
		}elseif($data < date('Y-m-d') || $dataKthyese < date('Y-m-d')){
			return funksionet::show_error('Gabim n� zgjedhjen tuaj: data nuk mund te jet me heret se sot!');
			exit();
		} else {
			$db->query("INSERT INTO orders 
							   (name,surname,prej,deri,KthyesePrej,KthyeseDeri,date,data_kthyese,persona,rezervues,cost,provision) 
						VALUES ('$emri','$mbiemri','$prej','$deri','$deri','$prej','$data','$dataKthyese','$persona','$perdorues','$cmimiKthyes','$provisionKthyes')") or die(mysql_error());
			$infos  = '<td>'.$emri.' '.$mbiemri.'</td>';
			$infos .=  '<td>'.$prej.'</td>';
			$infos .=  '<td>'.$deri.'</td>';
			$infos .=  '<td>'.$deri.'</td>';
			$infos .=  '<td>'.$prej.'</td>';
			$infos .=  '<td>'.funksionet::formato_daten($data).'</td>';
			$infos .=  '<td>'.funksionet::formato_daten($dataKthyese).'</td>';
			$infos .= '<td style="text-align:center;">'.$persona.'</td>';
//			$infos .=  '&Ccedil;mimi: '.$cmimiKthyes.'<br />';
//			$infos .=  '<a target="_blank" href="GeneratePDF.php" target="_blank">Gjenero tiket</a>';
		}
	return '<div style="margin:10px;float:left;">
	<strong>Ju keni rezervuar nj� udh�tim me k�to t� dhena:</strong></div>
	<a target="_blank" href="GeneratePDF.php"><img title="Gjenero tiket�n" alt="Gjenero tiket�n" style="float:right;border:0;margin-top:10px;" src="images/print.png"></a>
		<form action="" method="post" style="float:right;border:0;margin-top:10px;">
		<input type="submit" name="storno" value="" class="x_button" title="Anulo" >
		</form>
	<table width="100%" style="margin-top:10px;margin-left:10px;" class="extra" cellspacing="1" cellpadding="5" border="0" >
	<tr class="bgC3" style="font-weight:bold">
					<td width="90">Pasagjeri</td>
					<td width="75">Prej</td>
					<td width="75">Deri</td>
					<td width="90">Kthimi nga</td>
					<td width="90">Kthimi deri</td>
					<td width="90">Data</td>
					<td width="90">Data kthyese</td>
					<td width="10">Persona</td>
				</tr>
				<tr class="bgC2">
				'.$infos.'
				</tr>
				
	</table>
	<table style="margin-top:-1px;margin-right:-10px;float:right;" class="extra" cellspacing="1" cellpadding="5" border="0" >
				<tr class="bgC2">
					<td width="100" style="font-weight:bold;">�mimi:</td>
					<td width="71" style="text-align:right;">'.$cmimiKthyes.' &euro;</td>
				</tr>
	</table>
	';
	
	//HERE WE SHOW INFOS ABOUT THE RESERVATION MADE 1 WAY
	} elseif($drejtimi == 'nj� drejtim') {
		if (empty($data)){
			return funksionet::show_error('Gabim n� zgjedhjen tuaj: Ju lutem zgjdhni daten e nisjes!');
			exit();
		}elseif($data < date('Y-m-d')){
			return funksionet::show_error('Gabim n� zgjedhjen tuaj: data nuk mund te jet me heret se sot!');
			exit();
		}else {
		$db->query("INSERT INTO orders 
						   (name,surname,prej,deri,date,persona,rezervues,cost,provision) 
					VALUES ('$emri','$mbiemri','$prej','$deri','$data','$persona','$perdorues','$cmimi','$provision')") or die(mysql_error());	
		$infos  = '<td>'.$emri.' '.$mbiemri.'</td>';
		$infos .= '<td>'.$prej.'</td>';
		$infos .= '<td>'.$deri.'</td>';
		$infos .= '<td>'.funksionet::formato_daten($data).'</td>';
		$infos .= '<td style="text-align:center;">'.$persona.'</td>';
	return '<div style="margin:10px;float:left;">
	<strong>Ju keni rezervuar nj� udh�tim me k�to t� dhena:</strong></div>
	<a target="_blank" href="GeneratePDF.php"><img title="Gjenero tiket�n" alt="Gjenero tiket�n" style="float:right;border:0;margin-top:10px;" src="images/print.png"></a>
		<form action="" method="post" style="float:right;border:0;margin-top:10px;">
		<input type="submit" name="storno" value="" class="x_button" title="Anulo" >
		</form>
	<table width="100%" style="margin-top:10px;margin-left:10px;" class="extra" cellspacing="1" cellpadding="5" border="0" >
	<tr class="bgC3" style="font-weight:bold">
					<td>Pasagjeri</td>
					<td>Prej</td>
					<td>Deri</td>
					<td width="100">Data</td>
					<td width="80">Persona</td>
				</tr>
				<tr class="bgC2">
				'.$infos.'
				</tr>
				
	</table>
	<table style="margin-top:-1px;margin-right:-10px;float:right;" class="extra" cellspacing="1" cellpadding="5" border="0" >
				<tr class="bgC2">
					<td width="100" style="font-weight:bold;">�mimi:</td>
					<td width="80" style="text-align:right;">'.$cmimi.' &euro;</td>
				</tr>
	</table>
	';	}
	}

}else {
	return '<div id="Formulari">
<div class="WraperForForm">	
<form action="" method="post">
<div class="elementsLabelBox">
		'.trans('Emri').':
</div>
<div class="elementsBox">
		<input type="text" id="emri" name="emri">
</div>

<div class="elementsLabelBox">
		'.trans('Mbiemri').':
</div>
<div class="elementsBox">
		<input type="text" id="mbiemri" name="mbiemri">
</div>

<div class="elementsLabelBox">
		'.trans('Prej').':
	</div>
<div class="elementsBox">
		<select class="selectDest" name="Prej" onChange="getState(this.value)">
			<option></option>
			'.funksionet::all_directions().'
		</select>
</div>
	
<div class="elementsLabelBox">
		'.trans('Deri').':
</div>
<div class="elementsBox">
		<div id="statediv"><select class="selectDest" name="deri">
			<option></option>
		</select></div>
</div>
<div class="elementsLabelBox">
	
			<label for="data1drejtim">'.trans('Data e nisjes').':</label>
</div>
<div class="elementsBox">
			<input type="text" id="data1drejtim" name="data1drejtim">
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
		\'controlname\': \'data1drejtim\'
	}, A_CALTPL);
	</script>
				
</div>
<!-- ___________________ RETURN DATE _____________________________________ -->
<div id="hideThis">
<div class="elementsLabelBox">
		<label for="dataKthyese">'.trans('Data kthyese').':</label>
</div>	

<div class="elementsBox">			
			<input type="text" id="dataKthyese" name="dataKthyese">
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
		\'controlname\': \'dataKthyese\'
	}, A_CALTPL);
	</script>
			
</div>
</div>	




<div class="elementsLabelBox">
	'.trans('Persona').':
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
	<td width="30" >F�mij:</td>
	<td><input type="text" size="3" name="femij"></td>
</tr> -->

<div class="elementsBox">
</div>
<div class="elementsLabelBox">
</div>

<div class="elementsLabelBox">
		<label for="1drejtim">'.trans('Nj&euml; drejtim').'</label>
		<input type="radio" id="1drejtim" name="drejtimi"  value="nj� drejtim" onclick="toggleVisibility(\'hideThis\',0)">
<br/>
		<label for="1drejtim">'.trans(Kthyese).'</label>
		<input type="radio" id="kthyese" name="drejtimi" checked="checked" value="kthyese"  onclick="toggleVisibility(\'hideThis\',1)">
</div>
	
	
	<input style="float:right;margin:15px 49px 0 0;" type="submit" value="'.trans('Rezervo').'" name="rezervo" />
	

</form><!-- end of the reservation form-->
</div>
</div><!-- end of Formulari-->
';
	} 	
	
}	

static function lista() {
	global $db,$act;
	
if(isset($_POST['dataZgjedhur']))  $dataZgjedhur = $_POST['dataZgjedhur'];	//selected date
if(isset($_POST['Anulo'])) $delete = $_POST['Anulo'];
if(isset($_POST['id'])) $PostedID = $_POST['id'];
if(isset($_POST['date'])) $PostedDATE = $_POST['date'];
if(isset($_POST['action'])) $action = $_POST['action'];
	
$i = 1; 
$cost = 0;

	//here we check if we clicked the Print button
	if(isset($PostedID) && $action == 'printo') {
		echo '<script type="text/javascript">
				<!--
				window.location = "GeneratePDF.php?id='.$PostedID.'"
				//-->
				</script>
		';
		exit();
	//here we check if we clicked the Edit button
	}elseif(isset($PostedID) && $action == 'edito'){
		return '<div id="Formulari">'.reservations::edito($PostedID).'</div>';
	//here we check if we already edited the reservation
	}elseif(isset($_POST['editoket'])) {
	
	// Variables that come from the Reservations form
	$emri 	  = $_POST['emri'];					$mbiemri     = $_POST['mbiemri'];
	$prej     =	$_POST['Prej'];					$KthyesePrej = $_POST['KthyesePrej'];
	$deri 	  =	$_POST['Deri'];					$KthyeseDeri = $_POST['KthyeseDeri'];
	$data     =	$_POST['data1drejtim'];			$dataKthyese = $_POST['dataKthyese'];
	$persona  = $_POST['persona'];
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
			return '<strong>Gabim n� zgjedhjen tuaj:</strong> Ju lutem zgjdhni daten e nisjes!';
			exit();
		} elseif(empty($dataKthyese) && !empty($data)) {
			return '<strong>Gabim n� zgjedhjen tuaj:</strong> Ju lutem zgjdhni daten e nisjes kthyese!';
			exit();
		}elseif(empty($data) && empty($dataKthyese)){
			return '<strong>Gabim n� zgjedhjen tuaj:</strong> Ju lutem zgjdhni datat e nisjeve!';
			exit();
		}elseif($data >= $dataKthyese){
			return '<strong>Gabim n� zgjedhjen tuaj:</strong> Data e kthimit nuk mundet te jet� para dat�s s� nisjes, ju lutem korigjoni gabimin!';
			exit(); 
		}elseif($data < date('Y-m-d') || $dataKthyese < date('Y-m-d')){
			return '<strong>Gabim n� zgjedhjen tuaj:</strong> data nuk mund te jet me heret se sot!';
			exit(); 			
		} else {
			$db->query("UPDATE orders SET
						name='$emri',surname='$mbiemri',prej='$prej',deri='$deri',KthyesePrej='$KthyesePrej',
						KthyeseDeri='$KthyeseDeri',date='$data',data_kthyese='$dataKthyese',persona='$persona',
						cost='$cmimiKthyes' WHERE order_id='$id'");
			$infos = funksionet::show_error('Ndryshimet e juaja jan� ruajtur me sukses!');
			$infos .=  '<a target="_blank" href="GeneratePDF.php?id='.$id.'">Gjenero tiket</a>';
		}
	return $infos;
		
	} elseif($drejtimi == 'nj� drejtim') {
		$db->query("UPDATE orders 
					SET name='$emri',surname='$mbiemri',prej='$prej',deri='$deri',
					date='$data',persona='$persona',cost='$cmimi' 
					WHERE order_id = '$id'") or die(mysql_error());	
		$infos = funksionet::show_error('Ndryshimet e juaja jan� ruajtur me sukses!
		<a target="_blank" href="GeneratePDF.php?id='.$id.'""><img title="Gjenero tiket�n" alt="Gjenero tiket�n" style="border:0;margin-left:10px;top:5px;position:relative;" src="images/print.png"></a>
		');
	//	$infos .= '<a target="_blank" href="GeneratePDF.php?id='.$id.'">Gjenero tiket</a>';
	return $infos;	
	}
	
	}
	if(isset($dataZgjedhur)) {
		$PrejZgjedhur = $_POST['Prej'];
		$DeriZgjedhur = $_POST['Deri'];
		$query = $db->query("SELECT * FROM orders WHERE (prej='$PrejZgjedhur' AND deri='$DeriZgjedhur' AND date = '$dataZgjedhur')
							OR (KthyesePrej='$PrejZgjedhur' AND KthyeseDeri='$DeriZgjedhur' AND data_kthyese = '$dataZgjedhur')
							") or die(mysql_error());
		$data = $dataZgjedhur;
	}elseif(isset($PostedID) && $action == 'delete'){
		$from = $_POST['from'];
		$to = $_POST['to'];
		$data = $_POST['datum'];
		$db->query("DELETE FROM orders WHERE order_id = $PostedID;");
		$query = $db->query("SELECT * FROM orders WHERE (prej='$from' AND deri='$to' AND date = '$data')
							OR (KthyesePrej='$from' AND KthyeseDeri='$to' AND data_kthyese = '$data')
							") or die(mysql_error());
		$error =  funksionet::show_error('Rezervimi u anulua me sukses!');
	}
	else { 
		return funksionet::filters_travelers().funksionet::show_error('Zgjedhni list�n e udh�tar�ve!');
		//$query = $db->query("SELECT * FROM orders WHERE date = curdate()") or die(mysql_error());
		//$dat = mysql_fetch_array($query);
		//$data = $dat['date'];
	}


$provisionTotal = '';
$lista = '';	
$error = '';
while ($row = mysql_fetch_array($query)) {
		
 $cost += $row['cost'];
 $provisionTotal += $row['provision'];
 $costNOPROVISION = $cost - $provisionTotal;
 $date = funksionet::formato_daten($data);
 if(empty($row['KthyesePrej']) && empty($row['KthyeseDeri'])) { 
 $arrow = '<img src="images/one_way.gif">';
 }else {
 $arrow = '<img src="images/two_ways.gif">';
 }
 $id = $row['order_id'];	
		if ($i % 2 != "0") # An odd row
		  $rowColor = "bgC1";
		else # An even row
  		  $rowColor = "bgC2";	
  	
	$lista .= 
	'<tr class="'.$rowColor.'"">
	<td style="text-align:center;"><strong>'.$i.'</strong></td>
	<td>'.$row['name'].' '.$row['surname'].'</td>
	<td style="text-align:center;">'.$row['prej'].' '.$arrow.' '.$row['deri'].'</td>
	<td  style="text-align:center;">'.$row['persona'].'</td>
	<!-- <td  style="text-align:center;"> '.$row['femij'].'</td> -->
	<td>'.$row['rezervues'].'</td>
		<td width="172"  style="text-align:center;">
			'.funksionet::list_actions($id,'delete','Anulo', $row['date'],$row['prej'],$row['deri']).
			  funksionet::list_actions($id,'printo','Printo', $row['date']).
			  funksionet::list_actions($id,'edito','Edito', $row['date']).
			'
		</td>
	<td style="text-align:right;">'.substr($row['provision'], 0, -1).' &euro;</td>
	<td style="text-align:right;">'.$row['cost'].' &euro;</td>
	</tr>
	';
	  $i++; 
}
return $error.funksionet::filters_travelers().'
		<table width="100%" style="margin:10px 10px 0 10px;" class="extra" cellspacing="1" cellpadding="5" border="0" >
	   <tr class="bgC3" style="font-weight:bold;">
	   		<td width="20" > </td>
	   		<td>Pasagjeri</td>
	   		<td> Destinacioni </td>
	   		<td width="20">Persona</td>
	   		<!-- <td width="20">F�mij</td> -->
	   		<td>E kreu</td>
	   		<td> Opsionet </td>
	   		<td>Provision</td>
	   		<td width="50">�mimi</td>
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

static function profit() {
	global $db;
	$i = 1;
	//here we check if the PAY button is clicked (this is checked 2 times, here and below where we make the table query)
	if (isset($_POST['paguaj'])) {
		$username = $_POST['username'];
		$paid = $_POST['statusi'];		$month = $_POST['month'];		$year = $_POST['year'];
		$db->query("INSERT INTO agent_payments (agent, paid, month, year, paid_date) VALUES ('$username','$paid', '$month', '$year', NOW())");
	}
	//here we make the years for filters
	$SelectYears	= '<option>Zgjidhe vitin:</option>';
	for ($vite = 2011; $vite <= 2050; $vite++) {
		$SelectYears	.= '<option value="'.$vite.'">'.$vite.'</option>';
	}
	
	$usersQuery = $db->query("SELECT username FROM users WHERE status='agent';");
	$lista='';
	$GjithsejProfit='';
	$GjithsejProvis='';
	$GjithsejPAProvis='';
	

					
	while ($rows = mysql_fetch_array($usersQuery)) {
			$users = $rows['username'];
			
							if(isset($_POST['ZgjedhMuaj'])) {
								$viti = $_POST['viti'];
								$muaj = $_POST['muaj'];
								$query = $db->query("SELECT rezervues, SUM(cost) AS sumaTotale, date, SUM(provision) AS provs
													FROM orders
													WHERE rezervues='$users' AND (EXTRACT(MONTH FROM date)='$muaj' AND EXTRACT(YEAR FROM date)='$viti');");
							
							}elseif(isset($_POST['paguaj'])){
								$viti = $_POST['year'];
								$muaj = $_POST['month'];
								$query = $db->query("SELECT rezervues, SUM(cost) AS sumaTotale, date, SUM(provision) AS provs
													FROM orders
													WHERE rezervues='$users' AND (EXTRACT(MONTH FROM date)='$muaj' AND EXTRACT(YEAR FROM date)='$viti');");
							
							} elseif(!isset($_POST['ZgjedhMuaj']) && !isset($_POST['paguaj'])) {
								 $viti = date('Y');
								 $muaj = date('m');
								 $query = $db->query("SELECT rezervues, SUM(cost) AS sumaTotale, date, SUM(provision) AS provs
													FROM orders
													WHERE rezervues='$users' AND (EXTRACT(MONTH FROM date)='$muaj' AND EXTRACT(YEAR FROM date)='$viti');");
							}
							

			while($row = mysql_fetch_array($query)) {
				if (empty($row['rezervues'])) {
				 $rezervuesi = '----- -----';
				 $sumaTotale = '--';
				 $provizioni = '--';
				}
				else{
				 $rezervuesi = ucfirst($row['rezervues']);
				 $sumaTotale = $row['sumaTotale'];
				 $provizioni = substr($row['provs'], 0, -1);
				}
				
				if ($i % 2 != "0") # An odd row
				  $rowColor = "bgC1";
				else # An even row
		  		  $rowColor = "bgC2";	
				
		  		  $GjithsejProfit += $row['sumaTotale'];
		  		  $GjithsejProvis += $row['provs'];
		  		  $GjithsejPAProvis = $GjithsejProfit - $GjithsejProvis;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// HERE WE CHECK IF THE AGENT HAS PAID OR NOT HIS MONTHLY PROFIT		  		  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$check_agent_if_paid = mysql_fetch_array($db->query("SELECT * FROM agent_payments WHERE agent='$users' AND (month='$muaj' AND year='$viti');"));
if($check_agent_if_paid['paid'] == 'Y' && $check_agent_if_paid['month'] == $muaj && $check_agent_if_paid['year'] == $viti ) {
	$yes_or_no = 'E Paguar';
}else {
	$yes_or_no = '<form method="POST" action="">
				 		<input type="hidden" value="'.$users.'" name="username">
				 		<input type="hidden" value="'.$muaj.'" name="month">
				 		<input type="hidden" value="'.$viti.'" name="year">
						<input type="hidden" value="Y" name="statusi">
						<input type="submit" value="Paguaj" name="paguaj">
				</form>';
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////	  		  
		  		  $lista .= '
					<tr class="'.$rowColor.'">
						<td style="text-align:center;font-weight:bold;">'.$i.'</td>
						<td >'.$users.'</td>
							<td style="text-align:center;">
							'.$yes_or_no.'
							</td>
						<td style="text-align:right;">'.$provizioni.'  &euro;</td>
						<td style="text-align:right;">'.$sumaTotale.' &euro;</td>
					</tr>
					';
				$i++;
			}
	}
	
	return '
		<form action="" method="POST">
			
		<table cellspacing="1" cellpadding="5" border="0" style="margin: 10px 10px 0pt;">			
		<tr>
		<td><select name="muaj" class="selectDest">
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
				<option value="11">N�ntor</option>
				<option value="12">Dhjetor</option>
		</td></select>
		<td>
			<select name="viti" class="selectDest">
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
					<td width="80">Statusi</td>
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

static function edito($IDtoEdit='') {
global $db;
	
	global $db;

	$values = mysql_fetch_array($db->query("SELECT * FROM orders WHERE order_id = '$IDtoEdit';"));

// Variables that come from the database
	$emri 	  = $values['name'];					$mbiemri     = $values['surname'];
	$id 	  = $values['order_id'];				
	$data_e_nisjes = $values['date'];				$data_e_kthimit = $values['data_kthyese'];
	return '
<div class="WraperForForm">	
<form action="" method="post">
<input type="hidden" name="id_to_edit" value="'.$id.'">
<div class="elementsLabelBox">
		Emri:
</div>
<div class="elementsBox">
		<input type="text" id="emri" name="emri" value="'.$emri.'">
</div>

<div class="elementsLabelBox">
		Mbiemri:
</div>
<div class="elementsBox"> 
		<input type="text" id="mbiemri" name="mbiemri" value="'.$mbiemri.'">
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
	
			<label for="data1drejtim">Data e nisjes:</label>
</div>
<div class="elementsBox">
			<input type="text" id="data1drejtim" name="data1drejtim" value="'.$data_e_nisjes.'">
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
			<input type="text" id="dataKthyese" name="dataKthyese" >
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
		\'controlname\': \'dataKthyese\'
	}, A_CALTPL);
	</script>
			
</div>
</div>	




<div class="elementsLabelBox">
	Persona:
</div>
<div class="elementsBox" >
		<select name="persona">
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
		</select>
</div>

<div class="elementsBox">
</div>
<div class="elementsLabelBox">
</div>

<div class="elementsLabelBox">
		<label for="1drejtim">Nj� drejtim</label>
		<input type="radio" id="1drejtim" name="drejtimi"  value="nj� drejtim" onclick="toggleVisibility(\'hideThis\',0)">
<br/>
		<label for="1drejtim">Kthyese</label>
		<input type="radio" id="kthyese" name="drejtimi" checked="checked" value="kthyese"  onclick="toggleVisibility(\'hideThis\',1)">
</div>
	
	
	<input style="float:right;margin:15px 49px 0 0;" type="submit" value="Ruaj te dh�nat" name="editoket"  />
	

</form><!-- end of the reservation form-->
</div>
';
	
}	




//KTU SHKOJN FUNKSIONET QE DO TI SHEH AGJENTI
static function lista_per_agent() {
global $db,$act;
$username = $_SESSION['username'];
if(isset($_POST['dataZgjedhur']))  $dataZgjedhur = $_POST['dataZgjedhur'];	//selected date
if(isset($_POST['Anulo'])) $delete = $_POST['Anulo'];
if(isset($_POST['id'])) $PostedID = $_POST['id'];
if(isset($_POST['date'])) $PostedDATE = $_POST['date'];
if(isset($_POST['action'])) $action = $_POST['action'];
	
$i = 1; 
$cost = 0;

	//here we check if we clicked the Print button
	if(isset($PostedID) && $action == 'printo') {
		echo '<script type="text/javascript">
				<!--
				window.location = "GeneratePDF.php?id='.$PostedID.'"
				//-->
				</script>
		';
		exit();
	//here we check if we clicked the Edit button
	}elseif(isset($PostedID) && $action == 'edito'){
		return '<div id="Formulari">'.reservations::edito($PostedID).'</div>';
	//here we check if we already edited the reservation
	}elseif(isset($_POST['editoket'])) {
	
	// Variables that come from the Reservations form
	$emri 	  = $_POST['emri'];					$mbiemri     = $_POST['mbiemri'];
	$prej     =	$_POST['Prej'];					$KthyesePrej = $_POST['KthyesePrej'];
	$deri 	  =	$_POST['Deri'];					$KthyeseDeri = $_POST['KthyeseDeri'];
	$data     =	$_POST['data1drejtim'];			$dataKthyese = $_POST['dataKthyese'];
	$persona  = $_POST['persona'];
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
			return '<strong>Gabim n� zgjedhjen tuaj:</strong> Ju lutem zgjdhni daten e nisjes!';
			exit();
		} elseif(empty($dataKthyese) && !empty($data)) {
			return '<strong>Gabim n� zgjedhjen tuaj:</strong> Ju lutem zgjdhni daten e nisjes kthyese!';
			exit();
		}elseif(empty($data) && empty($dataKthyese)){
			return '<strong>Gabim n� zgjedhjen tuaj:</strong> Ju lutem zgjdhni datat e nisjeve!';
			exit();
		}elseif($data >= $dataKthyese){
			return '<strong>Gabim n� zgjedhjen tuaj:</strong> Data e kthimit nuk mundet te jet� para dat�s s� nisjes, ju lutem korigjoni gabimin!';
			exit(); 
		}elseif($data < date('Y-m-d') || $dataKthyese < date('Y-m-d')){
			return '<strong>Gabim n� zgjedhjen tuaj:</strong> data nuk mund te jet me heret se sot!';
			exit(); 			
		} else {
			$db->query("UPDATE orders SET
						name='$emri',surname='$mbiemri',prej='$prej',deri='$deri',KthyesePrej='$KthyesePrej',
						KthyeseDeri='$KthyeseDeri',date='$data',data_kthyese='$dataKthyese',persona='$persona',
						cost='$cmimiKthyes' WHERE order_id='$id'");
			$infos = funksionet::show_error('Ndryshimet e juaja jan� ruajtur me sukses!');
			$infos .=  '<a target="_blank" href="GeneratePDF.php?id='.$id.'">Gjenero tiket</a>';
		}
	return $infos;
		
	} elseif($drejtimi == 'nj� drejtim') {
		$db->query("UPDATE orders 
					SET name='$emri',surname='$mbiemri',prej='$prej',deri='$deri',
					date='$data',persona='$persona',cost='$cmimi' 
					WHERE order_id = '$id'") or die(mysql_error());	
		$infos = funksionet::show_error('Ndryshimet e juaja jan� ruajtur me sukses!');
		$infos .= '<a target="_blank" href="GeneratePDF.php?id='.$id.'">Gjenero tiket</a>';
	return $infos;	
	}
	
	}
	if(isset($dataZgjedhur)) {
		$PrejZgjedhur = $_POST['Prej'];
		$DeriZgjedhur = $_POST['Deri'];
		$query = $db->query("SELECT * FROM orders WHERE rezervues='$username' AND (prej='$PrejZgjedhur' AND deri='$DeriZgjedhur' AND date = '$dataZgjedhur')
							OR (KthyesePrej='$PrejZgjedhur' AND KthyeseDeri='$DeriZgjedhur' AND data_kthyese = '$dataZgjedhur')
							;") or die(mysql_error());
		$data = $dataZgjedhur;
	}elseif(isset($PostedID) && $action == 'delete'){
		$from = $_POST['from'];
		$to = $_POST['to'];
		$data = $_POST['datum'];
		$db->query("DELETE FROM orders WHERE order_id = $PostedID;");
		$query = $db->query("SELECT * FROM orders WHERE (prej='$from' AND deri='$to' AND date = '$data')
							OR (KthyesePrej='$from' AND KthyeseDeri='$to' AND data_kthyese = '$data')
							") or die(mysql_error());
		$error =  funksionet::show_error('Rezervimi u anulua me sukses!');
	}
	else { 
		return funksionet::filters_travelers().funksionet::show_error('Zgjedhni list�n e udh�tar�ve!');
		
		//$query = $db->query("SELECT * FROM orders WHERE date = curdate()") or die(mysql_error());
		//$dat = mysql_fetch_array($query);
		//$data = $dat['date'];
	}


$provisionTotal = '';
$lista = '';	
$error = '';
while ($row = mysql_fetch_array($query)) {
		
 $cost += $row['cost'];
 $provisionTotal += $row['provision'];
 $costNOPROVISION = $cost - $provisionTotal;
 $date = funksionet::formato_daten($data);
 if(empty($row['KthyesePrej']) && empty($row['KthyeseDeri'])) { 
 $arrow = '<img src="images/one_way.gif">';
 }else {
 $arrow = '<img src="images/two_ways.gif">';
 }
 $id = $row['order_id'];	
		if ($i % 2 != "0") # An odd row
		  $rowColor = "bgC1";
		else # An even row
  		  $rowColor = "bgC2";	
  	
	$lista .= 
	'<tr class="'.$rowColor.'"">
	<td style="text-align:center;"><strong>'.$i.'</strong></td>
	<td>'.$row['name'].' '.$row['surname'].'</td>
	<td style="text-align:center;">'.$row['prej'].' '.$arrow.' '.$row['deri'].'</td>
	<td  style="text-align:center;">'.$row['persona'].'</td>
	<!-- <td  style="text-align:center;"> '.$row['femij'].'</td> -->
		<td width="172"  style="text-align:center;">
			'.funksionet::list_actions($id,'delete','Anulo', $row['date'],$row['prej'],$row['deri']).
			  funksionet::list_actions($id,'printo','Printo', $row['date']).
			  funksionet::list_actions($id,'edito','Edito', $row['date']).
			'
		</td>
	<td style="text-align:right;">'.substr($row['provision'], 0, -1).' &euro;</td>
	<td style="text-align:right;">'.$row['cost'].' &euro;</td>
	</tr>
	';
	  $i++; 
}
return $error.funksionet::filters_travelers().'
		<table width="100%" style="margin:10px 10px 0 10px;" class="extra" cellspacing="1" cellpadding="5" border="0" >
	   <tr class="bgC3" style="font-weight:bold;">
	   		<td width="20" > </td>
	   		<td>Pasagjeri</td>
	   		<td> Destinacioni </td>
	   		<td width="20">Persona</td>
	   		<!-- <td width="20">F�mij</td> -->
	   		<td> Opsionet </td>
	   		<td>Provision</td>
	   		<td width="50">�mimi</td>
	   </tr>
	   '.$lista.'
	   </table>
	   
	   	<table style="margin:10px -10px 0 10px;float:right;" class="extra" cellspacing="1" cellpadding="5" border="0" >
		<tr class="bgC2">
			<td><strong>Data:</strong></td>
			<td>'.$date.'</td>
		</tr>
	</table>
	   
	   ';
	
}

static function profit_per_agent() {
	global $db;
	$i = 1;
	$GjithsejProfit ='';
	$GjithsejProvis ='';
	//here we make the years for filters
	$SelectYears	= '<option>Zgjidhe vitin:</option>';
	for ($vite = 2011; $vite <= 2050; $vite++) {
		$SelectYears	.= '<option value="'.$vite.'">'.$vite.'</option>';
	}
	
	$lista='';
	$username =  $_SESSION['username'];
	
			
							if(isset($_POST['ZgjedhMuaj'])) {
								$viti = $_POST['viti'];
								$muaj = $_POST['muaj'];
								$query = $db->query("SELECT rezervues, SUM(cost) AS sumaTotale, date, SUM(provision) AS provs
													FROM orders
													WHERE rezervues='$username' AND (EXTRACT(MONTH FROM date)='$muaj' AND EXTRACT(YEAR FROM date)='$viti' );");
							} else {
								 $viti = date('Y');
								 $muaj = date('m');
								 $query = $db->query("SELECT rezervues, SUM(cost) AS sumaTotale, date, SUM(provision) AS provs
													FROM orders
													WHERE rezervues='$username' AND (EXTRACT(MONTH FROM date)='$muaj' AND EXTRACT(YEAR FROM date)='$viti');");
							}

			while($row = mysql_fetch_array($query)) {
				if (empty($row['rezervues'])) {
				 $rezervuesi = '----- -----';
				 $sumaTotale = '0';
				 $provizioni = '0';
				}
				else{
				 $rezervuesi = ucfirst($row['rezervues']);
				 $sumaTotale = $row['sumaTotale'];
				 $provizioni = substr($row['provs'], 0, -1);
				}
				
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
						<td>'.ucfirst($username).'</td>
						<td style="text-align:right;">'.$provizioni.'  &euro;</td>
						<td style="text-align:right;">'.$sumaTotale.' &euro;</td>
					</tr>
					';
				$i++;
			}
			
	
	return '
		<form action="" method="POST">
			
		<table cellspacing="1" cellpadding="5" border="0" style="margin: 10px 10px 0pt;">			
		<tr>
		<td><select name="muaj" class="selectDest">
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
				<option value="11">N�ntor</option>
				<option value="12">Dhjetor</option>
		</td></select>
		<td>
			<select name="viti" class="selectDest">
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
	</table>
			';
	
}

}//endof reservations
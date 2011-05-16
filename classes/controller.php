<?php
class controller {
	
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
		return 'lista';
		break;
		
		default:
			return 'rezervo';;
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
if($drejtimi = 'kthyese') {
$db->query("INSERT INTO orders 
				   (name,surname,prej,deri,KthyesePrej,KthyeseDeri,date,data_kthyese,cost) 
			VALUES ('$emri','$mbiemri','$prej','$deri','$KthyesePrej','$KthyeseDeri','$data','$dataKthyese','$cmimiKthyes')") or die(mysql_error());
} else {
$db->query("INSERT INTO orders 
				   (name,surname,prej,deri,date,cost) 
			VALUES ('$emri','$mbiemri','$prej','$deri','$data','$cmimi')") or die(mysql_error());	
}

echo 'Ju keni rezervuar nje udhetim me keto te dhena:<br />';
echo 'Drejtimi: '.$drejtimi.'<br />';
echo 'Prej: '.$prej.'<br />';
echo 'Deri: '.$deri.'<br />';
echo 'Data: '.$data.'<br />';
echo 'Data kthyese:'.$dataKthyese.'<br />';
echo '&Ccedil;mimi: '.$cmimi.'<br />';
echo '<a href="GeneratePDF.php">Gjenero tiket</a>';
}else {
	return '
	
	
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
';
	} 	
	
}	
	
}//endof Modelet

?>
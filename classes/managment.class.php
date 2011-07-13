<?php
class managment {
	
static function destinations(){
global $db;
	
	if(isset($_POST['new_dest'])) {
		$postedNAME = $_POST['prej'];				
		$newCITY	= $_POST['new_city'];
		$cost = $_POST['cost'];
		$return_cost = $_POST['return_cost'];
			$results = mysql_fetch_array($db->query("SELECT * FROM costs WHERE prej='$postedNAME' AND deri='$newCITY';"));
				if ($results['prej'] == $postedNAME && $results['deri'] == $newCITY) {
					$error = funksionet::show_error("Destinacioni prej $postedNAME deri $newCITY egziston!");
				}else{
					$db->query("INSERT INTO costs (prej,deri,cost,return_cost,date) VALUES ('$postedNAME', '$newCITY','$cost','$return_cost',NOW());");	
					$db->query("INSERT INTO costs (deri,prej,cost,return_cost,date) VALUES ('$postedNAME', '$newCITY','$cost','$return_cost',NOW());");			
				}
	}
		
	
	$result = $db->query("SELECT * FROM destinations WHERE direction=1;");
	$table='';
	$error='';
	while ($rows = mysql_fetch_array($result)) {
		$name = $rows['name'];
		$table .=  '<div class="destionations">
				<div class="name">Prej: <strong>'.$name.'</strong></div>
				<table width="100%"  class="extra" cellspacing="1" cellpadding="5" border="0" >
				<tr class="bgC3" style="font-weight:bold">
					<td width="20"></td>
					<td>Deri</td>
					<td width="90">Një drejtim</td>
					<td width="90">Kthyese</td>
					'.managment::cmimet_e_caktuara($name).'
				</tr>
				</table>
						<div class="buttoni">
							<form action="" method="POST">
							<label for="new_city">Deri:</label>							
							<select name="new_city">
								'.funksionet::directions(2).'
							</select>
							<label for="cost">Çmimi:</label>
							<input type="text" name="cost" size="3">
							<label for="cost"><img src="images/two_ways.gif"></label>
							<input type="text" name="return_cost" size="3">
							<input type="hidden" name="prej" value="'.$name.'"> 
							<input type="submit" name="new_dest" value="Shto Destinacionin">
							</form>
						</div>
				</div>';
	}
	return $error.$table;	
}
/////////////////////////////////////////////////////////////////////////////////////
static function cmimet_e_caktuara($name='') {
	
	global $db;	
		$i=1;
		$query  = $db->query("SELECT * FROM costs WHERE prej='$name';");
		$list='';
		while ($row = mysql_fetch_array($query)) {
				if ($i % 2 != "0") # An odd row
				  $rowColor = "bgC1";
				else # An even row
		  		  $rowColor = "bgC2";
			$deri = $row['deri'];
			$cost = $row['cost'];
			$return_cost = $row['return_cost'];
			$list .= '<tr class="'.$rowColor.'">
							<td style="font-weight:bold;text-align:center;">'.$i.'</td>
							<td>'.$deri.'</td>
							<td style="font-weight:bold;text-align:right;">'.$cost.' &euro;</td>
							<td style="font-weight:bold;text-align:right;">'.$return_cost.' &euro;</td>
					</tr>';
			$i++;
		}
		return $list;
}

static function stacionet() {
global $db;
	if (isset($_POST['delete_city'])) {
		$prejORderi = $_POST['prej_or_deri'];
		$city = $_POST['city'];
		$error = funksionet::show_error('Qyteti '.$city.' eshte fshir me sukses nga databaza!');
		$db->query("DELETE FROM destinations WHERE name='$city'");
		$db->query("DELETE FROM costs WHERE $prejORderi='$city'") or die(mysql_error());
	}
	
	if (isset($_POST['new_dest'])) {
		$qyteti = $_POST['new_city'];
		$direk = $_POST['direction'];
		$db->query("INSERT INTO destinations (name,direction) VALUES ('$qyteti','$direk');");
		return funksionet::show_error('U shtua destinacioni me emrin <u>'.$qyteti.'</u>.');
	}else{ 
	
	$numri1 = $db->query("SELECT * FROM destinations WHERE direction='1';");
	$numri2 = $db->query("SELECT * FROM destinations WHERE direction='2';");
		$i = 1;
		$direction1='';
		$direction2='';
		$error='';
		while ($row = mysql_fetch_array($numri1)) {
			if ($i % 2 != "0") # An odd row
			  $rowColor = "bgC1";
			else # An even row
	  		  $rowColor = "bgC2";
  		  	
			$direction1 .= '<tr class="'.$rowColor.'">
								<td style="text-align:center;"><strong>'.$i.'</strong></td>
								<td>'.$row['name'].'</td>
								<td style="text-align:center;">
									<form action="" method="POST">
									<input type="hidden" name="prej_or_deri" value="prej">
									<input type="hidden" name="city" value="'.$row['name'].'">
									<input type="submit" name="delete_city" value="Fshij">
									</form>
								</td>
							</tr>';
		$i++;
		}
		
		$i = 1;
		while ($row = mysql_fetch_array($numri2)) {
			if ($i % 2 != "0") # An odd row
			  $rowColor = "bgC1";
			else # An even row
	  		  $rowColor = "bgC2";
  		  	
			$direction2 .= '<tr class="'.$rowColor.'">
								<td style="text-align:center;"><strong>'.$i.'</strong></td>
								<td>'.$row['name'].'</td>
								<td style="text-align:center;">
									<form action="" method="POST">
									<input type="hidden" name="prej_or_deri" value="deri">
									<input type="hidden" name="city" value="'.$row['name'].'">
									<input type="submit" name="delete_city" value="Fshij">
									</form>
								</td>
							</tr>';
		$i++;
		}
		
		
		$table1 =  '<div class="cities">
					<table width="100%"  class="extra" cellspacing="1" cellpadding="5" border="0" >
					<tr class="bgC3" style="font-weight:bold;">
						<td></td>
						<td>Udhëtime Prej</td>
						<td width="20" >Opsionet</td>
					</tr>
					'.$direction1.'
					</table>
						<div class="buttoni">
							<form action="" method="POST">	
							<label for="new_city">Qyteti:</label>						
							<input type="text" name="new_city">
							<input type="hidden" name="direction" value="1"> 
							<input type="submit" name="new_dest" value="Shto Qytetin">
							</form>
						</div>
					</div>';
		$table2 = '<div class="cities">
					<table width="100%"  class="extra" cellspacing="1" cellpadding="5" border="0" >
					<tr class="bgC3" style="font-weight:bold;">
						<td></td>
						<td>Udhëtime Deri</td>
						<td width="20" >Opsionet</td>
					</tr>
					'.$direction2.'
					</table>
						<div class="buttoni">
							<form action="" method="POST">
							<label for="new_city">Qyteti:</label>							
							<input type="text" name="new_city">
							<input type="hidden" name="direction" value="2"> 
							<input type="submit" name="new_dest" value="Shto Qytetin">
							</form>
						</div>
					</div>';
		
		return $error.$table1.$table2;
		
	}	
}

static function udhetimet() {
global $db;
$lista = '';
$i=1;	

$result = $db->query("SELECT * FROM available_trips;");
while($rows = mysql_fetch_array($result)) {
		if ($i % 2 != "0") # An odd row
		  $rowColor = "bgC1";
		else # An even row
  		  $rowColor = "bgC2";
$lista .=	'<tr class="'.$rowColor.'"">
				<td  style="text-align:center;font-weight:bold;">'.$i.'</td>
				<td>'.$rows['prej'].'</td>
				<td>'.$rows['deri'].'</td>
				<td>'.funksionet::formato_daten($rows['data']).'</td>
				<td  style="text-align:center;">'.$rows['vende'].'</td>	 
				</tr>';
$i++;
}
return	'<table width="100%" style="margin:10px 10px 0 10px;" class="extra" cellspacing="1" cellpadding="5" border="0" >
		   <tr class="bgC3" style="font-weight:bold;">
	   		<td width="20" > </td>
	   		<td>Prej</td>
	   		<td>Deri</td>
	   		<td width="50">Data</td>
	   		<td width="50">Vende</td>
	  	   </tr>
	  	   '.$lista.'
		</table>';
}
	
}//endof managment

?>
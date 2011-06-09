<?php
class managment {
	
function destinations(){
	global $db;
	
	
	if (isset($_POST['new_dest'])) {
		$qyteti = $_POST['new_city'];
		$direk = $_POST['direction'];
		$db->query("INSERT INTO destinations (name,direction) VALUES ('$qyteti','$direk');");
		return funksionet::show_error('U shtua destinacioni me emrin <u>'.$qyteti.'</u>.');
	}else{ 
	
	$numri1 = $db->query("SELECT * FROM destinations WHERE direction='1';");
	$numri2 = $db->query("SELECT * FROM destinations WHERE direction='2';");
		$i = 1;
		while ($row = mysql_fetch_array($numri1)) {
			if ($i % 2 != "0") # An odd row
			  $rowColor = "bgC1";
			else # An even row
	  		  $rowColor = "bgC2";
  		  	
			$direction1 .= '<tr class="'.$rowColor.'">
								<td style="text-align:center;"><strong>'.$i.'</strong></td>
								<td>'.$row['name'].'</td>
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
							</tr>';
		$i++;
		}
		
		
		$table1 =  '<div class="destionations">
					<table width="100%"  class="extra" cellspacing="1" cellpadding="5" border="0" >
					<tr class="bgC3" style="font-weight:bold;">
						<td></td>
						<td>Udhëtime Prej</td>
					</tr>
					'.$direction1.'
					</table>
						<div class="buttoni">
							<form action="" method="POST">							
							<input type="text" name="new_city">
							<input type="hidden" name="direction" value="1"> 
							<input type="submit" name="new_dest" value="Shto destinacionin">
							</form>
						</div>
					</div>';
		$table2 = '<div class="destionations">
					<table width="100%"  class="extra" cellspacing="1" cellpadding="5" border="0" >
					<tr class="bgC3" style="font-weight:bold;">
						<td></td>
						<td>Udhëtime Deri</td>
					</tr>
					'.$direction2.'
					</table>
						<div class="buttoni">
							<form action="" method="POST">							
							<input type="text" name="new_city">
							<input type="hidden" name="direction" value="2"> 
							<input type="submit" name="new_dest" value="Shto destinacionin">
							</form>
						</div>
					</div>';
		
		return $table1.$table2;
		
	}
}
/////////////////////////////////////////////////////////////////////////////////////
function cmimet() {
	global $db;
	$query  = $db->query("SELECT * FROM costs;");
	$i = 1;
		while ($row = mysql_fetch_array($query)) {
				if ($i % 2 != "0") # An odd row
				  $rowColor = "bgC1";
				else # An even row
		  		  $rowColor = "bgC2";	
			$lista .= '<tr class="'.$rowColor.'">
							<td width="20" style="font-weight:bold;text-align:center;">'.$i.'</td>
							<td>'.$row['prej'].'</td>
							<td>'.$row['deri'].'</td>
							<td width="60" style="font-weight:bold;text-align:center;">'.$row['cost'].' &euro;</td>
						</tr>';
			$i++;
		}
		
		$cmimet = '<table width="100%" style="margin:10px 10px 0 10px;float:left;" class="extra" cellspacing="1" cellpadding="5" border="0" >
				<tr class="bgC3" style="font-weight:bold;">
					<td></td>
					<td>Prej</td>
					<td>Deri</td>
					<td>Çmimi</td>
				</tr>
				'.$lista.'	
				</table>';
	
	return $cmimet;
}
	
}//endof managment

?>
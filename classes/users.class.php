<?php

class users_class{
	

function users($roli) {
	
	global $db;
	$i = 1;	
	$delete = $_POST['delete'];
	$edit = $_POST['edit'];

	if(isset($_POST['user_edited'])) {
		//variables coming from the form
		$emri		=	$_POST['emri'];				$mbiemri	=	$_POST['mbiemri'];
		$pseudonimi	=	$_POST['pseudonimi'];		$fjalkalmi	=	md5($_POST['fjalkalimi']);
		$adresa		=	$_POST['adresa'];			$roli		=	$_POST['roli'];
		$id 		=	$_POST['id'];				$sel_provis =	'0.'.$_POST['selected_provis'];
		$db->query("UPDATE users 
					SET firstname='$emri', lastname='$mbiemri', username='$pseudonimi', password='$fjalkalmi', address='$adresa',selected_provis='$sel_provis' , status='$roli' WHERE user_id='$id' ") or die(mysql_error());
	
	}elseif(isset($delete)) {
		$id = $_POST['id'];
		$db->query("DELETE FROM users WHERE user_id = '$id'");
		$error = funksionet::show_error("Përdoruesi që keni zgjedhur është fshir nga sistemi me sukses!");
	}elseif(isset($edit)) {
	
		
		$id = $_POST['id'];
		$row = mysql_fetch_array($db->query("SELECT * FROM users WHERE user_id='$id'"));
		return '
		<div id="Formulari">
		<form action="" method="post">
		<table cellpading="4" cellspacing="5">
		<tr>
			<td style="text-align:right;">Pseudonimi:</td>
			<td><input type="text" name="pseudonimi" value="'.$row['username'].'"></td>
		</tr>
		<tr>
			<td style="text-align:right;">Fjalkalimi:</td>
			<td><input type="password" name="fjalkalimi" value=""></td>
		</tr>
		<tr>
			<td style="text-align:right;">Emri:</td>
			<td><input type="text" name="emri" value="'.$row['firstname'].'"></td>
		</tr>
		<tr>
			<td style="text-align:right;">Mbiemri:</td>
			<td><input type="text" name="mbiemri" value="'.$row['lastname'].'"></td>
		</tr>
		<tr>
			<td style="text-align:right;">Adresa:</td>
			<td><input type="text" name="adresa"  value="'.$row['address'].'"></td>
		</tr>
		<tr >
			<td style="text-align:right;">Provisioni:</td>
			<td style="text-align:left;"><input type="text" name="selected_provis" size="3" value="'.str_replace("0.", "", $row['selected_provis']).'"> %</td>
		</tr>
		<tr>
			<td style="text-align:right;">Roli:</td>
			<td>
				<select style="width:150px;" name="roli">
					<option value="">Zgjidhe rolin:</option>
					<option value="admin">Administrator</option>
					<option value="agent">Agent</option>
				</select>
			</td>
		</tr>
		</table>
		<input type="hidden" name="id" value="'.$row['user_id'].'">
		<input type="submit" value="Ruaj ndryshimet" name="user_edited" style="float:right;margin-right:10px;">
		</form>
		</div>
		';
	}



  		 $query = $db->query("SELECT * FROM users WHERE status = '$roli'");
	
		while($row = mysql_fetch_array($query)) { 
		if ($i % 2 != "0") # An odd row
		  $rowColor = "bgC1";
		else # An even row
  		  $rowColor = "bgC2";
			
		//variables that come from the database
		$firstname = $row['firstname'];			$lastname = $row['lastname'];
		$address   = $row['address'];			$username = $row['username'];
		$status    = $row['status'];			$sel_prov = $row['selected_provis'];
	
		if($_GET['submenu'] == "agjentet") {
			$provisTR = '<td>'.str_replace("0.","",$sel_prov).' %</td>';
		}
		$users .= '<tr class="'.$rowColor.'">
				<td style="text-align:center;"><strong>'.$i.'</strong></td>
				<td>'.$firstname.'</td>
				<td>'.$lastname.'</td>
				<td>'.$username.'</td>
				<td>'.$address.'</td>
				'.$provisTR.'
				<td width="118">
					<form action="" method="post" style="float:left;">
					<input type="hidden" name="id" value="'.$row['user_id'].'">
					<input type="submit" name="delete" value="Fshije">
					</form>
					<form action="" method="post" style="float:left;">
					<input type="hidden" name="id" value="'.$row['user_id'].'">
					<input type="submit" name="edit" value="Edito">
					</form>
				</td>
			</tr>		
	     	';
		$i++;
		} 
		
/////////////////////////////////// HERE WE CHECK IF THE NEW USER FORM IS SUBMITTED
if (isset($_POST['new_user'])) {
	$username = $_POST['pseudonimi'];					$password = md5($_POST['fjalkalimi']);
	$name	  = ucfirst($_POST['emri']);				$surname  = ucfirst($_POST['mbiemri']);
	$roli 	  = $_POST['tipi_i_rolit'];					$adress	  = ucfirst($_POST['adresa']);
	$provis   = '0.'.$_POST['provis'];
	$db->query("INSERT INTO users (firstname,lastname,address,username,password,status,selected_provis)
				VALUES ('$name','$surname','$adress','$username','$password','$roli','$provis')");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// HERE WE CHECK IF WE ARE ON THE AGENTS SUBMENU OR ADMINS SUBMENU	
	if($_GET['submenu'] == 'agjentet'){
 		$formulari = funksionet::formulari_new_user("Agjentin","agent");
 		$usertype = "Agjent";
 		$width = 'width: 163px;';
 		
 	}else { 
 		$formulari = funksionet::formulari_new_user("Administratorin","admin");
 		$usertype = "Administrator";
 		$width = 'width: 213px;';
 	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		if($_GET['submenu'] == "agjentet") {
			$provisTDH = '<td width="20">Provisioni</td>';
		}
 	return '<a href="#" class="lightbox"><div class="AddNewAgent" style="'.$width.'"><img style="margin:5px;border:0;" src="images/add_user.png">
			<span class="addUSERtxt">Shto '.$usertype.' të rij</span>
			</div></a>
			<div class="backdrop"></div><div class="box"><div class="close">x</div>'.$formulari.'</div>
			'.$error.'
			<table width="100%" style="margin:10px 10px 0 10px;" class="extra" cellspacing="1" cellpadding="5" border="0" >
			<tr class="bgC3" style="font-weight:bold;">
				<td></td>
				<td>Emri</td>
				<td>Mbiemri</td>
				<td>Pseudonimi</td>
				<td>Adresa</td>
				'.$provisTDH.'
				<td>Opsionet</td>
				'.$users.'
			</tr>
			</table>';
			
	
}
}

?>
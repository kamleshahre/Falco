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
		$id 		=	$_POST['id'];
		$db->query("UPDATE users 
					SET firstname='$emri', lastname='$mbiemri', username='$pseudonimi', password='$fjalkalmi', address='$adresa', status='$roli' WHERE user_id='$id' ") or die(mysql_error());
	
	}elseif(isset($delete)) {
		$id = $_POST['id'];
		$db->query("DELETE FROM users WHERE user_id = '$id'");
		return funksionet::show_error("Përdoruesi që keni zgjedhur është fshir nga sistemi me sukses!");
	}elseif(isset($edit)) {
	
		
		$id = $_POST['id'];
		$row = mysql_fetch_array($db->query("SELECT * FROM users WHERE user_id='$id'"));
		return '
		<div id="Formulari">
		<form action="" method="post">
		<table cellpading="4" cellspacing="5">
		<tr>
			<td>Pseudonimi:</td>
			<td><input type="text" name="pseudonimi" value="'.$row['username'].'"></td>
		</tr>
		<tr>
			<td>Fjalkalimi:</td>
			<td><input type="password" name="fjalkalimi" value=""></td>
		</tr>
		<tr>
			<td>Emri:</td>
			<td><input type="text" name="emri" value="'.$row['firstname'].'"></td>
		</tr>
		<tr>
			<td>Mbiemri:</td>
			<td><input type="text" name="mbiemri" value="'.$row['lastname'].'"></td>
		</tr>
		<tr>
			<td>Adresa:</td>
			<td><input type="text" name="adresa"  value="'.$row['address'].'"></td>
		</tr>
		<tr>
			<td>Roli:</td>
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
		$status    = $row['status'];
	
		$users .= '<tr class="'.$rowColor.'">
				<td style="text-align:center;"><strong>'.$i.'</strong></td>
				<td>'.$firstname.'</td>
				<td>'.$lastname.'</td>
				<td>'.$username.'</td>
				<td>'.$address.'</td>
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
	$yes = $_POST['tipi_i_rolit'];
	$db->query("INSERT INTO users (firstname,lastname,address,username,password,status)
				VALUES ('test','test','test','test','test','$yes')");
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
	return '<a href="#" class="lightbox"><div class="AddNewAgent" style="'.$width.'"><img style="margin:5px;border:0;" src="images/add_user.png">
			<span class="addUSERtxt">Shto '.$usertype.' të rij</span>
			</div></a>
			<div class="backdrop"></div><div class="box"><div class="close">x</div>'.$formulari.'</div>
			<table width="100%" style="margin:10px 10px 0 10px;" class="extra" cellspacing="1" cellpadding="5" border="0" >
			<tr class="bgC3" style="font-weight:bold;">
				<td></td>
				<td>Emri</td>
				<td>Mbiemri</td>
				<td>Pseudonimi</td>
				<td>Adresa</td>
				<td>Opsionet</td>
				'.$users.'
			</tr>
			</table>';
			
	
}
}

?>
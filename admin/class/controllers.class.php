<?php
/*
 * 
 * Here down go all functions that handle the actions of pages and subpages 
 * 
 */

class page_functions {

public function pages_action_switcher() {
	global $action;
	switch ($action) {
		case 'edit':
		$DoIt =  page_functions::edit_page();
		break;
		
		case 'delete':
		$DoIt = page_functions::delete_page();
		break;
		
		case 'newsp':
		$DoIt =  page_functions::new_subpage();
		break;
		
		case 'newp':
		$DoIt =  page_functions::new_page();
		break;
		
		case 'editsp':
		$DoIt =  page_functions::edit_spage();
		break;

		case 'deletesp':
		$DoIt =  page_functions::delete_spage();
		break;
		
		
		default:
		$DoIt =  '';
		break;
	}
	return $DoIt;
}	
	
	
function edit_page() {
	global $db;
	$navigation = $_POST['navigation'];
	$content = $_POST['content'];
	$id = $_POST['id'];
	$idToSelect = $_GET['id'];
	
	$rows = $db->query("SELECT id,name_en,txt_en FROM navigation WHERE showing = 'Y' AND id='$idToSelect';"); 
	if(isset($_POST['save'])) {
		$db->query("UPDATE navigation SET name_en = '$navigation', txt_en = '$content' WHERE id = '$id';");
		return 'Editing saved';
	} else {
		while ($row = mysql_fetch_array($rows)) {
			return '	
			<div id="contain">
					<form method="post" id="customForm" action="index.php?page=pages&id='.$row['id'].'&act=edit">
						<div>
							<label for="name">Navigation</label>
							<input id="name" name="navigation" type="text" value="'.$row['name_en'].'" />
						</div>
						<div>
							<label for="content">Content</label>
							<textarea id="content" name="content" cols="" rows="" >'.$row['txt_en'].'</textarea>
						</div>
						<div>
							<input type="hidden" name="id" id="id" value="'.$_GET['id'].'">
							<input id="send" name="save" type="submit" value="Save" />
						</div>
					</form>
				</div>
			';
		}
	}
}

function edit_spage() {
	global $db;
	$subnavigation = $_POST['subnavigation'];
	$content = $_POST['content'];
	$id = $_POST['id'];
	$sid = $_POST['sid'];
	$idToSelect = $_GET['id'];
	$sidToSelect = $_GET['sid'];
	
	$rows = $db->query("SELECT id,s_name_en,txt_en,navi_id FROM subnavigation WHERE showing = 'Y' AND navi_id='$idToSelect' AND id='$sidToSelect';"); 
	if(isset($_POST['save'])) {
		$db->query("UPDATE subnavigation SET s_name_en = '$subnavigation', txt_en = '$content' WHERE navi_id='$id' AND id = '$sid';");
		return 'Editing saved';
	} else {
		while ($row = mysql_fetch_array($rows)) {
			return '	
			<div id="contain">
					<form method="post" id="customForm" action="index.php?page=pages&id='.$_GET['id'].'&sid='.$_GET['sid'].'&act=editsp">
						<div>
							<label for="name">Subnavigation</label>
							<input id="name" name="subnavigation" type="text" value="'.$row['s_name_en'].'" />
						</div>
						<div>
							<label for="content">Content</label>
							<textarea id="content" name="content" cols="" rows="" >'.$row['txt_en'].'</textarea>
						</div>
						<div>
							<input type="hidden" name="id" id="id" value="'.$_GET['id'].'">
							<input type="hidden" name="sid" id="sid" value="'.$_GET['sid'].'">
							<input id="send" name="save" type="submit" value="Save" />
						</div>
					</form>
				</div>
			';
		}
	}	
	
}

function delete_page() {
global $db, $id;
$del = $db->query("DELETE n, sn from navigation n
                  LEFT JOIN subnavigation sn ON (n.id = sn.navi_id)
              	  WHERE n.id = '$id'");
return 'Deleted Succesfully';
}

function delete_spage() {
global $db, $id, $sid;
$del = $db->query("DELETE FROM subnavigation
              	  WHERE id = '$sid' AND navi_id = '$id'");
return 'Deleted Succesfully';	
}

function new_subpage() {
global $db, $id;
$subnavigation = $_POST['subnavigation'];
$content = $_POST['content'];

if(isset($_POST['save'])) {
		$db->query("INSERT INTO subnavigation (s_name_en, txt_en, navi_id)
					VALUES ('$subnavigation', '$content', '$id') ;");
		return 'New subpage created sucessfuly';
} else {

			return '
			<div id="contain">
					<form method="post" id="customForm" action="index.php?page=pages&id='.$id.'&act=newsp">
						<div>
							<label for="name">Subnavigation</label>
							<input id="name" name="subnavigation" type="text" />
						</div>
						<div>
							<label for="content">Content</label>
							<textarea id="content" name="content" cols="" rows="" ></textarea>
						</div>
						<div>
							<input type="hidden" name="id" id="id" value="'.$id.'">
							<input id="send" name="save" type="submit" value="Save" />
						</div>
					</form>
				</div>
			';
}
}

function new_page() {
global $db;
$subnavigation = $_POST['navigation'];
$content = $_POST['content'];

if(isset($_POST['save'])) {
		$db->query("INSERT INTO navigation (name_en, txt_en)
					VALUES ('$subnavigation', '$content') ;");
		return 'New page was created sucessfuly <a href="javascript:history.go(-1)">Back</a>';
} else {
			return '
			<div id="contain">
					<form method="post" id="customForm" action="index.php?page=pages&act=newp">
						<div>
							<label for="name">Navigation</label>
							<input id="name" name="navigation" type="text" />
						</div>
						<div>
							<label for="content">Content</label>
							<textarea id="content" name="content" cols="" rows="" ></textarea>
						</div>
						<div>
							<input id="send" name="save" type="submit" value="Save" />
						</div>
					</form>
				</div>
			';
}	
	
}
	
}// class page_functions







/*
 * 
 * Here down goes everything about blogs 
 * 
 */

class blog {
	
public function blog_action_switcher() {
	global $action;
	switch ($action) {

		case 'editart':
		$DoIt =  blog::edit_article();
		break;

		case 'deleteart':
		$DoIt =  blog::delete_article();
		break;
		
		
		default:
		$DoIt =  '';
		break;
	}
	return $DoIt;
}		
	
	
function delete_article() {
global $db, $id;
$del = $db->query("DELETE FROM blog WHERE id = '$id'");
return 'Aritcle deleted Succesfully';
}

function edit_article() {
	global $db;
	$title = $_POST['title'];
	$content = $_POST['content'];
	$id = $_POST['id'];
	$idToSelect = $_GET['id'];
	
	$rows = $db->query("SELECT * FROM blog WHERE id='$idToSelect';"); 
	if(isset($_POST['save'])) {
		$db->query("UPDATE blog SET title = '$title', text = '$content' WHERE id = '$id';");
		return 'Article editing saved';
	} else {
		while ($row = mysql_fetch_array($rows)) {
			return '	
			<div id="contain">
					<form method="post" id="customForm" action="index.php?page=blog&id='.$row['id'].'&act=editart">
						<div>
							<label for="name">Title</label>
							<input id="name" name="title" type="text" value="'.$row['title'].'" />
						</div>
						<div>
							<label for="content">Content</label>
							<textarea id="content" name="content" cols="" rows="" >'.$row['text'].'</textarea>
						</div>
						<div>
							<input type="hidden" name="id" id="id" value="'.$_GET['id'].'">
							<input id="send" name="save" type="submit" value="Save" />
						</div>
					</form>
				</div>
			';
		}
	}
}

	
}// class blog
?>
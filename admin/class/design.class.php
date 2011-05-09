<?php


class HTML {
	
public function head() {
global $page;
return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>'.NAME.' | '.strtoupper($page).'</title>
<meta name="robots" content="NOINDEX, NOFOLLOW" />
<meta name="author" content="'.AUTHOR.'" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/general.css" type="text/css" media="screen" />

</head>
<body>
<div class="container">';
	
}	


public function footer() {
	
return '

</div><!-- end of container -->
</body>';
	
}




public function LeftSide() {
	
	return '<div id="leftside">
<div class="logo"></div>
	<ul id="mainNav">
	'.$this->menu().'        	
	</ul>
</div>';
	
}


public function RightSideTop() {
	return '
	<div id="rightsidetop">
	<div class="infotop">
	<h2>Welcome  USERNAME*</h2><br><p>What would you like to do today?</p>
	<div class="rightLinksTop"><a target="_new" href="'.WEB_URL.'">View The Site</a> | <a href="logout.php">Logout</a></div>
	</div></div>'; //TODO to link the name with the username from the session
}

public function RightSide() {
	return '
<div id="rightside">
<div class="pages">
	'.$this->pages().'
</div>
</div>';
	
}


public function menu(){
return '
<li><a href="index.php?page=dashboard"><img src="css/img/dashboard.png" alt="dashboard"><span style="margin-left: 10px; vertical-align: super;">DASHBOARD</span></a></li> <!-- Use the "active" class for the active menu item  -->
<li><a href="index.php?page=pages"><img src="css/img/pages.png" alt="pages"><span style="margin-left: 10px; vertical-align: super;">PAGES</span></a></li>
<li><a href="index.php?page=blog"><img src="css/img/blog.png" alt="blog"><span style="margin-left: 10px; vertical-align: super;">BLOG</span></a></li>
<li><a href="index.php?page=mail"><img src="css/img/mail.png" alt="email"><span style="margin-left: 10px; vertical-align: super;">MAIL</span></a></li>
<li><a href="index.php?page=faq"><img src="css/img/faq.png" alt="faq"><span style="margin-left: 10px; vertical-align: super;">FAQ</span></a></li>';
}


//everything in the RIGHT SIDE (PAGES) IS DOWN 
	
public function pages() {
	global $page;
	switch ($page) {
		case 'dashboard':
		$show_page =  '<h2>This is the dashboard....</h2>';
		break;
		
		case 'pages':
		$show_page =  $this->public_pages();
		break;
		
		case 'blog':
		$show_page =  $this->blog();
		break;
		
		case 'mail':
		$show_page =  '<h2>This is the mail ....</h2>';
		break;
		
		case 'faq':
		$show_page =  '<h2>This is the FAQ ....</h2>';
		break;
		
		default:
		$show_page =  '<h2>This is the dashboard....</h2>';
		break;
	}
	return $show_page;
}



public function public_pages() {
global $db,$action;

if(empty($action)) {
		$id = $_GET['id'];
		$navigation = '';
	
		$rows = $db->query("SELECT id, name_en FROM navigation;");
		$rowsSub = $db->query("SELECT id,s_name_en,navi_id FROM subnavigation WHERE navi_id = '$id'");
		
		while ($row = mysql_fetch_array($rows) ) {
			
	//here checks if the there is a subnavigation open or not	
	if (empty($id) || $id != $row['id']) {
		$open = '&id='.$row['id'];
		} else {
		$open = NULL;
		}
			
		$navigation .= '<div class="pagesbg">
								<a href="index.php?page=pages'.$open.'"><img alt="show the subnavigation" src="css/img/open.gif" class="open"></a>
								<a href="index.php?page=pages&id='.$row['id'].'&act=edit"><img alt="edit page" src="css/img/edit.png" class="ics"></a>
								<a href="index.php?page=pages&id='.$row['id'].'&act=delete"><img alt="Delete page" src="css/img/delete.png" class="ics"></a>
								<a href="index.php?page=pages&id='.$row['id'].'&act=newsp"><img alt="create new subpage" src="css/img/add.png" class="ics"></a>
								<p class="navi">'.$row['name_en'].'</p>
						</div>';
			
			//here checks if the the id of the page that is opened is the same as the id in the parameters then it will open below the subpage
			if ($_GET['id'] == $row['id']) {	
					while ($rowS = mysql_fetch_array($rowsSub)) {
							$navigation .= '<div class="subpagesbg">
											<a href="index.php?page=pages&id='.$row['id'].'&sid='.$rowS['id'].'&act=editsp"><img class="ics" src="css/img/edit.png" alt="edit page" /></a>
											<a href="index.php?page=pages&id='.$row['id'].'&sid='.$rowS['id'].'&act=deletesp"><img class="ics" src="css/img/delete.png" alt="Delete page" /></a>
											<p class="navi greyfont">'.$rowS['s_name_en'].'</p>
											</div>';
					}
			}
		} 
	return $navigation.'<div class="newpage"><a href="index.php?page=pages&act=newp">Add new page</a></div>';
	} elseif(!empty($action)) {
		return page_functions::pages_action_switcher();
	}
}


//here we handle the blog section
public function blog() {
global $db,$action;
if(empty($action)) {
	$sql = $db->query("SELECT * FROM blog LIMIT 900");
	$articles = '';
	while ($row = mysql_fetch_array($sql)) {
	$length = 190;	
	$articles .= '<li class="article"><h1>'.$row['title'].'<a title="Edit" href="index.php?page=blog&id='.$row['id'].'&act=editart" style="float:right;"><img src="css/img/article_edit.png" /></a>
																<a title="Delete" href="index.php?page=blog&id='.$row['id'].'&act=deleteart" style="float:right;"><img src="css/img/article_delete.png" /></a></h1>
									 <div class="blogTXT">'.substr($row['text'], 0, $length).'</div></li>';
	}
	return '<ul>'.$articles.'</ul>';
	} elseif(!empty($action)) {
		return blog::blog_action_switcher();
	} else {
		
		return 'ERROR';
	}
}
}// class HTML







?>
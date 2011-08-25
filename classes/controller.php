<?php
class controller {
	
	
function menu_switcher() {
global $page;	
	switch ($page) {
			case 'rezervimet':
			return $this->rezervimet_switcher();
			break;
			
			case 'perdoruesit':
			return $this->perdoruesit_switcher();
			break;
			
			case 'menaxhment':
			return $this->menaxhment_switcher();
			break;			
			
			default:
			return $this->rezervimet_switcher();
			break;
		}
		
	}
	
function rezervimet_switcher() {
require_once 'reservations.class.php';
global $subpage;
	if ($_COOKIE["lang"] == 'sq') {
		switch ($subpage) {
			case 'rezervo':
			return reservations::rezervo();
			break;
			
			case 'listat':
			return ($_SESSION['roli']=='admin') ? reservations::lista() : reservations::lista_per_agent();
			break;
			
			case 'profit':
			return ($_SESSION['roli']=='admin') ? reservations::profit() :  reservations::profit_per_agent();
			break;
			
		
			case 'ndihme':
			return  Help_modules::reservation_help();
			break;
			
			default:
				return reservations::rezervo();
			break;
		}
	} elseif ($_COOKIE["lang"] == 'en') {
		switch ($subpage) {
			case 'book':
			return reservations::rezervo();
			break;
			
			case 'lists':
			return ($_SESSION['roli']=='admin') ? reservations::lista() : reservations::lista_per_agent();
			break;
			
			case 'profit':
			return ($_SESSION['roli']=='admin') ? reservations::profit() :  reservations::profit_per_agent();
			break;
			
		
			case 'help':
			return  Help_modules::reservation_help();
			break;
			
			default:
				return reservations::rezervo();
			break;
		}
	}	
}

function perdoruesit_switcher() {
require_once 'users.class.php';
global $subpage;	
	switch ($subpage) {
		case 'agjentet':
			return users_class::users('agent');
		break;
		
		case 'administratoret':
			return users_class::users('admin');
		break;
		
		case 'ndihme':
			return Help_modules::users_help();
		break;
		
		default:
			return users::users('agent');
		break;
	}
}

function menaxhment_switcher() {
require_once 'managment.class.php';
global $subpage;	
	switch ($subpage) {
		case 'destinacionet':
			return managment::destinations();
		break;
		
		case 'stacionet':
			return managment::stacionet();
		break;
		
		case 'udhetimet':
			return managment::udhetimet();
		break;
		
		case 'ndihme':
			return  Help_modules::managment_help();
		break;
		
		default:
			return managment::destinations();
		break;
	}
}	
	
	
}//endof controller

?>
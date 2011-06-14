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
			return 'rezervimet';
			break;
		}
		
	}
	
function rezervimet_switcher() {
require_once 'reservations.class.php';
global $subpage;
	switch ($subpage) {
		case 'rezervo':
		return '<div id="Formulari">'.reservations::rezervo().'</div>';
		break;
		
		case 'listat':
		return reservations::lista();
		break;
		
		case 'profit':
		return reservations::profit();
		break;
		
		case 'ndihme':
		return 'Qendra per ndihm shkon ktu';
		break;
		
		default:
			return '<div id="Formulari">'.reservations::rezervo().'</div>';
		break;
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
			return 'Qendra per ndihm shkon ktu';
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
		
		case 'ndihme':
			return 'Qendra per ndihm shkon ktu';
		break;
		
		default:
			return managment::destinations();
		break;
	}
}	
	
	
}//endof controller

?>
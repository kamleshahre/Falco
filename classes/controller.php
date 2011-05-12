<?php
class controller {

function menu_switcher() {
global $page;	
	switch ($page) {
			case 'rezervimet':
			return 'rezervimet';
			break;
			
			case 'agjentet':
			return 'agjentet';
			break;
			
			default:
				;
			break;
		}
		
	}
}

?>
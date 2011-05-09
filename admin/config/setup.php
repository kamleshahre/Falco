<?php

define( DEV , true); //true if we are developing localy or false if we dont

	//check if the site localy hosted
	if(DEV == true) {
	define( DOMAIN , 'http://'.$_SERVER['HTTP_HOST'].'/falco/admin');
	define( WEB_URL , 'http://'.$_SERVER['HTTP_HOST'].'/falco');
	define( DB_HOST , 'localhost');
	define( DB_USER , 'root');
	define( DB_PASS , 'test');
	define( DB_NAME , 'falco_db');
	}
	//else the web site is hosted online
	else {
	define( DOMAIN , 'www.DOMAINGOESHERE.com/admin');
	define( WEB_URL , 'www.DOMAINGOESHERE.com');
	define( DB_HOST ,'host_goes_here');
	define( DB_USER ,'username_goes_here');
	define( DB_PASS ,'password_goes_here');
	define( DB_NAME ,'falco_db');
	}

//unique web infos
define( AUTHOR , 'Shpetim Islami');
define( NAME , 'Paneli Administratues');

//paths for all folders
define( CLASSES , DOMAIN.'/class');
define( CONFIG , DOMAIN.'/config');
define( IMAGES , DOMAIN.'/images');
define( JAVAS , DOMAIN.'/js');

?>
<?php
define('DEV', TRUE);

if(DEV == TRUE) {
// MySQL database info
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'test');
define('DB_NAME', 'falco_db');
}
else{
define('DB_SERVER', '');
define('DB_USER', '');
define('DB_PASSWORD', '');
define('DB_NAME', 'falco_db');
}
// General WEB info
define('WEB_NAME','Millennium');
define('ADMIN_MAIL','draodakum@gmail.com');
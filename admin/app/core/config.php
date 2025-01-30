<?php 

/*set your website title*/

define('WEBSITE_TITLE', "PhpBookStore");

/*set database variables*/

define('DB_TYPE','mysql');
define('DB_NAME','bookstore_db'); 
define('DB_USER','user'); 
define('DB_PASS','User@1234'); 
define('DB_HOST','localhost');

/*protocol type http or https*/
define('PROTOCAL','http');

/*root and asset paths*/

$path = str_replace("\\", "/", PROTOCAL ."://" . $_SERVER['SERVER_NAME'] . "/");
$path = str_replace($_SERVER['DOCUMENT_ROOT'], "", $path);

define('ROOT', $path . "phpbookstore/admin/public/");
define('ASSETS', $path . "phpbookstore/admin/public/assets/");

/*set to true to allow error reporting
set to false when you upload online to stop error reporting*/

define('DEBUG',true);

if(DEBUG)
{
	ini_set("display_errors",1);
}else{
	ini_set("display_errors",0);
}
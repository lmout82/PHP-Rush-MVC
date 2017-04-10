<?php
//**********************************************************************************************
//                                     configuration.php
//
// Author(s): lmout82
// Rush PHP-MVC
// Licence:  MIT License
// Link: https://github.com/lmout82/PHP-Rush-MVC
// Creation date: April 2017
//***********************************************************************************************


define ("WEBSITE_DIR", "PHP_Rush_MVC");
define ("WEB_ROOT_DIR", $_SERVER["DOCUMENT_ROOT"]);

if(WEBSITE_DIR == "")
	define ("WEBSITE_FULL_DIR", WEB_ROOT_DIR);
else
	define ("WEBSITE_FULL_DIR", WEB_ROOT_DIR."/".WEBSITE_DIR);	
?>
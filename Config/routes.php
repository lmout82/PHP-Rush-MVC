<?php
//**********************************************************************************************
//                                     routes.php
//
// Author(s): lmout82
// Rush PHP-MVC
// Licence:  MIT License
// Link: https://github.com/lmout82/PHP-Rush-MVC
// Creation date: April 2017
//***********************************************************************************************


$routes = array(
	"UsersController" 		=> array(
									"index"  => array("registred", "writter", "admin"),
									"registration" => array("guest"),
									"update" => array("registred", "writter", "admin"),
									"login"  => array("guest"),
									"logout" => array("registred", "writter", "admin"),
									"delete" => array("registred", "writter")
								),

	"ArticlesController"	=> array(
									"index"   => array("guest","registred", "writter", "admin"),
									"search"  => array("guest","registred", "writter", "admin"),
									"read"    => array("guest","registred", "writter", "admin"),
									"hashtag" => array("guest","registred", "writter", "admin"),
									"category"=> array("guest","registred", "writter", "admin"),
									"delete"  => array("writter","admin"),
									"create"  => array("writter", "admin"),
								),

	"AdminController"		=> array(
									"index"      => array("admin"),
									"users"      => array("admin"),
									"articles"   => array("admin"),
									"categories" => array("admin"),
								)
);

?>
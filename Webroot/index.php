<?php
//**********************************************************************************************
//                                     index.php
//
// Author(s): lmout82
// Rush PHP-MVC
// Licence:  MIT License
// Link: https://github.com/lmout82/PHP-Rush-MVC
// Creation date: April 2017
//***********************************************************************************************


include_once ("../Config/configuration.php");
include_once ("../Config/db.php");
include_once ("../Config/routes.php");

include_once ("../Src/autoload.php");



Session::Start();
if(Session::read("auth.user.group") === null)
	Session::write("auth.user.group", "guest");

$router = Router::getInstance();
Router::add($routes);

$request = Request::getInstance();

$dispatcher = Dispatcher::getInstance($request, $router);

$dispatcher->execute();

?>
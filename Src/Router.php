<?php
//**********************************************************************************************
//                                     Router.php
//
// Author(s): lmout82
// Rush PHP-MVC
// Licence:  MIT License
// Link: https://github.com/lmout82/PHP-Rush-MVC
// Creation date: April 2017
//***********************************************************************************************


class Router
{
	private static $_instance = null;
	private static $routes = array();


	public static function getInstance()
	{
		if (is_null(self::$_instance))
		{
	    	self::$_instance = new Router();
	    }

	    return self::$_instance;
	}

	private function __construct() {}

	private function __clone() {}

	public static function add($routes)
	{
		if(is_array($routes))
			self::$routes = $routes;
	}

	public function check($controller_name, $method_name, $user_group)
	{
		if(isset(self::$routes[$controller_name][$method_name]))
		{
			if(in_array($user_group, self::$routes[$controller_name][$method_name]))
				return true;
		}
		
		return false;
	}
}

?>
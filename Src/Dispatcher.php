<?php
//**********************************************************************************************
//                                     Dispatcher.php
//
// Author(s): lmout82
// Rush PHP-MVC
// Licence:  MIT License
// Link: https://github.com/lmout82/PHP-Rush-MVC
// Creation date: April 2017
//***********************************************************************************************


class Dispatcher
{
	private static $_instance = null;

	private $router  = null;
	private $request = null;


	public static function getInstance(Request $request, Router $router)
	{
		if (is_null(self::$_instance))
		{
	    	self::$_instance = new Dispatcher($request, $router);
	    }

	    return self::$_instance;
	}

	private function __construct(Request $request, Router $router)
	{
		$this->router  = $router;
		$this->request = $request;
	}

	private function __clone() {}

	public function redirect(array $options)
	{
		$url = implode("/", $options);
		$this->request->init($url);
		$this->execute();
	}

	public function execute()
	{
		$usergroup       = Session::read("auth.user.group");
		$controller_name = array();
		$controller_name = "";
		$method_name     = "";
		$method_params   = ""; 

		$url_params      = $this->request->getUrlParams();
		if(count($url_params)>0)
		{
			$controller_name = array_shift($url_params);
			$controller_name = ucfirst($controller_name)."Controller";
			$method_name     = array_shift($url_params);
			$method_params   = $url_params;

			if($this->router->check($controller_name, $method_name, $usergroup))
			{
				if(!$this->call($controller_name, $method_name, $method_params))
					$this->call("PagesController", "index");
			}
			else
				$this->call("PagesController", "index");
		}
		else
		{
			$this->call("PagesController", "index");
		}
	}

	public function call($controller_name, $method_name, $method_params=array())
	{
		if(class_exists($controller_name))
		{
			$obj = new $controller_name;
			$obj->init($this);

			if(method_exists($obj, $method_name))
			{
				$ref_obj = new ReflectionMethod($controller_name, $method_name);
				if($ref_obj->isPublic())
					call_user_func_array(array($obj, $method_name), $method_params);
				else
					return false;
			}
			else
				call_user_func(array($obj, 'index'));
		}
		else
			return false;

		return true;		
	}
}

?>
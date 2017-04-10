<?php
//**********************************************************************************************
//                                     Request.php
//
// Author(s): lmout82
// Rush PHP-MVC
// Licence:  MIT License
// Link: https://github.com/lmout82/PHP-Rush-MVC
// Creation date: April 2017
//***********************************************************************************************


class Request
{
	private static $_instance = null;

	private $url = "";
	private $url_params = array();


	public static function getInstance()
	{
		if(is_null(self::$_instance))
		{
	    	self::$_instance = new Request();
	    }

	    return self::$_instance;
	}

	private function __clone() {}

	private function __construct()
	{
		$this->init($_SERVER["REQUEST_URI"]);
	}

	public function init($url)
	{
		$url = trim($url, "/");
		$this->url_params = explode("/", $url);

		$this->url_params = array_diff($this->url_params, array(WEBSITE_DIR), array("index.php"));  // remove index.php & parent directory
		$this->url        = implode("/", $this->url_params);		
	}

	public function getUrl()
	{
		return $this->url;
	}

	public function getUrlParams()
	{
		return $this->url_params;
	}

	public function is($method)
	{
		if(!is_string($method))
			return false;

		switch ($method)
		{
			case "post":
				if(count($_POST)>0)
					return true;
				break;
		}

		return false;
	}
}

?>
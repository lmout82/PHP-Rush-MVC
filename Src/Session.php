<?php
//**********************************************************************************************
//                                     Session.php
//
// Author(s): lmout82
// Rush PHP-MVC
// Licence:  MIT License
// Link: https://github.com/lmout82/PHP-Rush-MVC
// Creation date: April 2017
//***********************************************************************************************


class Session
{
	public static function Start()
	{
		session_set_cookie_params(1*60*60); // seconds
		session_start();
	}

	public static function Destroy()
	{
		$_SESSION = array();

		if(ini_get("session.use_cookies"))
		{
	    	$cookie_params = session_get_cookie_params();
	    	setcookie(session_name(), "", time()-3600, $cookie_params["path"],
	    			 								   $cookie_params["domain"],
	    			 								   $cookie_params["secure"],
	    			 								   $cookie_params["httponly"]);
		}

		session_destroy();
		session_start();
		Session::write("auth.user.group", "guest");			
	}

	/*
	** $lifetime en timestamp Unix
	*/
	public static function setLifetime($lifetime)
	{
		$cookie_params = session_get_cookie_params();
    	setcookie(session_name(), session_id(), $lifetime, $cookie_params["path"],
    											  		   $cookie_params["domain"],
    											  		   $cookie_params["secure"],
    											  		   $cookie_params["httponly"]);
	}

	public static function write($key, $val)
	{
		$path = explode(".", $key);
		self::setPath($_SESSION, $path, $val);		
	} 

	/*
	** Retourne NULL si la clé n'existe pas
	** $key = 'Auth.User.id’
	*/
	public static function read($key)
	{
		$path = explode(".", $key);
		return self::readPath($_SESSION, $path);		
	}

	private function setPath(array &$sess, array $path, $val)
	{
		foreach ($path as $key)
		{
	        $sess = &$sess[$key];
	    }

	    $sess = $val;
	}

	private function readPath(array $sess, array $path)
	{
		foreach ($path as $key)
		{
			if(!array_key_exists($key, $sess))
			{
				return null;
			}
			else
			{
				$sess = $sess[$key];
			}
		}

		return $sess;
	}
}
?>
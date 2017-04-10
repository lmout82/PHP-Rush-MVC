<?php
//**********************************************************************************************
//                                     View.php
//
// Author(s): lmout82
// Rush PHP-MVC
// Licence:  MIT License
// Link: https://github.com/lmout82/PHP-Rush-MVC
// Creation date: April 2017
//***********************************************************************************************


class View
{
	private $controller      = null;
	private $controller_name = "";
	private $renderView      = true;

	public function __construct($controller)
	{
		if(is_object($controller) && ($controller instanceof AppController))
		{
			$this->controller = $controller;

			$exp = explode("Controller", get_class($controller));
			$this->controller_name = $exp[0];
		}
	}

	public function isActive($status)
	{
		if(is_bool($status))
			$this->renderView = $status;
	} 

	public function render($view_name, array $vars = array())
	{
		if(is_null($this->controller))
			return;

		if(!$this->renderView)
			return;

		try {
			$loader = new Twig_Loader_Filesystem(array(WEBSITE_FULL_DIR."/Views/Layouts", WEBSITE_FULL_DIR."/Views/".$this->controller_name));
			$twig   = new Twig_Environment($loader, array("cache" => false));

			$filter = new Twig_SimpleFilter("hashTagsToLink", array($this, "hashTagsToLink"), array('is_safe' => array('html')));
			$twig->addFilter($filter);

			$template = $twig->loadTemplate($view_name.".html.twig");
			$this->controller->beforeRender();

			echo $template->render($vars);
		}
		catch (Twig_Error $e)
		{
			echo "Oupps... Exception thrown by Twig!<br>";
			echo $e->getMessage();
		}
	}

	// twig filter to convert hastags into links
	public function hashTagsToLink($content)
	{
		$hashtags  = array();
		preg_match_all ("/#([A-Za-z_]+)/", $content, $hashtags);

		foreach ($hashtags[1] as $hashtag)
		{
			$content = str_replace("#".$hashtag, "<a href='/PHP_Rush_MVC/index.php/articles/hashtag/".$hashtag."'>#".$hashtag."</a>", $content);
		}


		return $content;
	}
}

?>
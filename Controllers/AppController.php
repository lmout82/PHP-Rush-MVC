<?php

abstract class AppController
{
	private $models    = array();
	private $view      = null;
	private $dispatcher= null;
	protected $request = null;
	protected $session = null;


	public function init(Dispatcher $dispatcher)
	{
		$this->request    = Request::getInstance();
		$this->dispatcher = $dispatcher;
		$this->view       = new View($this);
	}

	public function __get($model_name)
	{
		$model_name = strtolower($model_name);

		if(array_key_exists($model_name, $this->models))
		{
			return $this->models[$model_name];
		}
	}

	public function loadModel($model)
	{
		if(is_string($model))
		{
			$prop_name  = strtolower($model);
			$class_name = ucfirst($prop_name);

			$this->models[$prop_name] = new $class_name();		
		}
	}

	public function render($view_name, array $vars = array())
	{
		if(!is_string($view_name))
			return false;

		$this->view->render($view_name, $vars);
	}

	public function beforeRender() {}

	// for the array $param, see Dispatcher.php
	public function redirect(array $options)
	{
		$this->view->isActive(false);
		$this->dispatcher->redirect($options);
	}

	abstract public function index();
}

?>
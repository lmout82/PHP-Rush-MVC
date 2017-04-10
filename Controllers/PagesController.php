<?php
//**********************************************************************************************
//                                     PagesController.php
//
// Author(s): lmout82
// Rush PHP-MVC
// Licence:  MIT License
// Link: https://github.com/lmout82/PHP-Rush-MVC
// Creation date: April 2017
//***********************************************************************************************


class PagesController extends AppController
{
	public function index()
	{
		$this->redirect(array("controller"=>"articles", "action"=>"index"));
	}
}

?>
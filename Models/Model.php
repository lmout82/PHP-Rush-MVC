<?php
//**********************************************************************************************
//                                     Model.php
//
// Author(s): lmout82
// Rush PHP-MVC
// Licence:  MIT License
// Link: https://github.com/lmout82/PHP-Rush-MVC
// Creation date: April 2017
//***********************************************************************************************


class Model
{
	protected $dbh;


	public function __construct()
	{
		$this->dbh = Database::getInstance();
	}
}

?>
<?php
//**********************************************************************************************
//                                     Database.php
//
// Author(s): lmout82
// Rush PHP-MVC
// Licence:  MIT License
// Link: https://github.com/lmout82/PHP-Rush-MVC
// Creation date: April 2017
//***********************************************************************************************



class Database
{
	private $dbh = NULL;
	private $ret = false;
	private static $_instance = NULL;


	public static function getInstance()
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new Database (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_PORT, DB_NAME, array(PDO::ATTR_PERSISTENT=>true));
		}

		return self::$_instance;
	}

	private function __construct($host, $username, $passwd, $port, $db, $options = array())
	{
		try
		{
			$this->dbh = new PDO('mysql:host='.$host.';port='.$port.';dbname='.$db, $username, $passwd, $options);
		}
		catch (PDOException $e)
		{
		    $err_msg = "PDO ERROR: ".$e->getMessage();
		    echo $err_msg;

		    return false;
		}
	}

	private function __clone() {}

	public function __destruct()
	{
		$this->dbh = NULL;		
	}

	/*
	** $query : "SELECT * FROM db WHERE col1 < :val1 AND col2 = :val2
	** $input_parameters : array(':val1' => 150, ':val2' => 'red')
	*/
	public function select($query, array $input_parameters, $object)
	{
		if($this->dbh === NULL)
			return;

		if(!is_object($object))
			return;

		if(is_string($query))
		{
			$sth = $this->dbh->prepare($query);
			$sth->setFetchMode(PDO::FETCH_INTO, $object);
			if ($sth->execute($input_parameters))
			{
				while ($one_row = $sth->fetch())
				{
    				yield $one_row;
  				}
			}
				return;
		}
			return;
	}


	public function selectArray($query, array $input_parameters)
	{
		if($this->dbh === NULL)
			return;

		if(is_string($query))
		{
			$sth = $this->dbh->prepare($query);
			$sth->setFetchMode(PDO::FETCH_ASSOC);
			if ($sth->execute($input_parameters))
			{
				while ($one_row = $sth->fetch())
				{
    				yield $one_row;
  				}
			}
				return;
		}
			return;
	}


	/*
	** Return false on failure, otherwise the id(int) of the ID of the last inserted row
	** It seems lastInsertId return 0 with transactions in mysql.
	*/
	public function insert($query, array $input_parameters)
	{
		if($this->dbh === NULL)
			return false;

		if(!is_string($query))
			return false;

		$sth = $this->exeQuery($query, $input_parameters);
		if ($sth !== false)
		{
			return (int)$this->dbh->lastInsertId();
		}
			return false;
	}

	/*
	** Returns the number of rows affected by the last query
	** Or false on failure
	*/
	public function update($query, array $input_parameters)
	{
		if($this->dbh === NULL)
			return false;

		if(!is_string($query))
			return false;

		$sth = $this->exeQuery($query, $input_parameters);
		if ($sth !== false)
		{
			return $sth->rowCount();
		}
			return false;
	}

	/*
	** Same as update().
	*/
	public function delete($query, array $input_parameters)
	{
		if($this->dbh === NULL)
			return false;

		if(!is_string($query))
			return false;

		$sth = $this->exeQuery($query, $input_parameters);
		if ($sth !== false)
		{
			return $sth->rowCount();
		}
			return false;
	}


	/*
	** Return a PDOStatement object or false on failure
	*/
	private function exeQuery($query, array $input_parameters)
	{
		$sth = $this->dbh->prepare($query);
        $sth->execute($input_parameters);
        return $sth;
	}
}

?>
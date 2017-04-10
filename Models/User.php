<?php
//**********************************************************************************************
//                                     User.php
//
// Author(s): lmout82
// Rush PHP-MVC
// Licence:  MIT License
// Link: https://github.com/lmout82/PHP-Rush-MVC
// Creation date: April 2017
//***********************************************************************************************


class User extends Model
{
	public $id       = -1;
	public $username = "";
	public $password = "";
	public $email    = "";
	public $group_name        = "";
	public $is_banished       = 0;
	public $creation_date     = "";
	public $modification_date = "";


	/*
	** Return true or false on failure
	*/
	public function add()
	{
		$this->password = password_hash($this->password, PASSWORD_DEFAULT);
		$query  = "INSERT INTO users (username,password,email,group_name,is_banished,modification_date) VALUES (:username, :password, :email, :group, :is_banished, :modification_date)"; 

		$result = $this->dbh->insert($query, array(":username"=>$this->username, ":password"=>$this->password, ":email"=>$this->email, ":group"=>$this->group_name, ":is_banished"=>$this->is_banished, ":modification_date"=>date("Y-m-d H:i:s")));
		
		if($result !== false)
		{
			$this->id = $result;
			return true;
		}
			return false;
	}


	/*
	** Use the $id of the user to delete it.
	** Return true or false on failure
	*/
	public function delete()
	{
		$query  = "DELETE FROM users WHERE id= :id LIMIT 1";

		$result = $this->dbh->delete($query, array(":id"=>$this->id));
		if($result !== false)
			return true;
		else
			return false;
	}


	/*
	** Update all the data from a user (id).
	** Return true or false on failure
	*/
	public function update()
	{
		$this->password = password_hash($this->password, PASSWORD_DEFAULT);
		$query = "UPDATE users SET username= :username, email= :email, password= :password, group_name= :group, is_banished= :is_banished, modification_date= :modification_date WHERE id= :id";

		$result = $this->dbh->update($query, array(":username"=>$this->username, ":email"=>$this->email, ":password"=>$this->password, ":group"=>$this->group_name, ":is_banished"=>$this->is_banished, ":modification_date"=>date("Y-m-d H:i:s"), ":id"=>$this->id));
		if($result !== false)
			return true;
		else
			return false;
	}


	/*
	** Check the password of a user at sign-in. In this case, the email is used
	** to identify him/her. It's assumed that the email col has a UNIQUE constraint.
	** Returns : true if the user exists in the db and if the password is correct
	**			 false on failure 
	*/
	public function check_pwd()
	{
		$query = "SELECT * FROM users WHERE email= :email LIMIT 1";

		foreach ($this->dbh->select($query, array(":email"=>$this->email), new User) as $one_user)
		{
			if(password_verify($this->password, $one_user->password))
			{
				$this->id          = $one_user->id;
				$this->username    = $one_user->username;
				$this->password    = $one_user->password;
				$this->email       = $one_user->email;
				$this->group_name  = $one_user->group_name;
				$this->is_banished = $one_user->is_banished;
				$this->creation_date     = $one_user->creation_date;
				$this->modification_date = $one_user->modification_date;

				return true;
			}
		}

		return false;			
	}


	/*
	** Return information about a user from its id
	** Return false on failure
	*/
	public function get()
	{
		$query = "SELECT * FROM users WHERE id= :id LIMIT 1";

		foreach ($this->dbh->select($query, array(":id"=>$this->id), new User) as $one_user)
		{
			$this->id          = $one_user->id;
			$this->username    = $one_user->username;
			$this->password    = $one_user->password;
			$this->email       = $one_user->email;
			$this->group_name  = $one_user->group_name;
			$this->is_banished = $one_user->is_banished;
			$this->creation_date     = $one_user->creation_date;
			$this->modification_date = $one_user->modification_date;

			return true;
		}

		return false;		
	}


	/*
	** Return all the users from the database
	*/
	public function getAll()
	{
		$users = array();
		$query = "SELECT * FROM users";

		foreach ($this->dbh->selectArray($query, array()) as $one_user)
		{
			$users[] = $one_user;
		}

		return $users;
	}
}
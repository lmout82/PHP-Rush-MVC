<?php
//**********************************************************************************************
//                                     UsersController.php
//
// Author(s): lmout82
// Rush PHP-MVC
// Licence:  MIT License
// Link: https://github.com/lmout82/PHP-Rush-MVC
// Creation date: April 2017
//***********************************************************************************************


class UsersController extends AppController
{
	private $groupname = "guest";


	public function __construct()
	{
		$this->groupname = Session::read("auth.user.group");
	}

	public function index()
	{
		$username  = ucfirst(Session::read("auth.user.username"));

		$this->render(__FUNCTION__, array("username"=>$username, "groupname"=>$this->groupname));
	}

	public function registration()
	{
		$error    = false;
		$error_msg= array();
		$username = isset($_POST['username']) ?	trim($_POST['username']) : "";
		$email 	  = isset($_POST['email'])	  ?	trim($_POST['email'])	 : "";
		$password = isset($_POST['password']) ?	trim($_POST['password']) : "";
		$password_conf = isset($_POST['password_conf'])	? trim($_POST['password_conf'])	: "";

		if($this->request->is("post"))
		{
			if(!FormVal::Name($username, 3, 10))
			{
				$error_msg[] = "Invalid username.";
				$error = true;
			}

			if(!FormVal::Email($email))
			{
				$error_msg[] = "Invalid email.";
				$error = true;
			}

			if(!FormVal::Pwd($password, $password_conf, 8 ,20))
			{
				$error_msg[] = "Invalid password or password confirmation.";
				$error = true;
			}

			if(!$error)
			{
				$this->loadModel("user");
				$this->user->username = $username;
				$this->user->email    = $email;
				$this->user->password = $password;
				$this->user->group_name = "registred";

				if(!$this->user->add())
				{
					$error_msg[] = "Your subscription failed. Please retry.";
				}
				else
				{
					$this->redirect(array("controller"=>"articles", "action"=>"index"));
				}
			}
		}

		$this->render(__FUNCTION__, array("username"=>$username, "email"=>$email, "error_msg"=>$error_msg));
	}

	public function update()
	{
		$this->loadModel("user");
		$this->user->id = Session::read("auth.user.id");
		$this->user->get();

		$username = isset($_POST['username']) ?	trim($_POST['username']) : $this->user->username;
		$email 	  = isset($_POST['email'])	  ?	trim($_POST['email'])	 : $this->user->email;
		$password = isset($_POST['password']) ?	trim($_POST['password']) : "";
		$password_conf = isset($_POST['password_conf'])	? trim($_POST['password_conf'])	: "";

		$error    = false;
		$error_msg= array();


		if($this->request->is("post"))
		{
			if(!FormVal::Name($username, 3, 10))
			{
				$error_msg[] = "Invalid username.";
				$error = true;
			}

			if(!FormVal::Email($email))
			{
				$error_msg[] = "Invalid email.";
				$error = true;
			}

			if(!FormVal::Pwd($password, $password_conf, 8 ,20))
			{
				$error_msg[] = "Invalid password or password confirmation.";
				$error = true;
			}

			if(!$error)
			{
				$this->user->username = $username;
				$this->user->email    = $email;
				$this->user->password = $password;

				if(!$this->user->update())
				{
					$error_msg[] = "The operation failed.";
				}
				else
				{
					Session::write("auth.user.username", $this->user->username);
					$this->redirect(array("controller"=>"users", "action"=>"index"));
				}
			}
		}

		$this->render(__FUNCTION__, array("username"=>$username, "email"=>$email, "error_msg"=>$error_msg));
	}

	public function login()
	{
		$error    = false;
		$error_msg= array();
		$email 	  = isset($_POST['email'])	  ?	trim($_POST['email'])	 : "";
		$password = isset($_POST['password']) ?	trim($_POST['password']) : "";

		if($this->request->is("post"))
		{
			if(!FormVal::Email($email))
			{
				$error_msg[] = "Invalid email.";
				$error = true;
			}

			if(!$error)
			{
				$this->loadModel("user");
				$this->user->email    = $email;
				$this->user->password = $password;

				if(!$this->user->check_pwd())
				{
					$error_msg[] = "Invalid username and/or password.";
				}
				else
				{
					if($this->user->is_banished == 0)
					{
						Session::write("auth.user.id",       $this->user->id);
						Session::write("auth.user.username", $this->user->username);
						Session::write("auth.user.group",    $this->user->group_name);
					}

					$this->redirect(array("controller"=>"users", "action"=>"index"));
				}
			}
		}
		
		$this->render(__FUNCTION__, array("email"=>$email, "error_msg"=>$error_msg));		
	}

	public function logout()
	{
		Session::Destroy();
		Session::write("auth.user.group", "guest");

		$this->redirect(array("controller"=>"articles", "action"=>"index"));		
	}

	public function delete()
	{
		$msgs = array();

		$this->loadModel("user");
		$this->user->id = Session::read("auth.user.id");

		if($this->user->delete() !== false)
		{
			$msgs[] = "Your account has been deleted.";
			$msgs[] = "And you are now logged out.";
			Session::Destroy();
			Session::write("auth.user.group", "guest");
		}
		else
		{
			$msgs[] = "The operation failed.";
		}

		$this->render(__FUNCTION__, array("msgs"=>$msgs));		
	}
}

?>
<?php
//**********************************************************************************************
//                                     AdminController.php
//
// Author(s): lmout82
// Rush PHP-MVC
// Licence:  MIT License
// Link: https://github.com/lmout82/PHP-Rush-MVC
// Creation date: April 2017
//***********************************************************************************************


class AdminController extends AppController
{
	private $groupname = "guest";


	public function __construct()
	{
		$this->groupname = Session::read("auth.user.group");
	}

	public function index()
	{
		$this->render(__FUNCTION__, array("groupname"=>$this->groupname));
	}

	public function users(...$args)
	{
		$action_name = array_shift($args);
		$action_args = $args;

		$this->dispatch(__FUNCTION__, $action_name, $args);
	}

	public function articles(...$args)
	{
		$action_name = array_shift($args);
		$action_args = $args;

		$this->dispatch(__FUNCTION__, $action_name, $args);	
	}

	public function categories(...$args)
	{
		$action_name = array_shift($args);
		$action_args = $args;

		$this->dispatch(__FUNCTION__, $action_name, $args);		
	}

	private function dispatch($entity_name, $action_name, $action_args)
	{
		if($action_name === null)
		{
			call_user_func(array($this, $entity_name.'_index'));
		}
		else
		{
			$method_name = $entity_name.'_'.$action_name; 

			if(method_exists($this, $method_name))
			{
				if(count($action_args)>0)
					call_user_func_array(array($this, $method_name), $action_args);
				else
					call_user_func(array($this, $method_name), $action_args);
			}
			else
				call_user_func(array($this, $entity_name.'_index'));
		}
	}


	private function users_index()
	{
		$users = array();

		$this->loadModel("user");
		$users = $this->user->getAll();

		$this->render(__FUNCTION__, array("groupname"=>$this->groupname, "users"=>$users));
	}

	private function users_add()
	{
		$error    = false;
		$error_msg= array();
		$username = isset($_POST['username']) ?	trim($_POST['username']) : "";
		$email 	  = isset($_POST['email'])	  ?	trim($_POST['email'])	 : "";
		$password = isset($_POST['password']) ?	trim($_POST['password']) : "";
		$password_conf = isset($_POST['password_conf'])	? trim($_POST['password_conf'])	      : "";
		$group         = isset($_POST['group'])	        ? trim($_POST['group'])	              : "registred";
		$is_banished   = isset($_POST['is_banished'])	? intval(trim($_POST['is_banished'])) : 0;

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

			if(!in_array($is_banished, range(0,1)))
			{
				$is_banished = 0; 
			}			

			if(!in_array($group, array("registred", "writter", "admin")))
			{
				$group = "registred"; 
			}

			if(!$error)
			{
				$this->loadModel("user");
				$this->user->username = $username;
				$this->user->email    = $email;
				$this->user->password = $password;
				$this->user->group_name  = $group;
				$this->user->is_banished = $is_banished;

				if(!$this->user->add())
				{
					$error_msg[] = "The operation failed. Please retry.";
				}
				else
				{
					$this->redirect(array("controller"=>"admin", "action"=>"users"));
				}
			}
		}

		$this->render(__FUNCTION__, array("groupname"=>$this->groupname, "error_msg"=>$error_msg, "username"=>$username, "email"=>$email, "group"=>$group, "is_banished"=>$is_banished));
	}

	private function users_delete($id=-1)
	{
		if(filter_var($id, FILTER_VALIDATE_INT, array("options" => array("min_range" => 0))) !== false)
		{
			$this->loadModel("user");
			$this->user->id = $id;
			$this->user->delete();
		}

		$this->users_index();
	}

	private function users_update($id=-1)
	{
		if (filter_var($id, FILTER_VALIDATE_INT, array("options" => array("min_range"=>0))) === false)
		{
			$this->redirect(array("controller"=>"admin", "action"=>"users"));
    		return;
		}

		$this->loadModel("user");
		$this->user->id = $id;
		$this->user->get();

		$error    = false;
		$error_msg= array();
		$username = isset($_POST['username']) ?	trim($_POST['username']) : $this->user->username;
		$email 	  = isset($_POST['email'])	  ?	trim($_POST['email'])	 : $this->user->email;
		$password = isset($_POST['password']) ?	trim($_POST['password']) : "";
		$password_conf = isset($_POST['password_conf'])	? trim($_POST['password_conf'])	      : "";
		$group         = isset($_POST['group'])	        ? trim($_POST['group'])	              : $this->user->group_name;
		$is_banished   = isset($_POST['is_banished'])	? intval(trim($_POST['is_banished'])) : $this->user->is_banished;

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

			if(!in_array($is_banished, range(0,1)))
			{
				$is_banished = 0; 
			}			

			if(!in_array($group, array("registred", "writter", "admin")))
			{
				$group = "registred"; 
			}

			if(!$error)
			{
				$this->user->username = $username;
				$this->user->email    = $email;
				$this->user->password = $password;
				$this->user->group_name  = $group;
				$this->user->is_banished = $is_banished;

				if(!$this->user->update())
				{
					$error_msg[] = "The operation failed. Please retry.";
				}
				else
				{
					$this->redirect(array("controller"=>"admin", "action"=>"users"));
				}
			}
		}

		$groupname = Session::read("auth.user.group");
		$this->render(__FUNCTION__, array("groupname"=>$groupname, "error_msg"=>$error_msg, "username"=>$username, "email"=>$email, "group"=>$group, "is_banished"=>$is_banished));
	}


	private function articles_index()
	{
		$articles   = array();
		$categories = array();
		$users      = array();

		$this->loadModel("article");
		$articles = $this->article->getAll();

		$this->loadModel("category");
		$categories = $this->category->getAll();

		$this->loadModel("user");
		$users = $this->user->getAll();


		$nb_articles = count($articles);
		for($i=0; $i<$nb_articles; $i++)
		{
			$index1 = array_search($articles[$i]["user_id"], array_column($users, "id"));
			$articles[$i]["username"] = ($index1 === false ? "?" : $users[$index1]["username"]);

			$index2 = array_search($articles[$i]["category_id"], array_column($categories, "id"));
			$articles[$i]["category_name"] = ($index2 === false ? "?" : $categories[$index2]["name"]);
		}
		
		$groupname = Session::read("auth.user.group");
		$this->render(__FUNCTION__, array("groupname"=>$groupname, "articles"=>$articles));
	}

	private function articles_add()
	{
		$error    		= false;
		$error_msg 		= array();
		$image    		= "";
		$title    		= isset($_POST["title"])   		? trim($_POST["title"])   		: "";
		$content  		= isset($_POST["content"]) 		? trim($_POST["content"]) 		: "";
		$user_id  		= isset($_POST["user_id"]) 		? trim($_POST["user_id"]) 		: "";
		$category_id  	= isset($_POST["category_id"]) 	? trim($_POST["category_id"]) 	: "";

		$this->loadModel("category");
		$categories  	= $this->category->getAll();

		if($this->request->is("post"))
		{
			$title_len = strlen($title);
			if($title_len<5 || $title_len>50)
			{
				$error = true;
				$error_msg[] = "Title not valid.";
			}

			$content_len = strlen($content);
			if($content_len<=5)
			{
				$error = true;
				$error_msg[] = "Content is empty.";				
			}

			if(!$error)
			{
				$this->loadModel("article");
				$this->article->title   	= $title;
				$this->article->content 	= $content;
				$this->article->user_id 	= Session::read("auth.user.id");
				$this->article->image 		= Photo::storeUploadedImage("image");
				$this->article->category_id = $category_id;

				$this->getHashTags($content);

				if(!$this->article->add())
				{
					$error_msg[] = "Submission failed. Please retry.";
				}
				else
				{
					$this->loadModel("tag");
					$tags = $this->getHashTags($content);
					if(count($tags)>0)
					{
						foreach ($tags as $tag)
						{
							$this->tag->name = $tag;
							$this->tag->add();
							$this->tag->addMapping($this->article->id, $tag);
						}
					}

					$this->redirect(array("controller"=>"admin", "action"=>"articles"));
				}
			}
		}

		$groupname = Session::read("auth.user.group");
		$this->render(__FUNCTION__, array("title"=>$title, "content"=>$content, "user_id"=>$user_id, "error_msg"=>$error_msg,
											"category_id"=>$category_id, "categories"=>$categories, "groupname"=>$groupname));
	}

	private function articles_delete($id=-1)
	{
		if(filter_var($id, FILTER_VALIDATE_INT, array("options" => array("min_range" => 0))) !== false)
		{
			$this->loadModel("article");
			$this->article->id = $id;
			$this->article->delete();

			$this->loadModel("comment");
			$this->comment->article_id = $id;
			$this->comment->deleteAll();	

			$this->loadModel("tag");
			$this->tag->deleteMapping($id);		
		}

		$this->articles_index();
	}

	private function articles_update($id=-1)
	{
		if (filter_var($id, FILTER_VALIDATE_INT, array("options" => array("min_range"=>0))) === false)
		{
			$this->redirect(array("controller"=>"admin", "action"=>"articles"));
    		return;
		}

		$this->loadModel("article");
		$this->article->id = $id;
		$this->article->get();

		$error    		= false;
		$error_msg 		= array();
		$image    		= "";
		$title    		= isset($_POST["title"])   		? trim($_POST["title"])   		: $this->article->title;
		$content  		= isset($_POST["content"]) 		? trim($_POST["content"]) 		: $this->article->content;
		$user_id  		= isset($_POST["user_id"]) 		? trim($_POST["user_id"]) 		: $this->article->user_id;
		$category_id  	= isset($_POST["category_id"]) 	? trim($_POST["category_id"]) 	: $this->article->category_id;

		$this->loadModel("category");
		$categories  	= $this->category->getAll();

		if($this->request->is("post"))
		{
			$title_len = strlen($title);
			if($title_len<5 || $title_len>50)
			{
				$error = true;
				$error_msg[] = "Title not valid.";
			}

			$content_len = strlen($content);
			if($content_len<=5)
			{
				$error = true;
				$error_msg[] = "Content is empty.";				
			}

			if(!$error)
			{
				$this->article->title   	= $title;
				$this->article->content 	= $content;
				$this->article->user_id 	= $user_id;
				$this->article->category_id = $category_id;

				$this->loadModel("tag");
				$this->tag->deleteMapping($id);

				if(!$this->article->update())
				{
					$error_msg[] = "Submission failed. Please retry.";
				}
				else
				{
					$tags = $this->getHashTags($content);
					if(count($tags)>0)
					{
						foreach ($tags as $tag)
						{
							$this->tag->name = $tag;
							$this->tag->add();
							$this->tag->addMapping($this->article->id, $tag);
						}
					}

					$this->redirect(array("controller"=>"admin", "action"=>"articles"));
				}
			}
		}

		$groupname = Session::read("auth.user.group");
		$this->render(__FUNCTION__, array("title"=>$title, "content"=>$content, "user_id"=>$user_id, "error_msg"=>$error_msg,
											"category_id"=>$category_id, "categories"=>$categories, "groupname"=>$groupname));
	}


	private function categories_index()
	{
		$categories = array();
		$groupname  = Session::read("auth.user.group");

		$this->loadModel("category");
		$categories = $this->category->getAll();

		$this->render(__FUNCTION__, array("groupname"=>$groupname, "categories"=>$categories));
	}

	private function categories_add()
	{
		$error     = false;
		$error_msg = array();
		$groupname = Session::read("auth.user.group");
		$name      = isset($_POST['name']) ? trim($_POST['name']) : "";

		if($this->request->is("post"))
		{
			if(!FormVal::Name($name, 3, 10))
			{
				$error_msg[] = "Invalid name.";
				$error = true;
			}

			if(!$error)
			{
				$this->loadModel("category");
				$this->category->name = $name;

				if(!$this->category->add())
				{
					$error_msg[] = "The operation failed. Please retry.";
				}
				else
				{
					$this->redirect(array("controller"=>"admin", "action"=>"categories"));
				}
			}
		}

		$this->render(__FUNCTION__, array("groupname"=>$groupname, "error_msg"=>$error_msg, "name"=>$name));		
	}

	private function categories_delete($id=-1)
	{
		if(filter_var($id, FILTER_VALIDATE_INT, array("options" => array("min_range" => 0))) !== false)
		{
			$this->loadModel("article");
			$articles = array();
			$this->article->category_id = $id;
			$articles = $this->article->getAllByCategoryId();

			if(count($articles) == 0)
			{
				$this->loadModel("category");
				$this->category->id = $id;
				$this->category->delete();

				$this->categories_index();
			}
			else
			{
				$groupname = Session::read("auth.user.group");
				$this->render(__FUNCTION__, array("groupname"=>$groupname));
			}
		}
		else
			$this->categories_index();
	}

	private function categories_update($id=-1)
	{
		if(filter_var($id, FILTER_VALIDATE_INT, array("options" => array("min_range" => 0))) !== false)
		{
			$this->loadModel("category");
			$this->category->id = $id;
			$this->category->get();

			$error     = false;
			$error_msg = array();
			$groupname = Session::read("auth.user.group");
			$name      = isset($_POST['name']) ? trim($_POST['name']) : $this->category->name;

			if($this->request->is("post"))
			{
				if(!FormVal::Name($name, 3, 10))
				{
					$error_msg[] = "Invalid name.";
					$error = true;
				}

				if(!$error)
				{
					$this->category->name = $name;

					if(!$this->category->update())
					{
						$error_msg[] = "The operation failed. Please retry.";
					}
					else
					{
						$this->redirect(array("controller"=>"admin", "action"=>"categories"));
					}
				}
			}

			$this->render(__FUNCTION__, array("groupname"=>$groupname, "error_msg"=>$error_msg, "name"=>$name));
		}
		else
			$this->categories_index();
	}

	private function getHashTags($content)
	{
		$matches   = array();

		preg_match_all ("/#([A-Za-z_]+)/", $content, $matches);

		return $matches[1];
	}
}

?>
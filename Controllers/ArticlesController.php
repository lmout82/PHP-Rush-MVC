<?php
//**********************************************************************************************
//                                     ArticlesController.php
//
// Author(s): lmout82
// Rush PHP-MVC
// Licence:  MIT License
// Link: https://github.com/lmout82/PHP-Rush-MVC
// Creation date: April 2017
//***********************************************************************************************


class ArticlesController extends AppController
{
	private $groupname = "guest";


	public function __construct()
	{
		$this->groupname = Session::read("auth.user.group");
	}

	public function index()
	{
		$this->loadModel("article");
		$articles = array();
		$articles = $this->article->getAll();

		$this->render(__FUNCTION__, array("groupname"=>$this->groupname, "section"=>get_class(), "articles"=>$articles));
	}

	public function read($id=-1)
	{
		if(is_numeric($id) && $id>0)
		{
			$this->loadModel("article");
			$this->article->id = $id;
			$this->article->get();

			if($this->article->title=="" || $this->article->content=="")
			{
				$this->redirect(array("controller"=>"articles", "action"=>"index"));
				return;
			}

			$this->loadModel("comment");
			$this->comment->article_id = $id;
			
			if($this->request->is("post"))
			{
				$content 	 = isset($_POST["content"]) ? trim($_POST["content"]) : "";
				$content_len = strlen($content);
				$error     = false;
				$error_msg = array();

				if($content_len<=0)
				{
					$error = true;
					$error_msg[] = "The content of the article is empty.";				
				}

				if(!$error)
				{
					$this->comment->content 	= $content;
					$this->comment->article_id 	= $id;
					$this->comment->user_id 	= Session::read("auth.user.id");

					if(!$this->comment->add())
					{
						$error_msg[] = "Submission failed. Please retry.";
					}
				}
			}

			$comments = $this->comment->getAll();

			$this->render(__FUNCTION__, array("id"=>$id, "title"=>$this->article->title, "content"=>$this->article->content,
												"user_id"=>$this->article->user_id, "creation_date"=>$this->article->creation_date,
												"image"=>$this->article->image, "category_id"=>$this->article->category_id,
												"last_modification"=>$this->article->last_modification, "comments"=>$comments,
												"groupname"=>$this->groupname, "username"=>$this->article->username,
												"last_modification"=>$this->article->last_modification, "category_name"=>$this->article->category_name));
		}
		else
			$this->redirect(array("controller"=>"articles", "action"=>"index"));
	}

	public function search()
	{
		$this->loadModel("category");

		$categories = $this->category->getAll();
		$keyword    = isset($_POST["keyword"])  ? trim($_POST["keyword"])  : ""; 
		$hashtag    = isset($_POST["hashtag"])  ? trim($_POST["hashtag"])  : ""; 
		$searchin   = isset($_POST["searchin"]) ? trim($_POST["searchin"]) : "content";
		$category   = isset($_POST["category"]) ? trim($_POST["category"]) : 0;
		$sortby     = isset($_POST["sortby"])   ? trim($_POST["sortby"])   : "alpha";
		$articles   = array();
		$error      = false;
		$error_msg  = array();

		if($this->request->is("post"))
		{
			$keyword_len = strlen($keyword);
			if($keyword_len<3)
			{
				$error_msg[] = "Invalid keyword";
				$error = true;
			}

			if(!in_array($searchin, array("title", "content")))
			{
				$searchin = "content"; 
			}

			filter_var($category, FILTER_VALIDATE_INT, array( "options" => array(
        																		"default" => 0,
        																		"min_range" => 0
    																			) ) );
			if(!in_array($sortby, array("alpha", "date")))
			{
				$sortby = "alpha"; 
			}

			if(!$error)
			{
				$this->loadModel("article");
				if($hashtag === "")
					$articles = $this->article->search($keyword, $searchin, $category, $sortby);
				else
					$articles = $this->article->searchWithTag($keyword, $hashtag, $searchin, $category, $sortby);
			}
		}

		$this->render(__FUNCTION__, array("groupname"=>$this->groupname, "categories"=>$categories, "articles"=>$articles, "error_msg"=>$error_msg));		
	}

	public function delete($id=-1)
	{
		if(is_numeric($id) && $id>0)
		{
			$this->loadModel("article");
			$this->article->id = $id;
			$this->article->getAuthor();

			if($this->article->user_id === Session::read("auth.user.id"))
			{
				$this->article->delete();

				$this->loadModel("comment");
				$this->comment->article_id = $id;
				$this->comment->deleteAll();

				$this->loadModel("tag");
				$this->tag->deleteMapping($id);		
			}
		}

			$this->redirect(array("controller"=>"articles", "action"=>"index"));
	}

	public function create($id=-1)
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

					$this->redirect(array("controller"=>"articles", "action"=>"index"));
				}
			}
		}

		$this->render(__FUNCTION__, array("title"=>$title, "content"=>$content, "user_id"=>$user_id, "error_msg"=>$error_msg,
											"category_id"=>$category_id, "categories"=>$categories, "groupname"=>$this->groupname));
	}

	public function hashtag($hashtag="")
	{
		$article_ids = array();
		$articles    = array();

		$this->loadModel("tag");
		$this->tag->name = $hashtag; 
		$article_ids = $this->tag->getMapping();

		$this->loadModel("article");
		foreach ($article_ids as $article_id)
		{
			$this->article->id = $article_id["article_id"];
			$this->article->get();
			$articles[] = get_object_vars($this->article);
		}

		$this->render(__FUNCTION__, array("groupname"=>$this->groupname, "articles"=>$articles, "hashtag"=>$hashtag));		
	}

	public function category($category_name="")
	{
		$articles    = array();

		$this->loadModel("category");
		$this->category->name = $category_name; 
		$this->category->getByName();

		$this->loadModel("article");
		$this->article->category_id = $this->category->id;
		$articles = $this->article->getAllByCategoryId();

		$this->render(__FUNCTION__, array("groupname"=>$this->groupname, "articles"=>$articles, "category_name"=>$category_name));		
	}

	private function getHashTags($content)
	{
		$matches   = array();

		preg_match_all ("/#(\w+)/", $content, $matches);

		return $matches[1];
	}
}

?>
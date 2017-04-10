<?php
//**********************************************************************************************
//                                     Article.php
//
// Author(s): lmout82
// Rush PHP-MVC
// Licence:  MIT License
// Link: https://github.com/lmout82/PHP-Rush-MVC
// Creation date: April 2017
//***********************************************************************************************


class Article extends Model
{
	public $id          = -1;
	public $title       = "";
	public $content     = "";
	public $category_id = -1;
	public $user_id     = -1;
	public $username    = "";
	public $image    	= "";
	public $creation_date     = "";
	public $last_modification = "";
	public $category_name 	  = "";

	/*
	** Return true or false on failure
	*/
	public function add()
	{
		$query  = "INSERT INTO articles (title,content,category_id,user_id,last_modification,image) VALUES (:title, :content, :category_id, :user_id, :last_modification, :image)"; 

		$result = $this->dbh->insert($query, array(":title"=>$this->title, ":content"=>$this->content, ":category_id"=>$this->category_id, ":user_id"=>$this->user_id, ":last_modification"=>date("Y-m-d H:i:s"), ":image"=>$this->image));
		
		if($result !== false)
		{
			$this->id = $result;
			return true;
		}
			return false;
	}


	/*
	** Use the $id of the article to delete it.
	** Return true or false on failure
	*/
	public function delete()
	{
		$query  = "DELETE FROM articles WHERE id= :id LIMIT 1";

		$result = $this->dbh->delete($query, array(":id"=>$this->id));
		if($result !== false)
			return true;
		else
			return false;
	}


	/*
	** Update all the data from the article (id).
	** Return true or false on failure
	*/
	public function update()
	{
		$query = "UPDATE articles SET title= :title, content= :content, category_id= :category_id, user_id= :user_id, last_modification= :last_modification WHERE id= :id";

		$result = $this->dbh->update($query, array(":title"=>$this->title, ":content"=>$this->content, ":category_id"=>$this->category_id, ":user_id"=>$this->user_id, ":last_modification"=>date("Y-m-d H:i:s"), ":id"=>$this->id));
		if($result !== false)
			return true;
		else
			return false;
	}


	/*
	** Return information about an article from its id
	** Return false on failure
	*/
	public function get()
	{
		$query = "SELECT * FROM articles INNER JOIN users ON articles.user_id=users.id INNER JOIN categories ON categories.id=articles.category_id WHERE articles.id= :id LIMIT 1";

		foreach ($this->dbh->select($query, array(":id"=>$this->id), new Article) as $one_article)
		{
			$this->title       = $one_article->title;
			$this->content     = $one_article->content;
			$this->category_id = $one_article->category_id; 
			$this->user_id     = $one_article->user_id;
			$this->username    = $one_article->username;
			$this->image 	   = $one_article->image;
			$this->creation_date     = $one_article->creation_date;
			$this->last_modification = $one_article->last_modification;	
			$this->category_name 	 = $one_article->name;		

			return true;
		}

		return false;		
	}

	/*
	** Return information about an article from its id
	** Return false on failure
	*/
	public function getAuthor()
	{
		$query = "SELECT user_id FROM articles WHERE id= :id LIMIT 1";

		foreach ($this->dbh->select($query, array(":id"=>$this->id), new Article) as $one_article)
		{
			$this->user_id = $one_article->user_id;	

			return true;
		}

		return false;		
	}

	/*
	** Return all the articles in the database
	*/
	public function getAll()
	{
		$articles = array();
		$query = "SELECT * FROM articles ORDER BY creation_date DESC";

		foreach ($this->dbh->selectArray($query, array()) as $one_article)
		{
			$articles[] = $one_article;
		}

		return $articles;
	}

	public function getAllByCategoryId()
	{
		$articles = array();
		$query = "SELECT * FROM articles WHERE category_id= :category_id";

		foreach ($this->dbh->selectArray($query, array(":category_id"=>$this->category_id)) as $one_article)
		{
			$articles[] = $one_article;
		}

		return $articles;
	}

	public function search($keyword, $search_in, $category_id, $sort_by)
	{
		$articles         = array();
		$input_parameters = array(":keyword"=>"%".$keyword."%");

		$query = "SELECT * FROM articles WHERE LOWER(".$search_in.") LIKE LOWER(:keyword)";
		if($category_id>0)
		{
			$query .= " AND category_id= :category_id";
			$input_parameters[":category_id"] = $category_id;
		}
		$query .= " ORDER BY";

		if($sort_by == "date")
		{
			$query .= " creation_date";
		}
		else
			$query .= " title";

		foreach ($this->dbh->selectArray($query, $input_parameters) as $one_article)
		{
			$articles[] = $one_article;
		}

		return $articles;
	}

	public function searchWithTag($keyword, $hashtag, $search_in, $category_id, $sort_by)
	{
		$articles         = array();
		$input_parameters = array(":keyword"=>"%".$keyword."%", ":tag_name"=>$hashtag);

		$query = "SELECT * FROM articles INNER JOIN tags_mapping ON tags_mapping.article_id=articles.id INNER JOIN tags ON tags.id=tags_mapping.tag_id WHERE LOWER(articles.".$search_in.") LIKE LOWER(:keyword)";
		if($category_id>0)
		{
			$query .= " AND articles.category_id= :category_id";
			$input_parameters[":category_id"] = $category_id;
		}
		$query .= " AND tags.name= :tag_name";
		$query .= " ORDER BY";

		if($sort_by == "date")
		{
			$query .= " articles.creation_date";
		}
		else
			$query .= " articles.title";

		foreach ($this->dbh->selectArray($query, $input_parameters) as $one_article)
		{
			$one_article["id"] = $one_article["article_id"]; 
			$articles[] = $one_article;
		}

		return $articles;
	}
}

?>
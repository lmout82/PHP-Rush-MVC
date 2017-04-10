<?php
//**********************************************************************************************
//                                     Comment.php
//
// Author(s): lmout82
// Rush PHP-MVC
// Licence:  MIT License
// Link: https://github.com/lmout82/PHP-Rush-MVC
// Creation date: April 2017
//***********************************************************************************************


class Comment extends Model
{
	public $id         = -1;
	public $content    = "";
	public $user_id    = -1;
	public $username   = "";
	public $article_id = -1;
	public $publication_date = "";


	/*
	** Return true or false on failure
	*/
	public function add()
	{
		$query  = "INSERT INTO comments (content, user_id, article_id) VALUES (:content, :user_id, :article_id)"; 

		$result = $this->dbh->insert($query, array(":content"=>$this->content, ":user_id"=>$this->user_id, ":article_id"=>$this->article_id));
		
		if($result !== false)
		{
			$this->id = $result;
			return true;
		}
			return false;
	}


	/*
	** Delete one comment
	** Use the $id of the article to delete it.
	** Return true or false on failure
	*/
	public function delete()
	{
		$query  = "DELETE FROM comments WHERE id= :id LIMIT 1";

		$result = $this->dbh->delete($query, array(":id"=>$this->id));
		if($result !== false)
			return true;
		else
			return false;
	}


	/*
	** Delete all the comments of one article.
	** Use the $id of the article to delete it.
	** Return true or false on failure
	*/
	public function deleteAll()
	{
		$query  = "DELETE FROM comments WHERE article_id= :article_id";

		$result = $this->dbh->delete($query, array(":article_id"=>$this->article_id));
		if($result !== false)
			return true;
		else
			return false;
	}


	/*
	** Update all the data from one comment (id).
	** Return true or false on failure
	*/
	public function update()
	{
		$query = "UPDATE comments SET content= :content, user_id= :user_id, article_id= :article_id WHERE id= :id";

		$result = $this->dbh->update($query, array(":content"=>$this->content, ":user_id"=>$this->user_id, ":article_id"=>$this->article_id, ":id"=>$this->id));
		if($result !== false)
			return true;
		else
			return false;
	}


	/*
	** Return information about one comment from its id
	** Return false on failure
	*/
	public function get()
	{
		$query = "SELECT * FROM comments INNER JOIN users ON comments.user_id=users.id WHERE id= :id LIMIT 1";

		foreach ($this->dbh->select($query, array(":id"=>$user->id), new Comment) as $one_comment)
		{
			$this->id         = $one_comment->id;
			$this->content    = $one_comment->content;
			$this->user_id    = $one_comment->user_id;
			$this->username   = $one_comment->username;
			$this->article_id = $one_comment->article_id;
			$this->publication_date = $one_comment->publication_date;		

			return true;
		}

		return false;		
	}


	/*
	** Return all the comments from an article
	*/
	public function getAll()
	{
		$comments = array();
		$query = "SELECT * FROM comments INNER JOIN users ON comments.user_id=users.id WHERE article_id= :article_id";

		foreach ($this->dbh->selectArray($query, array(":article_id"=>$this->article_id)) as $one_comment)
		{
			$comments[] = $one_comment;
		}

		return $comments;
	}
}

?>
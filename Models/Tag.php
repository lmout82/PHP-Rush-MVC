<?php
//**********************************************************************************************
//                                     Tag.php
//
// Author(s): lmout82
// Rush PHP-MVC
// Licence:  MIT License
// Link: https://github.com/lmout82/PHP-Rush-MVC
// Creation date: April 2017
//***********************************************************************************************


class Tag extends Model
{
	public $id   = -1;
	public $name = "";


	/*
	** Return true or false on failure
	*/
	public function add()
	{
		$query  = "INSERT IGNORE INTO tags (name) VALUES (:name)"; 

		$result = $this->dbh->insert($query, array(":name"=>$this->name));
		
		if($result !== false)
		{
			$this->id = $result;
			return true;
		}
			return false;
	}

	public function addMapping($article_id, $hashtag)
	{
		$query  = "INSERT INTO tags_mapping (article_id,tag_id) VALUES (:article_id, (SELECT id FROM tags WHERE name= :name) )"; 

		$result = $this->dbh->insert($query, array(":article_id"=>$article_id, ":name"=>$hashtag));
		
		if($result !== false)
		{
			$this->id = $result;
			return true;
		}
			return false;		
	}

	public function deleteMapping($article_id)
	{
		$query  = "DELETE FROM tags_mapping WHERE article_id= :article_id";

		$result = $this->dbh->delete($query, array(":article_id"=>$article_id));
		if($result !== false)
			return true;
		else
			return false;		
	}

	public function getMapping()
	{
		$articles = array();
		$query    = "SELECT * FROM tags_mapping INNER JOIN tags ON tags_mapping.tag_id=tags.id WHERE tags.name= :name"; 

		foreach ($this->dbh->selectArray($query, array(":name"=>$this->name)) as $one_article)
		{
			$articles[] = $one_article;
		}

		return $articles;	
	}

	/*
	** Use the $id of a tag to delete it.
	** Return true or false on failure
	*/
	public function delete()
	{
		$query  = "DELETE FROM tags WHERE id= :id LIMIT 1";

		$result = $this->dbh->delete($query, array(":id"=>$this->id));
		if($result !== false)
			return true;
		else
			return false;
	}


	/*
	** Update the name of a tag.
	** Return true or false on failure
	*/
	public function update()
	{
		$query = "UPDATE tags SET name= :name WHERE id= :id";

		$result = $this->dbh->update($query, array(":name"=>$this->name, ":id"=>$this->id));
		if($result !== false)
			return true;
		else
			return false;
	}


	/*
	** Return information about a tag from its id
	** Return false on failure
	*/
	public function get()
	{
		$query = "SELECT * FROM tags WHERE id= :id LIMIT 1";

		foreach ($this->dbh->select($query, array(":id"=>$this->id), new Tag) as $one_tag)
		{
			$this->name = $one_tag->name;
			return true;
		}

		return false;		
	}


	/*
	** Return all the tags in the database
	*/
	public function getAll()
	{
		$tags = array();
		$query = "SELECT * FROM tags";

		foreach ($this->dbh->selectArray($query, array()) as $one_tag)
		{
			$tags[] = $one_tag;
		}

		return $tags;
	}
}

?>
<?php
//**********************************************************************************************
//                                     Category.php
//
// Author(s): lmout82
// Rush PHP-MVC
// Licence:  MIT License
// Link: https://github.com/lmout82/PHP-Rush-MVC
// Creation date: April 2017
//***********************************************************************************************


class Category extends Model
{
	public $id   = -1;
	public $name = "";


	/*
	** Return true or false on failure
	*/
	public function add()
	{
		$query  = "INSERT INTO categories (name) VALUES (:name)"; 

		$result = $this->dbh->insert($query, array(":name"=>$this->name));
		
		if($result !== false)
		{
			$this->id = $result;
			return true;
		}
			return false;
	}


	/*
	** Use the $id of the category to delete it.
	** Return true or false on failure
	*/
	public function delete()
	{
		$query  = "DELETE FROM categories WHERE id= :id LIMIT 1";

		$result = $this->dbh->delete($query, array(":id"=>$this->id));
		if($result !== false)
			return true;
		else
			return false;
	}


	/*
	** Update the name of the category.
	** Return true or false on failure
	*/
	public function update()
	{
		$query = "UPDATE categories SET name= :name WHERE id= :id";

		$result = $this->dbh->update($query, array(":name"=>$this->name, ":id"=>$this->id));
		if($result !== false)
			return true;
		else
			return false;
	}


	/*
	** Return information about a category from its id
	** Return false on failure
	*/
	public function get()
	{
		$query = "SELECT * FROM categories WHERE id= :id LIMIT 1";

		foreach ($this->dbh->select($query, array(":id"=>$this->id), new Category) as $one_category)
		{
			$this->name = $one_category->name;
			return true;
		}

		return false;		
	}


	/*
	** Return information about a category from its id
	** Return false on failure
	*/
	public function getByName()
	{
		$query = "SELECT * FROM categories WHERE name= :name LIMIT 1";

		foreach ($this->dbh->select($query, array(":name"=>$this->name), new Category) as $one_category)
		{
			$this->id = $one_category->id;
			return true;
		}

		return false;		
	}


	/*
	** Return all the categories in the database
	*/
	public function getAll()
	{
		$categories = array();
		$query = "SELECT * FROM categories";

		foreach ($this->dbh->selectArray($query, array()) as $one_category)
		{
			$categories[] = $one_category;
		}

		return $categories;
	}
}

?>
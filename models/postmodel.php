<?php
/**
 * postmodel.php
 * @class PostModel
 *
 * @author Hameed Ullah Khan - hameed.customphp@gmail.com
 * @version 1.0
 * @date August 13, 2017
 */
 
class PostModel extends Model
{
	private $_name;
	private $_email;
	private $_message;
	
	public function setName($name)
	{
		$this->_name = $name;
	}
	
	public function setEmail($email)
	{
		$this->_email = $email;
	}
	
	public function setMessage($message)
	{
		$this->_message = $message;
	}
	
	public function savePost()
	{
		$sql = "INSERT INTO posts
					(name, email, message)
 				VALUES 
 					(?, ?, ?)";
		
		$data = array(
			$this->_name,
			$this->_email,
			$this->_message
		);
		
		$sth = $this->_db->prepare($sql);
		
		if($sth->execute($data))
			return $this->_db->lastInsertId(); 
		else
			return 0;
	}
	
	public function getPosts()
	{
		$sql = "SELECT
					id, name, email, message, 
					DATE_FORMAT(dt, '%d-%m-%Y %h:%i:%s %p') as date
				FROM 
					posts
				ORDER BY dt DESC";
		
		$this->_setSql($sql);
		$articles = $this->getAll();
		
		if (empty($articles))
		{
			return false;
		}
		
		return $articles;
	}
	
	public function getPostById($id)
	{
		$sql = "SELECT
					id, name, email, message, 
					DATE_FORMAT(dt, '%d-%m-%Y %h:%i:%s %p') as date
				FROM 
					posts
				WHERE 
					id = ?";
		
		$this->_setSql($sql);
		$articleDetails = $this->getRow(array($id));
		
		if (empty($articleDetails))
		{
			return false;
		}
		
		return $articleDetails;
	}
}
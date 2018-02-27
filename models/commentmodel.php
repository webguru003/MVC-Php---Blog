<?php
/**
 * commentmodel.php
 *
 * @author Hameed Ullah Khan - hameed.customphp@gmail.com
 * @version 1.0
 * @date August 13, 2017
 */
class CommentModel extends Model
{
	private $_name;
	private $_email;
	private $_message;
	private $_postId;
	
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
	
	public function setPostId($post_id)
	{
		$this->_postId = $post_id;
	}
	
	public function saveComment()
	{
		$sql = "INSERT INTO comments
					(name,email, message, post_id)
 				VALUES 
 					(?, ?, ?, ?)";
		
		$data = array(
			$this->_name,
			$this->_email,
			$this->_message,
			$this->_postId
		);
		
		$sth = $this->_db->prepare($sql);
		
		if($sth->execute($data))
			return $this->_db->lastInsertId(); 
		else
			return 0;
	}
	

	public function getCommentByPostId($id)
	{
		$sql = "SELECT
					name, message, email, 
					DATE_FORMAT(dt, '%d-%m-%Y %h:%i:%s %p') as date
				FROM 
					comments
				WHERE 
					post_id = ?";
		
		$this->_setSql($sql);
		$comments = $this->getAll(array($id));
		
		if (empty($comments))
		{
			return false;
		}
		
		return $comments;
	}
	
	public function getCommentById($id)
	{
		$sql = "SELECT
					id, name, message, email, 
					DATE_FORMAT(dt, '%d-%m-%Y %h:%i:%s %p') as date
				FROM 
					comments
				WHERE 
					id = ?";
		
		$this->_setSql($sql);
		$comments = $this->getRow(array($id));
		
		if (empty($comments))
		{
			return false;
		}
		
		return $comments;
	}
}
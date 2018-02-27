<?php
/**
 * model.php
 * @class Model
 *
 * @author Hameed Ullah Khan - hameed.customphp@gmail.com
 * @version 1.0
 * @date August 13, 2017
 */
 
class Model 
{
	protected $_db;
	protected $_sql;
	
	/**
	* Consturctor of Model class is initiated.
	* 
	* @param no parameter
	* @return Constructor doesn't get return values; they serve entirely to instantiate the class.
	*/
	public function __construct()
	{
		/**
		* initiate database Db class.
		*/
		$this->_db = Db::init();
	}
	
	/**
	* This method is used to set sql
	*/
	protected function _setSql($sql)
	{
		$this->_sql = $sql;
	}
	
	/**
	* This method is used to getAll records, accepting one paramter $data
	*/
	public function getAll($data = null)
	{
		if (!$this->_sql)
		{
			throw new Exception("No SQL query!");
		}
		
		$sth = $this->_db->prepare($this->_sql);
		$sth->execute($data);
		return $sth->fetchAll();
	}
	
	/**
	* This method is used to get one row, accepting on parameter
	*/
	public function getRow($data = null)
	{
		if (!$this->_sql)
		{
			throw new Exception("No SQL query!");
		}
		
		$sth = $this->_db->prepare($this->_sql);
		$sth->execute($data);
		return $sth->fetch();
	}
}
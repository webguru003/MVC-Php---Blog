<?php
/**
 * db.php
 * @class DB
 *
 * @author Hameed Ullah Khan - hameed.customphp@gmail.com
 * @version 1.0
 * @date August 13, 2017
 */
 
class Db
{
	/**
	* @var varaiable $db; A static variable exists only in a local function scope, but it does not lose its value when program execution leaves this scope.
	*/
	private static $db;
	
	public static function init()
	{
		if (!self::$db)
		{
			try {
				/**
				* @pdo PHP Data Objects connection.
				*/
				$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=UTF8';
				self::$db = new PDO($dsn, DB_USER, DB_PASS);
				self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				die('Connection error: ' . $e->getMessage());
			}
		}
		return self::$db;
	}
}

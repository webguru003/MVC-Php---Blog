<?php
/**
 * bootstrap.php
 *
 * @author Hameed Ullah Khan - hameed.customphp@gmail.com
 * @version 1.0
 * @date August 13, 2017
 */
 
/**
* created 3 variables; array $controller, array $action and $query null.
*/

$controller = "post";
$action = "index";
$query = null;

/**
* It check the load is set or not - Load rule is defined in .htaccess file
*/
if(isset($_GET['load']))
{
	$params = array();
	$params = explode("/", $_GET['load']);
	
	/**
	* @ucwords Uppercase the first character of each word in a string
	*/
	$controller = ucwords($params[0]);
	
	if (isset($params[1]) && !empty($params[1]))
	{
		$action = $params[1];
	}
	
	if (isset($params[2]) && !empty($params[2]))
	{
		$query = $params[2];
	}
}

$modelName = $controller;
$controller .= 'Controller';
$load = new $controller($modelName, $action);

/**
* Checks if the class method exists.
*/
if (method_exists($load, $action))
{
    $load->{$action}($query);
}
else 
{
	
	/**
	* if the mothod doesn't exist then it will trigger error die().
	*/
	die('Invalid method. Please check the URL.');
}
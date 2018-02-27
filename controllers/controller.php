<?php
/*
 * Class Controller
 *
 * @author Hameed Ullah Khan - hameed.customphp@gmail.com
 * @version 1.0
 * @date August 13, 2017
 */
class Controller
{
	protected $_model;
	protected $_controller;
	protected $_action;
	protected $_view;
	protected $_modelBaseName;
	
	
	/**
	* The contructor is used to initiate Controllter class.
	* 
	* @param $model Model and $action method of this class
	* @return Constructor doesn't get return values; they serve entirely to instantiate the class.
	*/
	public function __construct($model, $action)
	{
		$this->_controller = ucwords(__CLASS__);
		$this->_action = $action;
		$this->_modelBaseName = $model;
		
		$this->_view = new View(HOME . DS . 'views' . DS . strtolower($this->_modelBaseName) . DS . $action . '.tpl');
	}
	
	
	/**
	* This method is used to set Model, accepting one paramameter $modelName string.
	*/ 
	protected function _setModel($modelName)
	{
		$modelName .= 'Model';
		$this->_model = new $modelName();
	}
	
	/**
	* This method is used to set View, accepting one paramameter $modelName string.
	*/ 
	protected function _setView($viewName)
	{
		$this->_view = new View(HOME . DS . 'views' . DS . strtolower($this->_modelBaseName) . DS . $viewName . '.tpl');
	}
}

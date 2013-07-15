<?php

namespace MasheryApi;

class Service
{
	/**
	 * Request object
	 * @var \MasheryApi\Request
	 */
	private $request = null;

	/**
	 * Set the current MasheryApi\Request object
	 * 
	 * @param \MasheryApi\Request $request Request object
	 */
	public function setRequest(\MasheryApi\Request $request)
	{
		$this->request = $request;
	}

	/**
	 * Get the current \MasheryApi\Request object
	 * 
	 * @return \MasheryApi\Request object
	 */
	public function getRequest()
	{
		return $this->request;
	}

	/**
	 * Magic method to catch our get* methods
	 * 
	 * @param string $func Function name
	 * @param array $args Function arguments
	 * @return object|null Object if found, null if not
	 */
	public function __call($func, $args)
	{
		if (strpos($func, 'get') !== false) {
			$modelClass = '\\MasheryApi\\'.str_replace('get', '', $func);
			if (class_exists($modelClass)) {
				$model = new $modelClass($this->getRequest());
				$result = $model->find($args);
				return ($result !== null) ? $model : null;
			}
		}
		return null;
	}
}
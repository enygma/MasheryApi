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
	 * Magic method to catch our action methods
	 *
	 * @param string $func Function name
	 * @param array $args Function arguments
	 * @return object|null Object if found, null if not
	 */
	public function __call($func, $args)
	{
		// find the position of the first capital letter
		preg_match('/([a-z]+)(.+)/', $func, $match);

		if (!empty($match)) {
			$type = $match[1];
			$class = $match[2];

			$modelClass = '\\MasheryApi\\'.$match[2];
			if (class_exists($modelClass)) {
				$model = new $modelClass($this->getRequest());
				$type = strtolower($type);

				if (method_exists($model, '_preMethod')) {
					$model->_preMethod($args);
				}

				if (method_exists($model, $type) === true) {
					$result = $model->$type($args);
				} else {
					$result = $model->find($args);
				}

				return ($result !== null) ? $model : null;
			}
		}
		return null;
	}

	/**
	 * Getter to handle object calls/creates from service
	 *
	 * @param string $param Object name
	 * @return mixed Object instance if exists, null otherwise
	 */
	public function __get($param)
	{
		$modelName = ucwords(strtolower($param));
		$modelClass = '\\MasheryApi\\'.$modelName;
		if (class_exists($modelClass)) {
			// make a new instance and return it
			return new $modelClass($this->getRequest());
		}
		return null;
	}
}
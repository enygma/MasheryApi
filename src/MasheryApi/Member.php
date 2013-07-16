<?php

namespace MasheryApi;

class Member extends \MasheryApi\Model
{
	/**
	 * Member properties
	 * @var array
	 */
	protected $properties = array(
		'username' => array(
			'type' => 'string',
			'maxlength' => '255'
		),
		'email' => array(
			'type' => 'string'
		),
		'display_name' => array(
			'type' => 'string'
		),
		'blog' => array(
			'type' => 'string'
		),
		'area_status' => array(
			'type' => 'string'
		)
	);

	/**
	 * Find the member based on username
	 * 
	 * @throws \Exception If error on user find
	 * @return \MasheryApi\Member Member object
	 */
	public function find()
	{
		$args = func_get_args();

		// check for the username
		if (!isset($args[0][0])) {
			throw new \InvalidArgumentException('Invalid username!');
		}
		$username = $args[0][0];
		$data = json_encode(array(
			'method' => 'member.fetch',
			'params' => array($username),
			'id' => 1
		));

		try {
			$result = $this->getRequest()->send($data);
			if ($result->result !== null) {
				$this->values((array)$result->result);
			}
			return $this;

		} catch (\Exception $e) {
			throw new \Exception('There was an error fetching user "'.$username.'"');
		}
	}
}
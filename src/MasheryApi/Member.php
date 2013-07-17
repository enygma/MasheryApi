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
		),
		'uri' => array(
			'type' => 'string'
		),
		'im' => array(
			'type' => 'string'
		),
		'imsvc' => array(
			'type' => 'string'
		),
		'phone' => array(
			'type' => 'string'
		),
		'company' => array(
			'type' => 'string'
		),
		'address1' => array(
			'type' => 'string'
		),
		'address2' => array(
			'type' => 'string'
		),
		'locality' => array(
			'type' => 'string'
		),
		'region' => array(
			'type' => 'string'
		),
		'postal_code' => array(
			'type' => 'string'
		),
		'country_code' => array(
			'type' => 'string'
		),
		'first_name' => array(
			'type' => 'string'
		),
		'last_name' => array(
			'type' => 'string'
		),
		'registration_ipaddr' => array(
			'type' => 'string'
		),
		'external_id' => array(
			'type' => 'string'
		),
		'passwd_new' => array(
			'type' => 'string'
		),
		'keys' => array(
			'type' => 'array'
		),
		'applications' => array(
			'type' => 'array'
		),
		'roles' => array(
			'type' => 'array'
		),
	);

    /**
     * Executed pre-method call on the model
     *     Populates Member if one is given
     *
     * @param array $args Arguments list
     */
    public function _preMethod($args)
    {
        foreach ($args as $argument) {
            // if we were given a member as a part of these arguments, populate it
            if ($argument instanceof \MasheryApi\Member) {
                $this->values($argument->values());
            }
        }
    }

    /**
     * Send the request to the API
     *
     * @param array $args Arguments
     * @param string $data Data to send
     * @param string $errorMsg Error message
     * @return boolean Success/fail of request
     */
    public function request($args, $data, $errorMsg = 'There was an error: [message]')
    {
        try {
            $result = $this->getRequest()->send($data);
            return true;
        } catch (\Exception $e) {
            $errorMsg = str_replace('[message]', $e->getMessage(), $errorMsg);
            throw new \Exception($errorMsg);
        }
    }

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

	/**
	 * Add a new Member
	 * 
	 * @param [type] $data [description]
	 * @return \MasheryApi\Member Member object
	 * @throws \Exception If error on user create
	 */
	public function add($data = null)
	{
		$data = json_encode(array(
			'method' => 'member.create',
			'params' => array($data),
			'id' => 1
		));

		try {
			$result = $this->getRequest()->send($data);
			if ($result->result !== null) {
				$this->values((array)$result->result);
			}
			return $this;
		} catch (\Exception $e) {
			throw new \Exception('There was an error creating user: '.$e->getMessage());
		}
	}

	/**
	 * Update an existing user
	 * 
	 * @param array $args Arguments (Member + data to update)
	 * @return \MasheryApi\Member Member object
	 */
	public function update($args)
	{
		if (!isset($args[0]) || !($args[0] instanceof \MasheryApi\Member)) {
			throw new \InvalidArgumentException('Invalid member provided!');
		}
		$member = $args[0];
		$data = json_encode(array(
			'method' => 'member.update',
			'params' => array(
				array_merge($args[1], array('username' => $member->username))
			),
			'id' => 1
		));

		try {
			$result = $this->getRequest()->send($data);
			if ($result->result !== null) {
				$this->values((array)$result->result);
			}
			return $this;
		} catch (\Exception $e) {
			throw new \Exception('There was an error updating user: '.$e->getMessage());
		}
	}

	/**
	 * Delete the given member
	 * 
	 * @param array $args Arguments (Member + data to update)
	 * @return boolean|\Exception Success/fail of delete request
	 */
	public function delete($args)
	{
		if (!isset($args[0]) || !($args[0] instanceof \MasheryApi\Member)) {
			throw new \InvalidArgumentException('Invalid member provided!');
		}
		$member = $args[0];
		$data = json_encode(array(
			'method' => 'member.delete',
			'params' => array($member->username),
			'id' => 1
		));

		try {
			$result = $this->getRequest()->send($data);
			return true;
		} catch (\Exception $e) {
			throw new \Exception('There was an error updating user: '.$e->getMessage());
		}
	}

	/**
	 * Enable a user
	 * 
	 * @param array $args Arguments (Member)
	 * @return \MasheryApi\Member Member object
	 */
	public function enable($args)
	{
		$args[1]['area_status'] = 'active';
		return $this->update($args);
	}

	/**
	 * Disable a user
	 * 
	 * @param array $args Arguments (Member)
	 * @return \MasheryApi\Member Member object
	 */
	public function disable($args)
	{
		$args[1]['area_status'] = 'disabled';
		return $this->update($args);
	}
}
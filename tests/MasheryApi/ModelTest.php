<?php
require_once 'MockModel.php';

class ModelTest extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->model = new MockModel();
	}

	/**
	 * Test the setting of values through values() method
	 * 
	 * @covers \MasheryApi\Model::values
	 */
	public function testSetValidValues()
	{
		$testString = 'this is a test';
		$values = array(
			'test1' => $testString
		);

		$this->model->values($values);
		$this->assertEquals(
			$this->model->test1,
			$testString
		);
	}

	/**
	 * Test the setting of a value on a valid property
	 * 
	 * @covers \MasheryApi\Model::__get
	 * @covers \MasheryApi\Model::__set
	 */
	public function testSetValidProperty()
	{
		$testString = 'this is a test';
		$this->model->test1 = $testString;

		$this->assertEquals(
			$this->model->test1,
			$testString
		);
	}

	/**
	 * Test the setting of a property that's not valid 
	 * 	(not in properties array)
	 * 
	 * @covers \MasheryApi\Model::__get
	 * @covers \MasheryApi\Model::__set
	 */
	public function testSetInvalidProperty()
	{
		$testString = 'this is a test';
		$this->model->test2 = $testString;

		$this->assertEquals(
			$this->model->test2,
			null
		);
	}

}
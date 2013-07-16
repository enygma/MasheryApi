<?php
require_once 'MockModel.php';

class ModelTest extends \PHPUnit_Framework_TestCase
{
	private $model = null;
	
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

	/**
	 * Test the setting of the Request on init of the model
	 * 
	 * @covers \MasheryApi\Model::__construct
	 * @covers \MasheryApi\Model::setRequest
	 */
	public function testSetRequestOnConstruct()
	{
		$request = new \MasheryApi\Request();
		$model = new \MockModel($request);

		$this->assertNotNull($model->getRequest());
		$this->assertTrue($model->getRequest() instanceof \MasheryApi\Request);
	}

	/**
	 * Test that the values method returns all when no data is given
	 * 
	 * @covers \MasheryApi\Model::values
	 */
	public function testGetAllValues()
	{
		$testString = 'this is a test';
		$this->model->test1 = $testString;
		$values = $this->model->values();

		$this->assertTrue(
			isset($values['test1']) && $values['test1'] === $testString
		);
	}

	/**
	 * Test the setting and getting of the Request object
	 * 
	 * @covers \MasheryApi\Model::getRequest
	 * @covers \MasheryApi\Model::setRequest
	 */
	public function testGetRequest()
	{
		$request = new \MasheryApi\Request();
		$this->model->setRequest($request);

		$this->assertTrue(
			$this->model->getRequest() instanceof \MasheryApi\Request
		);
	}
}
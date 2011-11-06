<?php

namespace Siny\Amazon\ProductAdvertisingAPIBundle\Tests\API;

class OperationTest extends \PHPUnit_Framework_TestCase
{
    const DUMMY_OPERATION_NAME  = 'OperationName';
    const DUMMY_PARAMETER_KEY   = 'DummyKey';
    const DUMMY_PARAMETER_VALUE = 'DummyValue';

    private $dummyParameters = array(
        self::DUMMY_PARAMETER_KEY => self::DUMMY_PARAMETER_VALUE
    );


    private $operation;

    public function setUp()
    {
        $this->operation = $this->getMockForAbstractClass(
        	'Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation',
            array(self::DUMMY_OPERATION_NAME, $this->dummyParameters));
    }

    /**
     * get operation name in the case of default
     */
    public function testGetOperationNameInTheCaseOfDefault()
    {
        $this->assertSame(
            self::DUMMY_OPERATION_NAME, $this->operation->getOperation(),
            "Operation name wasn't same.");
    }

    /**
     * get parameters in the case of default
     */
    public function testGetParametersInTheCaseOfDefault()
    {
        $this->assertSame(
            $this->dummyParameters, $this->operation->getParameters(),
            "Parameters waren't empty");
    }

    /**
     * set parameters
     */
    public function testSetParameters()
    {
        $setParameters = array('foo' => 'bar');
        $this->operation->setParameters($setParameters);

        $this->assertSame(
            $setParameters, $this->operation->getParameters(),
            "Parameters waren't set dummy parameters");
    }

    /**
     * set parameter (one parameter)
     */
    public function testSetParameter()
    {
        $key   = 'foo';
        $value = 'bar';
        $this->operation->setParameter($key, $value);

        $this->assertSame(
            array_merge($this->dummyParameters, array($key => $value)),
            $this->operation->getParameters(),
            "Parameters waren't set one dummy paramter");
    }

    /**
     * add parameters
     */
    public function testAddParameters()
    {
        $addParameters = array('foo' => 'bar');
        $this->operation->addParameters($addParameters);

        $this->assertSame(
            array_merge($this->dummyParameters, $addParameters),
            $this->operation->getParameters(),
            "Parameters waren't add dummy parameters");
    }

    /**
     * get parameter of specified key
     */
    public function testGetParameter()
    {
        $this->assertSame(
            self::DUMMY_PARAMETER_VALUE,
            $this->operation->getParameter(self::DUMMY_PARAMETER_KEY),
            "Parameter wasn't same.");
    }

    /**
     * Exception occur if the parameter that tried to get doesn't exist.
     *
     * @expectedException Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\Exception\OperationException
     * @expectedExceptionMessage 'FailedKey' parameter was not found
     */
    public function testExceptionOccurIfTheParameterThatTriedToGetDoesNotExist()
    {
        $this->operation->getParameter('FailedKey');
    }
}

<?php namespace App\Tests;

class FakeTest extends \Codeception\Test\Unit
{
    /**
     * @var \App\Tests\FunctionalTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $test = 'hello';
        $this->assertEquals('hello', $test);
    }
}
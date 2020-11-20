<?php
namespace App\Tests\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\TestInterface;

/**
 * Class Functional
 * @package App\Tests\Helper
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class Functional extends \Codeception\Module
{
    /**
     * @var Fixtures
     */
    private $fixtureHelper;

    /**
     * @throws \Codeception\Exception\ModuleException
     */
    public function _initialize()
    {
        $this->fixtureHelper = $this->getModule('\App\Tests\Helper\Fixtures');
    }

    /**
     * @param array $settings
     * @throws \Codeception\Exception\ModuleException
     * @throws \Codeception\Exception\ModuleRequireException
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    public function _beforeSuite($settings = [])
    {
        $this->fixtureHelper->dropSchema();
        $this->fixtureHelper->createSchema();
        $this->fixtureHelper->loadBaseFixtures();
    }

    /**
     * @throws \Codeception\Exception\ModuleException
     */
    public function _afterSuite()
    {
        $this->fixtureHelper->dropSchema();
    }

    /**
     * @param TestInterface $test
     * @param \Exception $fail
     * @throws \Codeception\Exception\ModuleConfigException
     * @throws \Codeception\Exception\ModuleException
     */
    public function _failed(TestInterface $test, $fail)
    {
        $this->fixtureHelper->validateConfig();
    }
}

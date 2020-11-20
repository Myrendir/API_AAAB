<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 11/17/20
 * Time: 5:18 PM
 */

namespace App\Tests\Helper;

use App\Tests\_data\fixtures\TeamFixtures;
use App\Tests\_data\fixtures\TournamentFixtures;
use App\Tests\_data\fixtures\UsersFixtures;
use Codeception\Module\Doctrine2;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Tools\SchemaTool;

/**
 * Class Fixtures
 * @package App\Tests\_support\Helper
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class Fixtures extends \Codeception\Module
{
    /**
     * @var EntityManager
     */
    protected $manager;

    /**
     * @var SchemaTool
     */
    protected $schemaTool;

    /**
     * @var ClassMetadata[]
     */
    protected $classMetaData;

    /**
     * @var Loader
     */
    protected $loader;

    /**
     * @throws \Doctrine\ORM\Tools\ToolsException
     * @throws \Codeception\Exception\ModuleException
     */
    public function createSchema()
    {
        $this->getSchemaTool()->createSchema($this->getClassesMetaData());
        $this->debugSection('Fixtures', 'Schema created');
    }

    /**
     * Drop Schema
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function dropSchema()
    {
        $this->getSchemaTool()->dropSchema($this->getClassesMetaData());
        $this->debugSection('Fixtures', 'Schema dropped');
    }

    /**
     * Emptied Database
     */
    public function emptyDatabase()
    {
        $this->_dropSchema();
        $this->_createSchema();

        $this->debugSection('Fixtures', 'Database emptied');
    }

    /**
     * @return Loader
     *
     * @throws \Codeception\Exception\ModuleException
     */
    private function getLoader()
    {
        if (null === $this->loader) {
            $this->loader = $this->getModule('Symfony')->grabService('test.doctrine.fixtures.loader');
        }

        return $this->loader;
    }

    /**
     * @return EntityManager
     *
     * @throws \Codeception\Exception\ModuleException
     */
    private function getManager()
    {
        if (null === $this->manager) {
            $doctrine = $this->getModule('Symfony')->grabService('doctrine');
            $this->manager = $doctrine->getManager();
        }

        return $this->manager;
    }

    /***
     * @return SchemaTool
     *
     * @throws \Codeception\Exception\ModuleException
     */
    private function getSchemaTool()
    {
        if (null === $this->schemaTool) {
            $this->schemaTool = new SchemaTool($this->getManager());
        }

        return $this->schemaTool;
    }

    /**
     * @return ClassMetadata[]|\Doctrine\Persistence\Mapping\ClassMetadata[]
     *
     * @throws \Codeception\Exception\ModuleException
     */
    private function getClassesMetaData()
    {
        if (null === $this->classMetaData) {
            $this->classMetaData = $this->getManager()->getMetadataFactory()->getAllMetadata();
        }

        return $this->classMetaData;
    }

    /**
     * @throws \Codeception\Exception\ModuleException
     * @throws \Codeception\Exception\ModuleRequireException
     */
    public function loadBaseFixtures()
    {
        $this->debugSection('Fixtures', 'Load Fixtures');

        /** @var Doctrine2 $doctrine */
        $doctrine = $this->getModule('Doctrine2');
        $doctrine->loadFixtures([
            UsersFixtures::class,
            TeamFixtures::class,
            TournamentFixtures::class
        ], false);
    }

}
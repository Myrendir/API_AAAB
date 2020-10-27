<?php

namespace App\Tests;

use Codeception\Util\HttpCode;

class UserControllerTest extends \Codeception\Test\Unit
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
    public function testGetAllUsers()
    {
        /**
         * Register a new user for Auth
         */
        $this->tester->sendPostJson('/user/register', [
            'summonerName' => 'Michel',
            'email' => 'michel@example.com',
            'password' => 'michelle1',
            'confirmPassword' => 'michelle1'
        ]);
        $this->tester->sendPostJson('/user/register', [
            'summonerName' => 'Alex',
            'email' => 'alex@example.com',
            'password' => 'michelle1',
            'confirmPassword' => 'michelle1'
        ]);
        /**
         * Try to recover the token with the new user
         */
        $this->tester->createAuthenticatedClient('Michel', 'michelle1');
        /**
         * Request get for the url
         */
        $this->tester->sendGet('/api/user/list');
        $this->tester->seeResponseContainsJson([
            'email' => 'michel@example.com',
            'email' => 'alex@example.com'
        ]);
        $this->tester->seeResponseCodeIs(HttpCode::OK);
    }

    public function testGetUserBySummonerName()
    {
        /**
         * Register a new user for Auth
         */
        $this->tester->sendPostJson('/user/register', [
            'summonerName' => 'Michel',
            'email' => 'michel@example.com',
            'password' => 'michelle1',
            'confirmPassword' => 'michelle1'
        ]);
        /**
         * Try to recover the token with the new user
         */
        $this->tester->createAuthenticatedClient('Michel', 'michelle1');
        /**
         * Request get for the url
         */
        $this->tester->sendGet('/api/user/get/Michel');
        $this->tester->seeResponseContainsJson(['summoner_name' => 'Michel']);
        $this->tester->seeResponseCodeIs(HttpCode::OK);
    }
}
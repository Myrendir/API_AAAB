<?php

namespace App\Tests;

use Codeception\Util\HttpCode;

class RegisterControllerTest extends \Codeception\Test\Unit
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
    public function testRegisterUser()
    {
        $this->tester->wantTo('register a new account');

        /**
         * Register new user
         */
        $this->tester->sendPostJson('/user/register', [
            'summonerName' => 'Alex',
            'password' => 'michelle1',
            'confirmPassword' => 'michelle1'
        ]);

        $this->tester->seeResponseContainsJson([0 => 'User Created']);
        $this->tester->seeResponseCodeIsSuccessful();

        /**
         * Try to login
         */
        $this->tester->sendPostJson('/api/login', [
            'username' => 'Alex',
            'password' => 'michelle1'
        ]);
        $this->tester->seeResponseCodeIs(HttpCode::OK);

    }

    public function testSummonerNameEmpty()
    {
        /**
         * Summoner Name empty
         */
        $this->tester->sendPostJson('/user/register', [
            'summonerName' => '',
            'password' => 'michelle1',
            'confirmPassword' => 'michelle1'
        ]);

        $this->tester->seeResponseContainsJson([0 => 'The field Summoner Name is missing.']);
        $this->tester->seeResponseCodeIs(400);
    }
}
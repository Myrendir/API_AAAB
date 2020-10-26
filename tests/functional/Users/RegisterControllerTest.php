<?php

namespace App\Tests;

use Codeception\Util\HttpCode;

class RegisterControllerTest extends \Codeception\Test\Unit
{
    protected $summonerName = 'Alex';
    protected $password = 'michelle1';
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
        /**
         * Register new user
         */
        $this->tester->sendPostJson('/user/register', [
            'summonerName' => $this->summonerName,
            'password' => $this->password,
            'confirmPassword' => $this->password
        ]);

        $this->tester->seeResponseContainsJson([0 => 'User Created']);
        $this->tester->seeResponseCodeIsSuccessful();

        /**
         * Try to login
         */
        $this->tester->sendPostJson('/api/login', [
            'username' => $this->summonerName,
            'password' => $this->password,
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
            'password' => $this->password,
            'confirmPassword' => $this->password
        ]);

        $this->tester->seeResponseContainsJson([0 => 'The field Summoner Name is missing.']);
        $this->tester->seeResponseCodeIs(400);
    }

    public function testNoEqualPassword()
    {
        /**
         * confirmPassword not equal
         */
        $this->tester->sendPostJson('/user/register', [
            'summonerName' => $this->summonerName,
            'password' => $this->password,
            'confirmPassword' => 'michel'
        ]);

        $this->tester->seeResponseContainsJson([0 => 'The field Confirmation were not equal to Password.']);
        $this->tester->seeResponseCodeIs(400);
    }

    public function testSummonerNameAlready()
    {
        /**
         * Register new user
         */
        $this->tester->sendPostJson('/user/register', [
            'summonerName' => $this->summonerName,
            'password' => $this->password,
            'confirmPassword' => $this->password
        ]);

        /**
         * Register new user but same Summoner Name
         */
        $this->tester->sendPostJson('/user/register', [
            'summonerName' => $this->summonerName,
            'password' => $this->password,
            'confirmPassword' => $this->password
        ]);
        $this->tester->seeResponseContainsJson([0 => 'This summonerName is already used.']);
        $this->tester->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }
}
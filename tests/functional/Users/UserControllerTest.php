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

    public function testEditProfile()
    {
        /**
         * Try to recover the token with the new user
         */
        $this->tester->createAuthenticatedClient('Michel', 'michelle1');
        /**
         * Try to edit the profile
         */
        $this->tester->sendPatchJson('/api/user/edit', [
            'summonerName' => 'Luffy',
            'email' => 'luffy@example.com',
            'availability' => false
        ]);
        /**
         * Verify the response is exactly at the content
         */
        $this->tester->seeResponseContainsJson([0 => 'User Update']);
        /**
         * Try new Auth
         */
        $this->tester->createAuthenticatedClient('Luffy', 'michelle1');
        /**
         * Check if user exist and the content correspond
         */
        $this->tester->sendGet('/api/user/get/Luffy');
        $this->tester->seeResponseContainsJson(['summoner_name' => 'Luffy']);
        $this->tester->seeResponseCodeIs(HttpCode::OK);
    }
}
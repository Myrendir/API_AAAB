<?php

namespace App\Tests;

class TournamentControllerTest extends \Codeception\Test\Unit
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
    public function testCreateTournament()
    {
        $this->tester->createAuthenticatedClient('Michel', 'michelle1');

        $this->tester->sendPostJson('/api/tournament/create', [
            'name' => 'Tournament',
            'format' => ['5vs5'],
            'map' => ['Summoner\'s Rift'],
            'slots' => 35,
            'teams' => 'Team1'
        ]);
        $this->tester->seeResponseCodeIs(200);
        $this->tester->seeResponseContainsJson([0 => 'Tournament created']);
    }

    public function testListTournament()
    {
        $this->tester->createAuthenticatedClient('Michel', 'michelle1');

        $this->tester->sendGet('/api/tournament/all');
        $this->tester->seeResponseCodeIs(200);
        $this->tester->seeResponseContainsJson([0 => ['id' => 1]]);
    }
}
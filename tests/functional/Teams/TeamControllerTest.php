<?php

namespace App\Tests;

class TeamControllerTest extends \Codeception\Test\Unit
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
    public function testCreateTeam()
    {
        $this->tester->createAuthenticatedClient('Michel', 'michelle1');
        $this->tester->sendPostJson('/api/team/create', [
            'name' => 'Best',
            'top' => 'Michel',
            'mid' => 'Michel',
            'adc' => 'Michel',
            'jungle' => 'Michel',
            'support' => 'Michel',
        ]);
        $this->tester->seeResponseCodeIs(200);
        $this->tester->seeResponseContainsJson([0 => 'Team created']);
    }

    public function testListTeams()
    {
        $this->tester->createAuthenticatedClient('Michel', 'michelle1');

        $this->tester->sendGet('/api/team/list');
        $this->tester->seeResponseCodeIs(200);
        $this->tester->seeResponseContainsJson([0 => ['id' => 1]]);
    }

    public function testGetTeamByName()
    {
        $this->tester->createAuthenticatedClient('Michel', 'michelle1');

        $this->tester->sendGet('/api/team/get/Team1');
        $this->tester->seeResponseCodeIs(200);
        $this->tester->seeResponseContainsJson(['name' => 'Team1']);
    }

    public function testUpdateTeam()
    {
        $this->tester->createAuthenticatedClient('Michel', 'michelle1');

        $this->tester->sendPatchJson('/api/team/update/Team1', [
            'name' => 'TeamNumberOne',
            'top' => null,
            'mid' => null,
            'adc' => null,
            'jungle' => null,
            'support' => null
        ]);
        $this->tester->seeResponseContainsJson([0 => 'Team updated']);
        $this->tester->seeResponseCodeIs(200);
        $this->tester->sendGet('/api/team/get/TeamNumberOne');
        $this->tester->seeResponseContainsJson(['name' => 'TeamNumberOne']);
    }
}
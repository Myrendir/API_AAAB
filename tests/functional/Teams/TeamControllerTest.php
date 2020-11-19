<?php namespace App\Tests\Teams;

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
}
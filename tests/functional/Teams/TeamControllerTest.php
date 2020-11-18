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
            'top' => 1,
            'mid' => 2,
            'adc' => 3,
            'jungle' => 4,
            'support' => 5,
        ]);
        $this->tester->seeResponseCodeIs(200);
        $this->tester->seeResponseContainsJson([0 => 'Team created']);
    }
}
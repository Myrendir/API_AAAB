<?php namespace App\Tests\Report;

class ReportControllerTest extends \Codeception\Test\Unit
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
    public function testAddReport()
    {
        $this->tester->createAuthenticatedClient('Alex', 'michelle1');
        /**
         * Try to create a report
         */
        $this->tester->sendPostJson('/api/report/create', [
            'user' => 'Michel',
            'motif' => 'Any kind of hate speech such as homophobia, sexism, racism, and ableism',
            'comment' => 'Il n\'a pas arrêté de me flame'
        ]);
        $this->tester->seeResponseContainsJson([0 => 'Report created.']);
        $this->tester->seeResponseCodeIsSuccessFul();
    }
}
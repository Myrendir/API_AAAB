<?php

namespace App\Tests;

use Codeception\Test\Unit;
use Codeception\Util\HttpCode;

class ReportControllerTest extends Unit
{
    protected $test;

    protected function _before()
    {
        parent::_before();
    }

    protected function _after()
    {
        parent::_after();
    }


    public function testAddReport()
    {
        /**
         * Try to create a report
         */
        $this->test->sendPostJson('/api/report/create', [
            'Motif' => 'Insult',
            'Comment' => 'Il n\'a pas arrêté de me flame'
        ]);
        $this->test->seeResponseContainsJson([0 => 'Successfully reported']);
        $this->test->seeResponseCodeIsSuccessFul();
    }

}

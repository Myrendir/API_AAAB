<?php namespace App\Tests\Manager;

use App\Manager\ReportManager;
use App\Repository\ReportRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;

class ReportManagerTest extends \Codeception\Test\Unit
{
    /**
     * @var \App\Tests\UnitTester
     */
    protected $tester;

    /**
     * @var MockObject
     */
    protected $entityManagerMock;

    /**
     * @var MockObject
     */
    protected $loggerMock;

    /**
     * @var MockObject
     */
    protected $reportRepositoryMock;

    /**
     * @var ReportManager
     */
    protected $reportManager;
    
    protected function _before()
    {
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->reportRepositoryMock = $this->createMock(ReportRepository::class);

        $this->reportManager = new ReportManager($this->entityManagerMock, $this->reportRepositoryMock, $this->loggerMock);
    }

    protected function _after()
    {
    }

    // tests
    public function testCreateReport()
    {
        $report = $this->reportManager->createReport();

        $this->tester->assertFalse($report->getIsEnabled());
    }
}
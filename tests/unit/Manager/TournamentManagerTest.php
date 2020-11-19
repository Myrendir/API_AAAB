<?php namespace App\Tests\Manager;

use App\Entity\Tournament;
use App\Manager\TournamentManager;
use App\Repository\TournamentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;

class TournamentManagerTest extends \Codeception\Test\Unit
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
    protected $tournamentRepositoryMock;

    /**
     * @var TournamentManager
     */
    protected $tournamentManager;
    
    protected function _before()
    {
        parent::_before();
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->tournamentRepositoryMock = $this->createMock(TournamentRepository::class);

        $this->tournamentManager = new TournamentManager($this->entityManagerMock, $this->loggerMock, $this->tournamentRepositoryMock);
    }

    protected function _after()
    {
    }

    // tests
    public function testCreateTournament()
    {
        $tournament = $this->tournamentManager->createTournament();

        $this->tester->assertTrue($tournament->getIsEnabled());
    }

    public function testGetTournamentByName()
    {
        $tournament = new Tournament();

        $this->tournamentRepositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => 'Tournament1'])
            ->willReturn($tournament)
        ;

        $tournamentFound = $this->tournamentManager->getTournamentByName('Tournament1');
        $this->tester->assertSame($tournament, $tournamentFound);
    }

    public function testGetTournamentByNameNotUnique()
    {
        $this->tournamentRepositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => 'Tournament1'])
            ->willThrowException(new NonUniqueResultException())
        ;

        $this->loggerMock
            ->expects($this->once())
            ->method('error')
            ->with('There are multiple tournament with the name : Tournament1')
        ;

        $tournamentFound = $this->tournamentManager->getTournamentByName('Tournament1');

        $this->assertNull($tournamentFound);
    }

    public function testGetTournamentByNameNotFound()
    {
        $this->tournamentRepositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => 'Tournament1'])
            ->willThrowException(new NoResultException())
        ;

        $tournamentFound = $this->tournamentManager->getTournamentByName('Tournament1');

        $this->assertNull($tournamentFound);
    }
}
<?php namespace App\Tests\Manager;

use App\Entity\Teams;
use App\Manager\TeamManager;
use App\Repository\TeamsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;

class TeamManagerTest extends \Codeception\Test\Unit
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
    protected $teamRepositoryMock;

    /**
     * @var TeamManager
     */
    protected $teamManager;
    
    protected function _before()
    {
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->teamRepositoryMock = $this->createMock(TeamsRepository::class);

        $this->teamManager = new TeamManager($this->entityManagerMock, $this->teamRepositoryMock, $this->loggerMock);
    }

    protected function _after()
    {
    }

    // tests
    public function testCreateTeam()
    {
        $team = $this->teamManager->createTeam();

        $this->tester->assertTrue($team->getStatus());
    }

    public function testGetTeamByName()
    {
        $team = new Teams();

        $this->teamRepositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => 'Team1'])
            ->willReturn($team)
        ;

        $teamFound = $this->teamManager->getTeamByName('Team1');
        $this->tester->assertSame($team, $teamFound);
    }

    public function testGetTeamByNameNotUnique()
    {
        $this->teamRepositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => 'Team1'])
            ->willThrowException(new NonUniqueResultException())
        ;

        $this->loggerMock
            ->expects($this->once())
            ->method('error')
            ->with('Multiple teams returned with the same name : Team1')
        ;

        $teamFound = $this->teamManager->getTeamByName('Team1');

        $this->assertNull($teamFound);
    }

    public function testGetTeamByNameNotFound()
    {
        $this->teamRepositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => 'Team1'])
            ->willThrowException(new NoResultException())
        ;

        $teamFound = $this->teamManager->getTeamByName('Team1');

        $this->assertNull($teamFound);
    }
}
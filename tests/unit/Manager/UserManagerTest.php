<?php

namespace App\Tests;

use App\Entity\Users;
use App\Manager\UserManager;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class UserManagerTest extends \Codeception\Test\Unit
{
    /**
     * @var \App\Tests\UnitTester
     */
    protected $tester;

    const ENCODED_PASSWORD = 'encodedPassword';

    /**
     * @var MockObject
     */
    protected $userRepositoryMock;

    /**
     * @var MockObject
     */
    protected $entityManagerMock;

    /**
     * @var MockObject
     */
    protected $loggerMock;

    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * @var MockObject
     */
    protected $tokenGenerator;

    protected function _before()
    {
        parent::_before();

        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->userRepositoryMock = $this->createMock(UsersRepository::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->tokenGenerator = $this->createMock(TokenGeneratorInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $passwordEncoder
            ->method('encodePassword')
            ->willReturn(self::ENCODED_PASSWORD);

        $this->userManager = new UserManager($this->entityManagerMock, $this->userRepositoryMock, $passwordEncoder, $this->loggerMock);
    }

    protected function _after()
    {
    }

    /**
     * Test if the method createUser User Manager worked correctly
     */
    public function testCreateUser()
    {
        $user = $this->userManager->createUser();

        $this->assertTrue($user->getAvailability());
        $this->assertTrue($user->getIsEnabled());
    }

    /**
     * Test get by user email
     */
    public function testGetByEmail()
    {
        $user = new Users();

        $this->userRepositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['email' => 'luffy@example.com'])
            ->willReturn($user)
        ;

        $userFound = $this->userManager->getUserByEmail('luffy@example.com');

        $this->assertSame($user, $userFound);
    }

    /**
     * Test get by email
     */
    public function testGetByEmailNotUnique()
    {
        $this->userRepositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['email' => 'luffy@example.com'])
            ->willThrowException(new NonUniqueResultException())
        ;

        $this->loggerMock
            ->expects($this->once())
            ->method('error')
            ->with('Multiple user returned with the same email: luffy@example.com')
        ;

        $userFound = $this->userManager->getUserByEmail('luffy@example.com');

        $this->assertNull($userFound);
    }

    public function testGetByEmailNoResult()
    {
        $this->userRepositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['email' => 'luffy@example.com'])
            ->willThrowException(new NoResultException())
        ;

        $userFound = $this->userManager->getUserByEmail('luffy@example.com');

        $this->assertNull($userFound);
    }

    public function testGetByToken()
    {
        $user = new Users();
        $token = md5(random_bytes(60));

        $this->userRepositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['token' => $token])
            ->willReturn($user)
        ;

        $userFound = $this->userManager->getUserByToken($token);

        $this->assertSame($user, $userFound);
    }

    public function testGetByTokenNoResult()
    {
        $token1 = md5(random_bytes(60));

        $this->userRepositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['token' => $token1])
            ->willThrowException(new NoResultException())
        ;

        $userFound = $this->userManager->getUserByToken($token1);

        $this->assertNull($userFound);
    }

    public function testGetBySummonerName()
    {
        $user = new Users();

        $this->userRepositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['summonerName' => 'Alex'])
            ->willReturn($user)
        ;

        $userFound = $this->userManager->getUserBySummonerName('Alex');

        $this->assertSame($user, $userFound);
    }

    public function testGetBySummonerNameNotUnique()
    {
        $this->userRepositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['summonerName' => 'Alex'])
            ->willThrowException(new NonUniqueResultException())
        ;

        $this->loggerMock
            ->expects($this->once())
            ->method('error')
            ->with('Multiple user returned with the same Summoner Name: Alex')
        ;

        $userFound = $this->userManager->getUserBySummonerName('Alex');

        $this->assertNull($userFound);
    }

    public function testGetBySummonerNameNoResult()
    {
        $this->userRepositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['summonerName' => 'Alex'])
            ->willThrowException(new NoResultException())
        ;

        $userFound = $this->userManager->getUserBySummonerName('Alex');

        $this->assertNull($userFound);
    }
}
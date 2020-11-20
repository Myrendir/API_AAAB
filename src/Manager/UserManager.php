<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 9/25/20
 * Time: 3:22 PM
 */

namespace App\Manager;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserManager
 * @package App\Manager
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class UserManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var UsersRepository
     */
    protected $userRepository;

    /**
     * @var UserPasswordEncoderInterface
     */
    protected $passwordEncoder;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var \JMS\Serializer\Serializer
     */
    protected $serializer;

    /**
     * UserManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param UsersRepository $usersRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param LoggerInterface $logger
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        UsersRepository $usersRepository,
        UserPasswordEncoderInterface $passwordEncoder,
        LoggerInterface $logger
    )
    {
        $this->em = $entityManager;
        $this->userRepository = $usersRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->logger = $logger;
        $this->serializer = SerializerBuilder::create()->build();
    }

    /**
     * @return Users
     */
    public function createUser()
    {
        $user = new Users();
        $user->setAvailability(true);
        $user->setIsEnabled(true);

        return $user;
    }

    /**
     * @return string
     */
    public function getAllUsers()
    {
        $users = $this->userRepository->findAll();
        $jsonContent = $this->serializer->serialize($users, 'json', SerializationContext::create()->setGroups(['User']));
        return $jsonContent;
    }

    /**
     * @param $summonerName
     * @return Users
     */
    public function getUserBySummonerName($summonerName)
    {
        try {
            /** @var Users $user */
            $user = $this->userRepository->findOneBy(['summonerName' => $summonerName]);
            return $user;
        } catch (NonUniqueResultException $exception) {
            $this->logger->error(sprintf('Multiple user returned with the same Summoner Name: %s', $summonerName));
        } catch (NoResultException $exception) {
        }
    }

    /**
     * @param string $email
     * @return Users
     */
    public function getUserByEmail(string $email)
    {
        try {
            /** @var Users $user */
            $user = $this->userRepository->findOneBy(['email' => $email]);
            return $user;
        } catch (NonUniqueResultException $exception) {
            $this->logger->error(sprintf('Multiple user returned with the same email: %s', $email));
        } catch (NoResultException $exception) {
        }
    }

    /**
     * @param string $token
     * @return Users
     */
    public function getUserByToken(string $token)
    {
        try {
            /** @var Users $user */
            $user = $this->userRepository->findOneBy(['token' => $token]);
            return $user;
        } catch (NoResultException $exception) {
            $this->logger->error(sprintf('Multiple user returned with the same email: %s', $token));
        }
    }

    /**
     * @param Users $users
     * @throws \Exception
     */
    public function updatePassword(Users $users)
    {
        if (0 !== strlen($password = $users->getPlainPassword())) {
            $users->setSalt(rtrim(str_replace('+', '.', base64_encode(random_bytes(32))), '='));
            $users->setPassword($this->passwordEncoder->encodePassword($users, $users->getPlainPassword()));
            $users->eraseCredentials();
        }
    }

    /**
     * @param $users
     * @param bool $andFlush
     * @throws \Exception
     */
    public function save($users, $andFlush = true)
    {
        $this->updatePassword($users);

        $this->em->persist($users);
        if ($andFlush) {
            $this->em->flush();
        }
    }
}
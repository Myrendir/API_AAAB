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
    protected $em;
    protected $userRepository;
    protected $passwordEncoder;
    protected $logger;
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

    public function createUser()
    {
        $user = new Users();
        $user->setAvailability(true);
        $user->setIsEnabled(true);

        return $user;
    }

    public function getAllUsers()
    {
        $users = $this->userRepository->findAll();
        $jsonContent = $this->serializer->serialize($users, 'json', SerializationContext::create()->setGroups(['User']));
        return $jsonContent;
    }

    public function getUserBySummonerName(string $summonerName)
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

    public function updatePassword(Users $users)
    {
        if (0 !== strlen($password = $users->getPlainPassword())) {
            $users->setSalt(rtrim(str_replace('+', '.', base64_encode(random_bytes(32))), '='));
            $users->setPassword($this->passwordEncoder->encodePassword($users, $users->getPlainPassword()));
            $users->eraseCredentials();
        }
    }

    public function save($users, $andFlush = true)
    {
        $this->updatePassword($users);

        $this->em->persist($users);
        if ($andFlush) {
            $this->em->flush();
        }
    }
}
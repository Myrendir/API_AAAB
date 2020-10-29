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
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use phpDocumentor\Reflection\Types\Object_;
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
        $user = $this->userRepository->findOneBySummonerName(['summonerName' => $summonerName]);
        $jsonContent = $this->serializer->serialize($user, 'json', SerializationContext::create()->setGroups(['User']));
        return $jsonContent;
    }

    public function getByEmail(string $email)
    {
        $user = $this->userRepository->findOneByEmail(['email' => $email]);
        return $user;
    }

    public function getByToken(string $token)
    {
        $user = $this->userRepository->findOneByToken(['token' => $token]);
        return $user;
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
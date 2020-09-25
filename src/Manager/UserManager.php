<?php
/**
 * Created by PhpStorm
 * User: shadowluffy
 * Date: 9/25/20
 * Time: 3:22 PM
 */

namespace App\Manager;

use App\Entity\Users;
use App\Repository\UsersRepository;
use App\Services\ValidatorService;
use Doctrine\ORM\EntityManagerInterface;
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
    protected $validatorService;

    /**
     * UserManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param UsersRepository $usersRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param LoggerInterface $logger
     * @param ValidatorService $validatorService
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        UsersRepository $usersRepository,
        UserPasswordEncoderInterface $passwordEncoder,
        LoggerInterface $logger,
        ValidatorService $validatorService
    )
    {
        $this->em = $entityManager;
        $this->userRepository = $usersRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->logger = $logger;
        $this->validatorService = $validatorService;
    }

    public function createUser()
    {
        $user = new Users();
        $user->setAvailability(true);
        $user->setIsEnabled(true);

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

    public function save(Users $users, $andFlush = true)
    {
        $this->validatorService->validate($users);
        $this->updatePassword($users);

        $this->em->persist($users);
        if ($andFlush) {
            $this->em->flush();
        }
    }
}
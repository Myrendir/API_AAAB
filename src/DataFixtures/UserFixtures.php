<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 10/30/20
 * Time: 9:15 AM
 */

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixtures
 * @package App\DataFixtures
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new Users();
        $password = $this->passwordEncoder->encodePassword($user, 'michelle1');
        $faker = Factory::create();
        $user
            ->setSummonerName('Luffy')
            ->setEmail('luffy@example.com')
            ->setPassword($password)
            ->setAvailability(true)
            ->setIsEnabled(true)
            ->setSalt($faker->sentence)
        ;
        $manager->persist($user);

        $admin = new Users();
        $admin
            ->setSummonerName('admin')
            ->setEmail('admin@example.com')
            ->setPassword($password)
            ->setRoles(['ROLE_ADMIN'])
            ->setAvailability(true)
            ->setIsEnabled(true)
            ->setSalt($faker->sentence)
        ;
        $manager->persist($admin);

        for ($i = 0; $i < 20; $i++) {
            $fakeUser = new Users();
            $fakeUser
                ->setSummonerName($faker->text(16))
                ->setEmail($faker->email)
                ->setPassword($this->passwordEncoder->encodePassword($fakeUser, $faker->password))
                ->setAvailability(true)
                ->setIsEnabled(true)
                ->setSalt($faker->sentence)
            ;
            $manager->persist($fakeUser);
        }
        $manager->flush();

    }
}
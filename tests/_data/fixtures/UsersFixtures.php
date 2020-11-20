<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 10/27/20
 * Time: 4:53 PM
 */

namespace App\Tests\_data\fixtures;

use App\Entity\Users;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Class UsersFixtures
 * @package App\Tests\_data\fixtures
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class UsersFixtures extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $user1 = new Users();
        $user1
            ->setSummonerName('Michel')
            ->setEmail('michel@example.com')
            ->setPassword('michelle1')
            ->setAvailability(true)
            ->setIsEnabled(true)
            ->setSalt($faker->sentence)
        ;
        $manager->persist($user1);
        $user2 = new Users();
        $user2
            ->setSummonerName('Alex')
            ->setEmail('alex@example.com')
            ->setPassword('michelle1')
            ->setAvailability(true)
            ->setIsEnabled(true)
            ->setSalt($faker->sentence)
        ;
        $manager->persist($user2);
        for ($i = 0; $i < 10; $i++) {
            $users = new Users();
            $users
                ->setSummonerName($faker->name)
                ->setEmail($faker->email)
                ->setPassword($faker->password)
                ->setAvailability(true)
                ->setIsEnabled(true)
                ->setSalt($faker->sentence)
            ;
            $manager->persist($users);
        }
        $manager->flush();
    }
}
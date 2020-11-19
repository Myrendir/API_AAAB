<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 11/19/20
 * Time: 11:57 AM
 */

namespace App\Tests\_data\fixtures;

use App\Entity\Teams;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Class TeamFixtures
 * @package App\Tests\_data\fixtures
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class TeamFixtures extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $team1 = new Teams();
        $team1
            ->setName('Team1')
            ->setStatus(true)
        ;
        $manager->persist($team1);

        for ($i = 0; $i < 10; $i++) {
            $team = new Teams();
            $team
                ->setName($faker->name)
                ->setStatus(true)
            ;
            $manager->persist($team);
        }
        $manager->flush();
    }
}
<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 11/19/20
 * Time: 12:02 PM
 */

namespace App\Tests\_data\fixtures;

use App\Entity\Teams;
use App\Entity\Tournament;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Class TournamentFixtures
 * @package App\Tests\_data\fixtures
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class TournamentFixtures extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($j = 0; $j < 10; $j++) {
            $team = new Teams();
            $team
                ->setName($faker->name)
                ->setStatus(true)
            ;
            $manager->persist($team);
            for ($i = 0; $i < 10; $i++) {
                $tournament = new Tournament();
                $tournament
                    ->setName($faker->name)
                    ->setFormat(['5vs5'])
                    ->setMap(['Summoner\'s Rift'])
                    ->setSlots($faker->numberBetween(0, 150))
                    ->addTeam($team)
                ;
                $manager->persist($tournament);
            }
        }

        $manager->flush();
    }
}
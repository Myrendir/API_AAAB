<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 11/18/20
 * Time: 9:38 AM
 */

namespace App\Manager;

use App\Entity\Teams;
use App\Repository\TeamsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use JMS\Serializer\SerializerBuilder;
use Psr\Log\LoggerInterface;

/**
 * Class TeamManager
 * @package App\Manager
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class TeamManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var TeamsRepository
     */
    private $teamRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var SerializerBuilder
     */
    private $serializer;

    public function __construct(
        EntityManagerInterface $entityManager,
        TeamsRepository $teamsRepository,
        LoggerInterface $logger
    )
    {
        $this->em = $entityManager;
        $this->teamRepository = $teamsRepository;
        $this->logger = $logger;
        $this->serializer = SerializerBuilder::create()->build();
    }

    public function createTeam()
    {
        $team = new Teams();
        $team->setStatus(true);

        return $team;
    }

    public function getAllTeams()
    {
        $teams = $this->teamRepository->findAll();
        $jsonContent = $this->serializer->serialize($teams, 'json');
        return $jsonContent;
    }

    public function getTeamByName($name)
    {
        try {
            /** @var Teams $team */
            $team = $this->teamRepository->findOneBy(['name' => $name]);
            return $team;
        } catch (NonUniqueResultException $exception) {
            $this->logger->error(sprintf('Multiple teams returned with the same name : %s', $name));
        } catch (NoResultException $exception) {
        }
    }

    public function save($team, $andFlush = true)
    {
        $this->em->persist($team);
        if ($andFlush) {
            $this->em->flush();
        }
    }
}
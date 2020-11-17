<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 11/17/20
 * Time: 8:59 AM
 */

namespace App\Manager;

use App\Entity\Tournament;
use App\Repository\TournamentRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerBuilder;
use Psr\Log\LoggerInterface;

/**
 * Class TournamentManager
 * @package App\Manager
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class TournamentManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var TournamentRepository
     */
    protected $tournamentRepository;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var \JMS\Serializer\Serializer
     */
    protected $serializer;

    /**
     * TournamentManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param LoggerInterface $logger
     * @param TournamentRepository $tournamentRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager ,
        LoggerInterface $logger,
        TournamentRepository $tournamentRepository
    )
    {
        $this->em = $entityManager;
        $this->logger = $logger;
        $this->tournamentRepository = $tournamentRepository;
        $this->serializer = SerializerBuilder::create()->build();
    }

    /**
     * @return Tournament
     */
    public function createTournament()
    {
        $tournament = new Tournament();

        return $tournament;
    }

    /**
     * @param $tournament
     * @param bool $andFlush
     */
    public function save($tournament, $andFlush = true)
    {
        $this->em->persist($tournament);
        if ($andFlush) {
            $this->em->flush();
        }
    }
}
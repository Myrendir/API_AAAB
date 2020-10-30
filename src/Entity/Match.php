<?php

namespace App\Entity;

use App\Repository\MatchRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MatchRepository::class)
 * @ORM\Table(name="`match`")
 */
class Match
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $teamOne;

    /**
     * @ORM\Column(type="integer")
     */
    private $teamTwo;

    /**
     * @ORM\Column(type="json")
     */
    private $data;

    /**
     * @ORM\Column(type="integer")
     */
    private $idMatch;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tournament", inversedBy="match")
     * @ORM\JoinColumn(name="tournament_id", referencedColumnName="id")
     */
    private $tournament;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTeamOne()
    {
        return $this->teamOne;
    }

    /**
     * @param mixed $teamOne
     */
    public function setTeamOne($teamOne): void
    {
        $this->teamOne = $teamOne;
    }

    /**
     * @return mixed
     */
    public function getTeamTwo()
    {
        return $this->teamTwo;
    }

    /**
     * @param mixed $teamTwo
     */
    public function setTeamTwo($teamTwo): void
    {
        $this->teamTwo = $teamTwo;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getIdMatch()
    {
        return $this->idMatch;
    }

    /**
     * @param mixed $idMatch
     */
    public function setIdMatch($idMatch): void
    {
        $this->idMatch = $idMatch;
    }

    /**
     * @return mixed
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    /**
     * @param mixed $tournament
     */
    public function setTournament($tournament): void
    {
        $this->tournament = $tournament;
    }

}

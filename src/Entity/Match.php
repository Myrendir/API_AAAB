<?php

namespace App\Entity;

use App\Repository\MatchRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=MatchRepository::class)
 * @ORM\Table(name="`match`")
 */
class Match
{
    use BlameableEntity;
    use TimestampableEntity;

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
     */
    private $tournament = [];

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
     * @return array
     */
    public function getTournament(): array
    {
        return $this->tournament;
    }

    /**
     * @param array $tournament
     */
    public function setTournament(array $tournament): void
    {
        $this->tournament = $tournament;
    }
}

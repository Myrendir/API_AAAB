<?php

namespace App\Entity;

use App\Repository\MatchsRepository;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Annotations\Property;

/**
 * @ORM\Entity(repositoryClass=MatchsRepository::class)
 */
class Matchs
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
     * @Property(type="json")
     */
    private $data = [];

    /**
     * @ORM\Column(type="integer")
     */
    private $idMatch;

    /**
     * @ORM\ManyToOne(targetEntity=Tournament::class, inversedBy="matchs")
     */
    private $tournament;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamOne(): ?int
    {
        return $this->teamOne;
    }

    public function setTeamOne(int $teamOne): self
    {
        $this->teamOne = $teamOne;

        return $this;
    }

    public function getTeamTwo(): ?int
    {
        return $this->teamTwo;
    }

    public function setTeamTwo(int $teamTwo): self
    {
        $this->teamTwo = $teamTwo;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getIdMatch(): ?int
    {
        return $this->idMatch;
    }

    public function setIdMatch(int $idMatch): self
    {
        $this->idMatch = $idMatch;

        return $this;
    }

    public function getTournament(): ?Tournament
    {
        return $this->tournament;
    }

    public function setTournament(?Tournament $tournament): self
    {
        $this->tournament = $tournament;

        return $this;
    }
}

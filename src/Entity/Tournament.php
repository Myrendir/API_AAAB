<?php

namespace App\Entity;

use App\Repository\TournamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use OpenApi\Annotations\Items;
use OpenApi\Annotations\Property;

/**
 * @ORM\Entity(repositoryClass=TournamentRepository::class)
 */
class Tournament
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
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $slots;

    /**
     * @ORM\Column(type="array")
     * @Property(type="array", @Items(type="string"))
     */
    private $format = [];

    /**
     * @ORM\Column(type="array")
     * @Property(type="array", @Items(type="string"))
     */
    private $map = [];

    /**
     * @ORM\ManyToMany(targetEntity=Teams::class, inversedBy="tournaments")
     */
    private $teams;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Match", mappedBy="tournament")
     */
    private $match;

    /**
     * Tournament constructor.
     */
    public function __construct()
    {
        $this->match = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSlots(): ?int
    {
        return $this->slots;
    }

    /**
     * @param int $slots
     * @return $this
     */
    public function setSlots(int $slots): self
    {
        $this->slots = $slots;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getFormat(): ?array
    {
        return $this->format;
    }

    /**
     * @param array $format
     * @return $this
     */
    public function setFormat(array $format): self
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getMap(): ?array
    {
        return $this->map;
    }

    /**
     * @param array $map
     * @return $this
     */
    public function setMap(array $map): self
    {
        $this->map = $map;

        return $this;
    }

    /**
     * @return Teams
     */
    public function getTeams(): ?Teams
    {
        return $this->teams;
    }

    /**
     * @param Teams|null $teams
     *
     * @return $this
     */
    public function setTeems(?Teams $teams): self
    {
        $this->teams = $teams;

        return $this;
    }
    /**
     * @return Collection|Match[]
     */
    public function getMatch(): Collection
    {
        return $this->match;
    }

    /**
     * @param Match $match
     * @return $this
     */
    public function addMatch(Match $match): self
    {
        if (!$this->match->contains($match)) {
            $this->match[] = $match;
        }

        return $this;
    }

    /**
     * @param Match $match
     * @return $this
     */
    public function removeMatch(Match $match): self
    {
        $this->match->removeElement($match);

        return $this;
    }


}

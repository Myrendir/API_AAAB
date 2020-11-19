<?php

namespace App\Entity;

use App\Repository\TeamsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use OpenApi\Annotations\Property;

/**
 * @ORM\Entity(repositoryClass=TeamsRepository::class)
 */
class Teams
{
    use BlameableEntity,
        TimestampableEntity;

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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $score;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToMany(targetEntity=Tournament::class, mappedBy="teams")
     * @Property(type="anyOf", schema="Tournament")
     */
    private $tournaments;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="top")
     */
    private $top;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="mid")
     */
    private $mid;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="adc")
     */
    private $adc;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="jungle")
     */
    private $jungle;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="support")
     */
    private $support;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="teams")
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Tournament[]
     */
    public function getTournaments(): Collection
    {
        return $this->tournaments;
    }

    public function addTournament(Tournament $tournament): self
    {
        if (!$this->tournaments->contains($tournament)) {
            $this->tournaments[] = $tournament;
            $tournament->addTeam($this);
        }

        return $this;
    }

    public function removeTournament(Tournament $tournament): self
    {
        if ($this->tournaments->removeElement($tournament)) {
            $tournament->removeTeam($this);
        }

        return $this;
    }

    public function getTop(): ?Users
    {
        return $this->top;
    }

    public function setTop(?Users $top): self
    {
        $this->top = $top;

        return $this;
    }

    public function getMid(): ?Users
    {
        return $this->mid;
    }

    public function setMid(?Users $mid): self
    {
        $this->mid = $mid;

        return $this;
    }

    public function getAdc(): ?Users
    {
        return $this->adc;
    }

    public function setAdc(?Users $adc): self
    {
        $this->adc = $adc;

        return $this;
    }

    public function getJungle(): ?Users
    {
        return $this->jungle;
    }

    public function setJungle(?Users $jungle): self
    {
        $this->jungle = $jungle;

        return $this;
    }

    public function getSupport(): ?Users
    {
        return $this->support;
    }

    public function setSupport(?Users $support): self
    {
        $this->support = $support;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }
}

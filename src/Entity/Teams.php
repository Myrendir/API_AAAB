<?php

namespace App\Entity;

use App\Repository\TeamsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamsRepository::class)
 */
class Teams
{
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
     * @ORM\OneToMany(targetEntity=Users::class, mappedBy="top")
     */
    private $top;

    /**
     * @ORM\OneToMany(targetEntity=Users::class, mappedBy="jungle")
     */
    private $jungle;

    /**
     * @ORM\OneToMany(targetEntity=Users::class, mappedBy="mid")
     */
    private $mid;

    /**
     * @ORM\OneToMany(targetEntity=Users::class, mappedBy="adc")
     */
    private $adc;

    /**
     * @ORM\OneToMany(targetEntity=Users::class, mappedBy="support")
     */
    private $support;

    /**
     * @ORM\ManyToMany(targetEntity=Tournament::class, mappedBy="teams")
     */
    private $tournaments;

    public function __construct()
    {
        $this->top = new ArrayCollection();
        $this->jungle = new ArrayCollection();
        $this->mid = new ArrayCollection();
        $this->adc = new ArrayCollection();
        $this->support = new ArrayCollection();
        $this->tournaments = new ArrayCollection();
    }

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
     * @return Collection|Users[]
     */
    public function getTop(): Collection
    {
        return $this->top;
    }

    public function addTop(Users $top): self
    {
        if (!$this->top->contains($top)) {
            $this->top[] = $top;
            $top->setTop($this);
        }

        return $this;
    }

    public function removeTop(Users $top): self
    {
        if ($this->top->removeElement($top)) {
            // set the owning side to null (unless already changed)
            if ($top->getTop() === $this) {
                $top->setTop(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getJungle(): Collection
    {
        return $this->jungle;
    }

    public function addJungle(Users $jungle): self
    {
        if (!$this->jungle->contains($jungle)) {
            $this->jungle[] = $jungle;
            $jungle->setJungle($this);
        }

        return $this;
    }

    public function removeJungle(Users $jungle): self
    {
        if ($this->jungle->removeElement($jungle)) {
            // set the owning side to null (unless already changed)
            if ($jungle->getJungle() === $this) {
                $jungle->setJungle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getMid(): Collection
    {
        return $this->mid;
    }

    public function addMid(Users $mid): self
    {
        if (!$this->mid->contains($mid)) {
            $this->mid[] = $mid;
            $mid->setMid($this);
        }

        return $this;
    }

    public function removeMid(Users $mid): self
    {
        if ($this->mid->removeElement($mid)) {
            // set the owning side to null (unless already changed)
            if ($mid->getMid() === $this) {
                $mid->setMid(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getAdc(): Collection
    {
        return $this->adc;
    }

    public function addAdc(Users $adc): self
    {
        if (!$this->adc->contains($adc)) {
            $this->adc[] = $adc;
            $adc->setAdc($this);
        }

        return $this;
    }

    public function removeAdc(Users $adc): self
    {
        if ($this->adc->removeElement($adc)) {
            // set the owning side to null (unless already changed)
            if ($adc->getAdc() === $this) {
                $adc->setAdc(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getSupport(): Collection
    {
        return $this->support;
    }

    public function addSupport(Users $support): self
    {
        if (!$this->support->contains($support)) {
            $this->support[] = $support;
            $support->setSupport($this);
        }

        return $this;
    }

    public function removeSupport(Users $support): self
    {
        if ($this->support->removeElement($support)) {
            // set the owning side to null (unless already changed)
            if ($support->getSupport() === $this) {
                $support->setSupport(null);
            }
        }

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
}

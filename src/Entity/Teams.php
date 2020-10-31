<?php

namespace App\Entity;

use App\Repository\TeamsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TeamsRepository::class)
 * @UniqueEntity(
 *     fields={"name"},
 *     message="The name is already to use"
 * )
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class Teams
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
     * @Assert\NotBlank(message="The field name is missing")
     * @Assert\Length(
     *     min="3",
     *     minMessage="The field Name must do minimum 3 characters",
     *     max="25",
     *     maxMessage="The field Name must not do maximum 25 characters"
     * )
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $score;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Users", mappedBy="top")
     * @Assert\NotBlank(message="The field Top is missing.")
     */
    private $top;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Users", mappedBy="jungle")
     * @Assert\NotBlank(message="The field Jungle is missing.")
     */
    private $jungle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Users", mappedBy="mid")
     * @Assert\NotBlank(message="The field Mid is missing.")
     */
    private $mid;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Users", mappedBy="adc")
     * @Assert\NotBlank(message="The field Adc is missing.")
     */
    private $adc;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Users", mappedBy="support")
     * @Assert\NotBlank(message="The field Support is missing.")
     */
    private $support;

    /**
     * @ORM\ManyToMany(targetEntity=Tournament::class, mappedBy="teams")
     */
    private $tournaments;

    /**
     * Teams constructor.
     */
    public function __construct()
    {
        $this->top = new ArrayCollection();
        $this->jungle = new ArrayCollection();
        $this->mid = new ArrayCollection();
        $this->adc = new ArrayCollection();
        $this->support = new ArrayCollection();
        $this->tournaments = new ArrayCollection();
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
     * @param string|null $name
     * @return $this
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }


    /**
     * @return int|null
     */
    public function getScore(): ?int
    {
        return $this->score;
    }

    /**
     * @param int|null $score
     * @return $this
     */
    public function setScore(?int $score): self
    {
        $this->score = $score;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getStatus(): ?bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }

    /**
     * @param string $createdBy
     */
    public function setCreatedBy(string $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return ArrayCollection
     */
    public function getTop(): ArrayCollection
    {
        return $this->top;
    }

    /**
     * @param ArrayCollection $top
     */
    public function setTop(ArrayCollection $top): void
    {
        $this->top = $top;
    }

    /**
     * @return ArrayCollection
     */
    public function getJungle(): ArrayCollection
    {
        return $this->jungle;
    }

    /**
     * @param ArrayCollection $jungle
     */
    public function setJungle(ArrayCollection $jungle): void
    {
        $this->jungle = $jungle;
    }

    /**
     * @return ArrayCollection
     */
    public function getMid(): ArrayCollection
    {
        return $this->mid;
    }

    /**
     * @param ArrayCollection $mid
     */
    public function setMid(ArrayCollection $mid): void
    {
        $this->mid = $mid;
    }

    /**
     * @return ArrayCollection
     */
    public function getAdc(): ArrayCollection
    {
        return $this->adc;
    }

    /**
     * @param ArrayCollection $adc
     */
    public function setAdc(ArrayCollection $adc): void
    {
        $this->adc = $adc;
    }

    /**
     * @return ArrayCollection
     */
    public function getSupport(): ArrayCollection
    {
        return $this->support;
    }

    /**
     * @param ArrayCollection $support
     */
    public function setSupport(ArrayCollection $support): void
    {
        $this->support = $support;
    }

    /**
     * @return Collection|Tournament[]
     */
    public function getTournaments(): Collection
    {
        return $this->tournaments;
    }

    /**
     * @param Tournament $tournament
     * @return $this
     */
    public function addTournament(Tournament $tournament): self
    {
        if (!$this->tournaments->contains($tournament)) {
            $this->tournaments[] = $tournament;
            $tournament->addTeam($this);
        }

        return $this;
    }

    /**
     * @param Tournament $tournament
     * @return $this
     */
    public function removeTournament(Tournament $tournament): self
    {
        if ($this->tournaments->removeElement($tournament)) {
            $tournament->removeTeam($this);
        }

        return $this;
    }


}

<?php

namespace App\Entity;

use App\Repository\TeamsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TeamsRepository::class)
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
     * @ORM\Column(type="array")
     */
    private $type = [];

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
     * Teams constructor.
     */
    public function __construct()
    {
        $this->top = new ArrayCollection();
        $this->jungle = new ArrayCollection();
        $this->mid = new ArrayCollection();
        $this->adc = new ArrayCollection();
        $this->support = new ArrayCollection();
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
     * @return array|null
     */
    public function getType(): ?array
    {
        return $this->type;
    }

    /**
     * @param array $type
     * @return $this
     */
    public function setType(array $type): self
    {
        $this->type = $type;

        return $this;
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
     * @return string|null
     */
    public function getTop(): ?string
    {
        return $this->top;
    }

    /**
     * @param string $top
     * @return $this
     */
    public function setTop(string $top): self
    {
        $this->top = $top;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getJungle(): ?string
    {
        return $this->jungle;
    }

    /**
     * @param string $jungle
     * @return $this
     */
    public function setJungle(string $jungle): self
    {
        $this->jungle = $jungle;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMid(): ?string
    {
        return $this->mid;
    }

    /**
     * @param string $mid
     * @return $this
     */
    public function setMid(string $mid): self
    {
        $this->mid = $mid;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAdc(): ?string
    {
        return $this->adc;
    }

    /**
     * @param string $adc
     * @return $this
     */
    public function setAdc(string $adc): self
    {
        $this->adc = $adc;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSupport(): ?string
    {
        return $this->support;
    }

    /**
     * @param string $support
     * @return $this
     */
    public function setSupport(string $support): self
    {
        $this->support = $support;

        return $this;
    }
}

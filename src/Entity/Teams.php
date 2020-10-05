<?php

namespace App\Entity;

use App\Repository\TeamsRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

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
     * @ORM\Column(type="string", length=255)
     */
    private $top;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $jungle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $support;

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

    public function getType(): ?array
    {
        return $this->type;
    }

    public function setType(array $type): self
    {
        $this->type = $type;

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

    public function getTop(): ?string
    {
        return $this->top;
    }

    public function setTop(string $top): self
    {
        $this->top = $top;

        return $this;
    }

    public function getJungle(): ?string
    {
        return $this->jungle;
    }

    public function setJungle(string $jungle): self
    {
        $this->jungle = $jungle;

        return $this;
    }

    public function getMid(): ?string
    {
        return $this->mid;
    }

    public function setMid(string $mid): self
    {
        $this->mid = $mid;

        return $this;
    }

    public function getAdc(): ?string
    {
        return $this->adc;
    }

    public function setAdc(string $adc): self
    {
        $this->adc = $adc;

        return $this;
    }

    public function getSupport(): ?string
    {
        return $this->support;
    }

    public function setSupport(string $support): self
    {
        $this->support = $support;

        return $this;
    }
}

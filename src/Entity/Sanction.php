<?php

namespace App\Entity;

use App\Repository\SanctionRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=SanctionRepository::class)
 */
class Sanction
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
     * @ORM\Column(name="start_sanction", type="datetime")
     */
    private $startSanction;

    /**
     * @ORM\Column(name="end_sanction", type="datetime")
     */
    private $endSanction;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $motif;

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
    public function getStartSanction()
    {
        return $this->startSanction;
    }

    /**
     * @param mixed $startSanction
     */
    public function setStartSanction($startSanction): void
    {
        $this->startSanction = $startSanction;
    }

    /**
     * @return mixed
     */
    public function getEndSanction()
    {
        return $this->endSanction;
    }

    /**
     * @param mixed $endSanction
     */
    public function setEndSanction($endSanction): void
    {
        $this->endSanction = $endSanction;
    }

    /**
     * @return string|null
     */
    public function getMotif(): ?string
    {
        return $this->motif;
    }

    /**
     * @param string $motif
     * @return $this
     */
    public function setMotif(string $motif): self
    {
        $this->motif = $motif;

        return $this;
    }
}

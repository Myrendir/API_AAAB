<?php

namespace App\Entity;

use App\Repository\SanctionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SanctionRepository::class)
 */
class Sanction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startSanction;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endSanction;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $motif;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartSanction(): ?\DateTimeInterface
    {
        return $this->startSanction;
    }

    public function setStartSanction(\DateTimeInterface $startSanction): self
    {
        $this->startSanction = $startSanction;

        return $this;
    }

    public function getEndSanction(): ?\DateTimeInterface
    {
        return $this->endSanction;
    }

    public function setEndSanction(\DateTimeInterface $endSanction): self
    {
        $this->endSanction = $endSanction;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): self
    {
        $this->motif = $motif;

        return $this;
    }
}

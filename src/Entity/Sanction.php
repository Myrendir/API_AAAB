<?php

namespace App\Entity;

use App\Repository\SanctionRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SanctionRepository::class)
 */
class Sanction
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
     * @ORM\Column(type="datetime")
     * @Assert\DateTime(format="Y-m-d H:i:s")
     */
    private $startSanction;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime(format="Y-m-d H:i:s")
     */
    private $endSanction;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="20", minMessage="The motif must be minimum 20 characters")
     */
    private $motif;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="sanctions")
     */
    private $user;

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

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }
}

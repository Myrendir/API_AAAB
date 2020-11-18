<?php

namespace App\Entity;

use App\Repository\ReportRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReportRepository::class)
 */
class Report
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
    private $date;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="The field Comment is missing")
     * @Assert\Length(
     *     min="20",
     *     minMessage="The field Comment must do minimum 20 characters"
     * )
     */
    private $comment;

    /**
     * @ORM\Column(type="array")
     */
    private $motif = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getMotif(): ?array
    {
        return $this->motif;
    }

    public function setMotif(array $motif): self
    {
        $this->motif = $motif;

        return $this;
    }
}

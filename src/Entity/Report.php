<?php

namespace App\Entity;

use App\Repository\ReportRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use OpenApi\Annotations\Items;
use OpenApi\Annotations\Property;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReportRepository::class)
 */
class Report
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
     * @Assert\Choice(
     *     choices={
     *     "Insulting, harassing, or offensive language directed at other players",
     *     "Any kind of hate speech such as homophobia, sexism, racism, and ableism",
     *     "Intentionally ruining the game for other players with in game actions such as griefing, feeding, or purposely playing in a way to make it harder for the rest of the team",
     *     "Leaving or going AFK at any point during the match being played",
     *     "Inappropriate Summoner Names",
     *     "Unnecessarily disruptive language or behavior that derails the match for other players"}
     *     message="Please choose one of the choices offered"
     * )
     * @Property(type="array", @Items(type="string"))
     */
    private $motif = [];

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="reports")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isEnabled;

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

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getIsEnabled(): ?bool
    {
        return $this->isEnabled;
    }

    public function setIsEnabled(bool $isEnabled): self
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }
}

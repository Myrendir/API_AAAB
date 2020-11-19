<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as Serializer;
use OpenApi\Annotations\Items;
use OpenApi\Annotations\Property;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"summonerName"},
 *     message="This summonerName is already used !",
 *     groups={"Register", "Profile"}
 * )
 * @UniqueEntity(
 *     fields={"email"},
 *     message="This email is already used",
 *     groups={"Register", "Profile"}
 * )
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class Users implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=16)
     * @Assert\NotBlank(
     *     message="The field Summoner Name is missing.",
     *     groups={"Register", "Profile", "Default"}
     * )
     * @Assert\Length(
     *     min="3",
     *     minMessage="The field Summoner Name must do minimum 3 characters",
     *     max="16",
     *     maxMessage="The field Summoner Name not must do superior at 16 characters",
     *     groups={"Register", "Profile", "Default"}
     * )
     * @Property(type="string", uniqueItems=true)
     * @Serializer\Groups(groups={"User"})
     */
    private $summonerName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message="The field Email is missing.",
     *     groups={"Profile", "Register", "Default"}
     * )
     * @Assert\Email(
     *     message="This value is not a valid email address.",
     *     groups={"Profile", "Register", "Default"}
     * )
     * @Property(type="string", maxLength=150, uniqueItems=true)
     * @Serializer\Groups(groups={"User"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Property(type="string", property="plainPassword")
     */
    private $password;

    /**
     * @Assert\EqualTo(
     *     propertyPath="plainPassword",
     *     message="The field Confirmation were not equal to Password.",
     *     groups={"Register", "Default"}
     * )
     * @Assert\NotBlank(
     *     message="The field Confirmation is missing.",
     *     groups={"Register"}
     * )
     * @Assert\Length(
     *     min="8",
     *     minMessage="The field Confirmation must do minimum 8 characters",
     *     groups={"Regsiter", "Default"}
     * )
     * @Property(type="string", nullable=false)
     */
    public $confirmPassword;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(
     *     message="The field Password is missing.",
     *     groups={"Register", "Default"}
     * )
     * @Assert\Length(
     *     min="8",
     *     minMessage="The field Password must do 8 characters minimum",
     *     groups={"Register", "Default"}
     * )
     * @Property(type="string", nullable=false)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="boolean")
     * @Property(type="boolean", default="true")
     * @Serializer\Groups(groups={"User"})
     */
    private $availability;

    /**
     * @ORM\Column(type="boolean")
     * @Property(type="boolean", default="true")
     */
    private $isEnabled;

    /**
     * @ORM\Column(type="json")
     * @Property(type="array", @Items(type="json"), default="ROLE_USER")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $salt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @ORM\OneToMany(targetEntity=Teams::class, mappedBy="top", indexBy="name")
     * @Serializer\Groups(groups={"User"})
     */
    private $top;

    /**
     * @ORM\OneToMany(targetEntity=Teams::class, mappedBy="mid", indexBy="name")
     * @Serializer\Groups(groups={"User"})
     */
    private $mid;

    /**
     * @ORM\OneToMany(targetEntity=Teams::class, mappedBy="adc", indexBy="name")
     * @Serializer\Groups(groups={"User"})
     */
    private $adc;

    /**
     * @ORM\OneToMany(targetEntity=Teams::class, mappedBy="jungle", indexBy="name")
     * @Serializer\Groups(groups={"User"})
     */
    private $jungle;

    /**
     * @ORM\OneToMany(targetEntity=Teams::class, mappedBy="support", indexBy="name")
     * @Serializer\Groups(groups={"User"})
     */
    private $support;

    /**
     * @ORM\OneToMany(targetEntity=Report::class, mappedBy="user")
     */
    private $reports;

    /**
     * @ORM\OneToMany(targetEntity=Sanction::class, mappedBy="user")
     */
    private $sanctions;

    public function __construct()
    {
        $this->top = new ArrayCollection();
        $this->mid = new ArrayCollection();
        $this->adc = new ArrayCollection();
        $this->jungle = new ArrayCollection();
        $this->support = new ArrayCollection();
        $this->reports = new ArrayCollection();
        $this->sanctions = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function defaultAttributes()
    {
        $this->availability = true;
        $this->isEnabled = true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSummonerName(): ?string
    {
        return $this->summonerName;
    }

    public function setSummonerName(string $summonerName): self
    {
        $this->summonerName = $summonerName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getAvailability(): ?bool
    {
        return $this->availability;
    }

    public function setAvailability(bool $availability): self
    {
        $this->availability = $availability;

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

    /**
     * @return array|null
     */
    public function getRoles(): ?array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return string|void|null
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function setSalt(string $salt): self
    {
        $this->salt = $salt;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return string
     * @Property(type="string", property="summonerName")
     */
    public function getUsername()
    {
        return $this->summonerName;
    }

    /**
     *
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
        $this->token = null;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return true === $this->isEnabled;
    }

    /**
     * @return Collection|Teams[]
     */
    public function getTop(): Collection
    {
        return $this->top;
    }

    public function addTop(Teams $top): self
    {
        if (!$this->top->contains($top)) {
            $this->top[] = $top;
            $top->setTop($this);
        }

        return $this;
    }

    public function removeTop(Teams $top): self
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
     * @return Collection|Teams[]
     */
    public function getMid(): Collection
    {
        return $this->mid;
    }

    public function addMid(Teams $mid): self
    {
        if (!$this->mid->contains($mid)) {
            $this->mid[] = $mid;
            $mid->setMid($this);
        }

        return $this;
    }

    public function removeMid(Teams $mid): self
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
     * @return Collection|Teams[]
     */
    public function getAdc(): Collection
    {
        return $this->adc;
    }

    public function addAdc(Teams $adc): self
    {
        if (!$this->adc->contains($adc)) {
            $this->adc[] = $adc;
            $adc->setAdc($this);
        }

        return $this;
    }

    public function removeAdc(Teams $adc): self
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
     * @return Collection|Teams[]
     */
    public function getJungle(): Collection
    {
        return $this->jungle;
    }

    public function addJungle(Teams $jungle): self
    {
        if (!$this->jungle->contains($jungle)) {
            $this->jungle[] = $jungle;
            $jungle->setJungle($this);
        }

        return $this;
    }

    public function removeJungle(Teams $jungle): self
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
     * @return Collection|Teams[]
     */
    public function getSupport(): Collection
    {
        return $this->support;
    }

    public function addSupport(Teams $support): self
    {
        if (!$this->support->contains($support)) {
            $this->support[] = $support;
            $support->setSupport($this);
        }

        return $this;
    }

    public function removeSupport(Teams $support): self
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
     * @return Collection|Report[]
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    public function addReport(Report $report): self
    {
        if (!$this->reports->contains($report)) {
            $this->reports[] = $report;
            $report->setUser($this);
        }

        return $this;
    }

    public function removeReport(Report $report): self
    {
        if ($this->reports->removeElement($report)) {
            // set the owning side to null (unless already changed)
            if ($report->getUser() === $this) {
                $report->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Sanction[]
     */
    public function getSanctions(): Collection
    {
        return $this->sanctions;
    }

    public function addSanction(Sanction $sanction): self
    {
        if (!$this->sanctions->contains($sanction)) {
            $this->sanctions[] = $sanction;
            $sanction->setUser($this);
        }

        return $this;
    }

    public function removeSanction(Sanction $sanction): self
    {
        if ($this->sanctions->removeElement($sanction)) {
            // set the owning side to null (unless already changed)
            if ($sanction->getUser() === $this) {
                $sanction->setUser(null);
            }
        }

        return $this;
    }
}

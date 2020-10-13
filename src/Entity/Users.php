<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 9/24/20
 * Time: 4:50 PM
 */

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @UniqueEntity(
 *     fields={"summonerName"},
 *     message="This summonerName is already used."
 * )
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class Users implements UserInterface
{
    use BlameableEntity;
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="summoner_name", type="string", length=16)
     * @Assert\NotBlank(
     *     message="The field Summoner Name is missing.",
     *     groups={"Register", "Profil"}
     * )
     * @Assert\Length(
     *     min="3",
     *     minMessage="The field Summoner Name must do minimum 3 characters",
     *     max="16",
     *     maxMessage="The field Summoner Name not must do superior at 16 characters",
     *     groups={"Register", "Profil"}
     * )
     *
     */
    private $summonerName;

    /**
     * @ORM\Column(name="email", type="string", length=150, nullable=true)
     * @Assert\NotBlank(
     *     message="The field Email is missing.",
     *     groups={"Profil"}
     * )
     * @Assert\Email(
     *     message="This value is not a valid email address.",
     *     groups={"Profil"}
     * )
     */
    private $email;

    /**
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @Assert\EqualTo(
     *     propertyPath="plainPassword",
     *     message="The field Confirmation were not equal to Password.",
     *     groups={"Register", "Profil"}
     * )
     * @Assert\NotBlank(
     *     message="The field Confirmation is missing.",
     *     groups={"Register", "Profil"}
     * )
     * @Assert\Length(
     *     min="8",
     *     minMessage="The field Confirmation must do minimum 8 characters",
     *     groups={"Regsiter", "Profil"}
     * )
     * @Assert\Regex(
     *     pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$",
     *     message="The field Password must contains one number and one special character",
     *     groups={"Register", "Profil"}
     * )
     */
    public $confirmPassword;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(
     *     message="The field Password is missing.",
     *     groups={"Register", "Profil"}
     * )
     * @Assert\Length(
     *     min="8",
     *     minMessage="The field Password must do 8 characters minimum",
     *     groups={"Register", "Profil"}
     * )
     * @Assert\Regex(
     *     pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$",
     *     message="The field Password must contains one number and one special character",
     *     groups={"Register", "Profil"}
     * )
     */
    private $plainPassword;

    /**
     * @ORM\Column(name="availability", type="boolean")
     */
    private $availability;

    /**
     * @ORM\Column(name="is_enabled", type="boolean")
     */
    private $isEnabled;

    /**
     * @ORM\Column(name="roles", type="json")
     * @Assert\NotBlank(message="The field Roles is missing.")
     */
    private $roles = [];

    /**
     * @ORM\Column(name="salt", type="string")
     */
    private $salt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Teams", inversedBy="top")
     */
    private $top;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Teams", inversedBy="jungle")
     */
    private $jungle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Teams", inversedBy="adc")
     */
    private $adc;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Teams", inversedBy="mid")
     */
    private $mid;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="support")
     */
    private $support;

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
    public function getSummonerName(): ?string
    {
        return $this->summonerName;
    }

    /**
     * @param string|null $summonerName
     * @return $this
     */
    public function setSummonerName(?string $summonerName): self
    {
        $this->summonerName = $summonerName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return $this
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return $this
     */
    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $plainPassword
     * @return $this
     */
    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAvailability(): ?bool
    {
        return $this->availability;
    }

    /**
     * @param bool $availability
     * @return $this
     */
    public function setAvailability(bool $availability): self
    {
        $this->availability = $availability;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsEnabled(): ?bool
    {
        return $this->isEnabled;
    }

    /**
     * @param bool $isEnabled
     * @return $this
     */
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

    /**
     * @param string|null $salt
     */
    public function setSalt(?string $salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return string
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
    }

    /**
     * @return mixed
     */
    public function getTop(): ?Teams
    {
        return $this->top;
    }

    /**
     * @param Teams|null $top
     * @return $this
     */
    public function setTop(?Teams $top): self
    {
        $this->top = $top;
    }

    /**
     * @return mixed
     */
    public function getJungle(): ?Teams
    {
        return $this->jungle;
    }

    /**
     * @param Teams|null $jungle
     * @return $this
     */
    public function setJungle(?Teams $jungle): self
    {
        $this->jungle = $jungle;
    }

    /**
     * @return mixed
     */
    public function getAdc(): ?Teams
    {
        return $this->adc;
    }

    /**
     * @param Teams|null $adc
     * @return $this
     */
    public function setAdc(?Teams $adc): self
    {
        $this->adc = $adc;
    }

    /**
     * @return mixed
     */
    public function getMid(): ?Teams
    {
        return $this->mid;
    }

    /**
     * @param Teams|null $mid
     * @return $this
     */
    public function setMid(?Teams $mid): self
    {
        $this->mid = $mid;
    }

    /**
     * @return mixed
     */
    public function getSupport(): ?Teams
    {
        return $this->support;
    }

    /**
     * @param Teams|null $support
     * @return $this
     */
    public function setSupport(?Teams $support): self
    {
        $this->support = $support;
    }

}

<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository", repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide.")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $role = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\Column(type="string", length=55)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=55)
     */
    private $firstname;

    /**
     * @ORM\OneToMany(targetEntity=Rent::class, mappedBy="user")
     */
    private $rent;

    /**
     * @ORM\OneToMany(targetEntity=Residence::class, mappedBy="user")
     */
    private $residence;

    /**
     * @ORM\OneToMany(targetEntity=Rent::class, mappedBy="tenant")
     */
    private $tenant;

    /**
     * @ORM\OneToMany(targetEntity=Residence::class, mappedBy="representative")
     */
    private $representative;

    public function __construct()
    {
        $this->rent = new ArrayCollection();
        $this->residence = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getUserId(): int
    {
        return (int) $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $role = $this->role;

        return array_unique($role);
    }

    public function setRoles(array $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     * @return string the hashed password for this user
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $nom): self
    {
        $this->name = $nom;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstname;
    }

    public function setFirstName(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return Collection|Rent[]
     */
    public function getRent(): Collection
    {
        return $this->rent;
    }

    public function addRent(Rent $rent): self
    {
        if (!$this->rent->contains($rent)) {
            $this->rent[] = $rent;
            $rent->setUser($this);
        }

        return $this;
    }

    public function removeRent(Rent $rent): self
    {
        if ($this->rent->removeElement($rent)) {
            // set the owning side to null (unless already changed)
            if ($rent->getUser() === $this) {
                $rent->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Residence[]
     */
    public function getResidence(): Collection
    {
        return $this->residence;
    }

    public function addResidence(Residence $residence): self
    {
        if (!$this->residence->contains($residence)) {
            $this->residence[] = $residence;
            $residence->setUser($this);
        }

        return $this;
    }

    public function removeResidence(Residence $residence): self
    {
        if ($this->residence->removeElement($residence)) {
            // set the owning side to null (unless already changed)
            if ($residence->getUser() === $this) {
                $residence->setUser(null);
            }
        }

        return $this;
    }

    public function __toString() {
        if ($this->firstname && $this->name) {
            return $this->firstname . ' ' . $this->name;
        }

        return $this->name;
    }

    /**
     * @return string
     */
    public function getTenant(): Collection
    {
        return $this->tenant;
    }

    public function setTenant(?user $tenant): self
    {
        $this->tenant = $tenant;

        return $this;
    }

    /**
     * @return string
     */
    public function getRepresentative(): Collection
    {
        return $this->representative;
    }

    public function setRepresentative(?user $representative): self
    {
        $this->representative = $representative;

        return $this;
    }
}


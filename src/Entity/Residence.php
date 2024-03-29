<?php

namespace App\Entity;

use App\Repository\ResidenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ResidenceRepository::class)
 */
class Residence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champs ne peut pas être vide")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champs ne peut pas être vide")
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champs ne peut pas être vide")
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=45)
     * @Assert\NotBlank(message="Ce champs ne peut pas être vide")
     * @Assert\Length(
     *      min = 5,
     *      max = 5,
     *      minMessage = "Code postal invalide, il faut {{ limit }} chiffres",
     *      maxMessage = "Code postal invalide, il faut {{ limit }} chiffres",
     * )
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champs ne peut pas être vide")
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $inventoryFile;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @Assert\NotBlank(message="Ce champs ne peut pas être vide")
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @Assert\NotBlank(message="Ce champs ne peut pas être vide")
     */
    private $representative;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="residence")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;

    /**
     * @ORM\OneToMany(targetEntity=Rent::class, mappedBy="residence")
     */
    private $rents;

    public function __construct()
    {
        $this->rents = new ArrayCollection();
    }

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getInventoryFile(): ?string
    {
        return $this->inventoryFile;
    }

    public function setInventoryFile(string $inventoryFile): self
    {
        $this->inventoryFile = $inventoryFile;

        return $this;
    }

    public function getOwner(): ?user
    {
        return $this->owner;
    }

    public function setOwner(?user $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getRepresentative(): ?user
    {
        return $this->representative;
    }

    public function setRepresentative(?user $representative): self
    {
        $this->representative = $representative;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection|Rent[]
     */
    public function getRents(): Collection
    {
        return $this->rents;
    }

    public function addRent(Rent $rent): self
    {
        if (!$this->rents->contains($rent)) {
            $this->rents[] = $rent;
            $rent->setResidence($this);
        }

        return $this;
    }

    public function removeRent(Rent $rent): self
    {
        if ($this->rents->removeElement($rent)) {
            // set the owning side to null (unless already changed)
            if ($rent->getResidence() === $this) {
                $rent->setResidence(null);
            }
        }

        return $this;
    }
}

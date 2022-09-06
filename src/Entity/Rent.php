<?php

namespace App\Entity;

use App\Repository\RentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RentRepository::class)
 */
class Rent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $inventoryFile;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="Ce champs ne peut pas être vide")
     */
    private $arrivalDate;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="Ce champs ne peut pas être vide")
     */
    private $departureDate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $tenantComments;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tenantSignature;

    /**
     * @ORM\Column(type="datetime")
     */
    private $tenantValidatedAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $representativeComments;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $representativeSignature;

    /**
     * @ORM\Column(type="datetime")
     */
    private $representativeValidatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $tenant;

    /**
     * @ORM\ManyToOne(targetEntity=Residence::class , inversedBy="rents")
     */
    private $residence;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rent")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tenantCommentsEnd;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tenantSignatureEnd;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $tenantValidatedAtEnd;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $representativeCommentsEnd;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $representativeSignatureEnd;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $representativeValidatedAtEnd;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(?\DateTimeInterface $arrivalDate): self
    {
        $this->arrivalDate = $arrivalDate;

        return $this;
    }

    public function getDepartureDate(): ?\DateTimeInterface
    {
        return $this->departureDate;
    }

    public function setDepartureDate(?\DateTimeInterface $departureDate): self
    {
        $this->departureDate = $departureDate;

        return $this;
    }

    public function getTenantComments(): ?string
    {
        return $this->tenantComments;
    }

    public function setTenantComments(string $tenantComments): self
    {
        $this->tenantComments = $tenantComments;

        return $this;
    }

    public function getTenantSignature(): ?string
    {
        return $this->tenantSignature;
    }

    public function setTenantSignature(string $tenantSignature): self
    {
        $this->tenantSignature = $tenantSignature;

        return $this;
    }

    public function getTenantValidatedAt(): ?\DateTimeInterface
    {
        return $this->tenantValidatedAt;
    }

    public function setTenantValidatedAt(?\DateTimeInterface $tenantValidatedAt): self
    {
        $this->tenantValidatedAt = $tenantValidatedAt;

        return $this;
    }

    public function getRepresentativeComments(): ?string
    {
        return $this->representativeComments;
    }

    public function setRepresentativeComments(string $representativeComments): self
    {
        $this->representativeComments = $representativeComments;

        return $this;
    }

    public function getRepresentativeSignature(): ?string
    {
        return $this->representativeSignature;
    }

    public function setRepresentativeSignature(string $representativeSignature): self
    {
        $this->representativeSignature = $representativeSignature;

        return $this;
    }

    public function getRepresentativeValidatedAt(): ?\DateTimeInterface
    {
        return $this->representativeValidatedAt;
    }

    public function setRepresentativeValidatedAt(?\DateTimeInterface $representativeValidatedAt): self
    {
        $this->representativeValidatedAt = $representativeValidatedAt;

        return $this;
    }

    public function getTenant(): ?user
    {
        return $this->tenant;
    }

    public function setTenant(?user $tenant): self
    {
        $this->tenant = $tenant;

        return $this;
    }

    public function getResidence(): ?residence
    {
        return $this->residence;
    }

    public function setResidence(?residence $residence): self
    {
        $this->residence = $residence;

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

    public function getTenantCommentsEnd(): ?string
    {
        return $this->tenantCommentsEnd;
    }

    public function setTenantCommentsEnd(?string $tenantCommentsEnd): self
    {
        $this->tenantCommentsEnd = $tenantCommentsEnd;

        return $this;
    }

    public function getTenantSignatureEnd(): ?string
    {
        return $this->tenantSignatureEnd;
    }

    public function setTenantSignatureEnd(?string $tenantSignatureEnd): self
    {
        $this->tenantSignatureEnd = $tenantSignatureEnd;

        return $this;
    }

    public function getTenantValidatedAtEnd(): ?\DateTimeInterface
    {
        return $this->tenantValidatedAtEnd;
    }

    public function setTenantValidatedAtEnd(?\DateTimeInterface $tenantValidatedAtEnd): self
    {
        $this->tenantValidatedAtEnd = $tenantValidatedAtEnd;

        return $this;
    }

    public function getRepresentativeCommentsEnd(): ?string
    {
        return $this->representativeCommentsEnd;
    }

    public function setRepresentativeCommentsEnd(?string $representativeCommentsEnd): self
    {
        $this->representativeCommentsEnd = $representativeCommentsEnd;

        return $this;
    }

    public function getRepresentativeSignatureEnd(): ?string
    {
        return $this->representativeSignatureEnd;
    }

    public function setRepresentativeSignatureEnd(?string $representativeSignatureEnd): self
    {
        $this->representativeSignatureEnd = $representativeSignatureEnd;

        return $this;
    }

    public function getRepresentativeValidatedAtEnd(): ?\DateTimeInterface
    {
        return $this->representativeValidatedAtEnd;
    }

    public function setRepresentativeValidatedAtEnd(?\DateTimeInterface $representativeValidatedAtEnd): self
    {
        $this->representativeValidatedAtEnd = $representativeValidatedAtEnd;

        return $this;
    }
}

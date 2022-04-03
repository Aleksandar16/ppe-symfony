<?php

namespace App\Entity;

use App\Repository\RentRepository;
use Doctrine\ORM\Mapping as ORM;

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
    private $inventory_file;

    /**
     * @ORM\Column(type="datetime")
     */
    private $arrival_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $departure_date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $tenant_comments;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tenant_signature;

    /**
     * @ORM\Column(type="datetime")
     */
    private $tenant_validated_at;

    /**
     * @ORM\Column(type="text")
     */
    private $representative_comments;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $representative_signature;

    /**
     * @ORM\Column(type="datetime")
     */
    private $representative_validated_at;

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
    private $tenant_comments_end;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tenant_signature_end;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $tenant_validated_at_end;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $representative_comments_end;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $representative_signature_end;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $representative_validated_at_end;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInventoryFile(): ?string
    {
        return $this->inventory_file;
    }

    public function setInventoryFile(string $inventory_file): self
    {
        $this->inventory_file = $inventory_file;

        return $this;
    }

    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->arrival_date;
    }

    public function setArrivalDate(\DateTimeInterface $arrival_date): self
    {
        $this->arrival_date = $arrival_date;

        return $this;
    }

    public function getDepartureDate(): ?\DateTimeInterface
    {
        return $this->departure_date;
    }

    public function setDepartureDate(\DateTimeInterface $departure_date): self
    {
        $this->departure_date = $departure_date;

        return $this;
    }

    public function getTenantComments(): ?string
    {
        return $this->tenant_comments;
    }

    public function setTenantComments(string $tenant_comments): self
    {
        $this->tenant_comments = $tenant_comments;

        return $this;
    }

    public function getTenantSignature(): ?string
    {
        return $this->tenant_signature;
    }

    public function setTenantSignature(string $tenant_signature): self
    {
        $this->tenant_signature = $tenant_signature;

        return $this;
    }

    public function getTenantValidatedAt(): ?\DateTimeInterface
    {
        return $this->tenant_validated_at;
    }

    public function setTenantValidatedAt(\DateTimeInterface $tenant_validated_at): self
    {
        $this->tenant_validated_at = $tenant_validated_at;

        return $this;
    }

    public function getRepresentativeComments(): ?string
    {
        return $this->representative_comments;
    }

    public function setRepresentativeComments(string $representative_comments): self
    {
        $this->representative_comments = $representative_comments;

        return $this;
    }

    public function getRepresentativeSignature(): ?string
    {
        return $this->representative_signature;
    }

    public function setRepresentativeSignature(string $representative_signature): self
    {
        $this->representative_signature = $representative_signature;

        return $this;
    }

    public function getRepresentativeValidatedAt(): ?\DateTimeInterface
    {
        return $this->representative_validated_at;
    }

    public function setRepresentativeValidatedAt(\DateTimeInterface $representative_validated_at): self
    {
        $this->representative_validated_at = $representative_validated_at;

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
        return $this->tenant_comments_end;
    }

    public function setTenantCommentsEnd(?string $tenant_comments_end): self
    {
        $this->tenant_comments_end = $tenant_comments_end;

        return $this;
    }

    public function getTenantSignatureEnd(): ?string
    {
        return $this->tenant_signature_end;
    }

    public function setTenantSignatureEnd(?string $tenant_signature_end): self
    {
        $this->tenant_signature_end = $tenant_signature_end;

        return $this;
    }

    public function getTenantValidatedAtEnd(): ?\DateTimeInterface
    {
        return $this->tenant_validated_at_end;
    }

    public function setTenantValidatedAtEnd(?\DateTimeInterface $tenant_validated_at_end): self
    {
        $this->tenant_validated_at_end = $tenant_validated_at_end;

        return $this;
    }

    public function getRepresentativeCommentsEnd(): ?string
    {
        return $this->representative_comments_end;
    }

    public function setRepresentativeCommentsEnd(?string $representative_comments_end): self
    {
        $this->representative_comments_end = $representative_comments_end;

        return $this;
    }

    public function getRepresentativeSignatureEnd(): ?string
    {
        return $this->representative_signature_end;
    }

    public function setRepresentativeSignatureEnd(?string $representative_signature_end): self
    {
        $this->representative_signature_end = $representative_signature_end;

        return $this;
    }

    public function getRepresentativeValidatedAtEnd(): ?\DateTimeInterface
    {
        return $this->representative_validated_at_end;
    }

    public function setRepresentativeValidatedAtEnd(?\DateTimeInterface $representative_validated_at_end): self
    {
        $this->representative_validated_at_end = $representative_validated_at_end;

        return $this;
    }
}

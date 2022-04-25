<?php

namespace App\Entity;

use App\Repository\InformationsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=InformationsRepository::class)
 */
class Informations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Ce champs ne peut pas être vide")
     * @Assert\NotNull(message="Ce champs ne peut pas être nul")
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numeroAppartement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $batiment;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $etage;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Ce champs ne peut pas être vide")
     * @Assert\NotNull(message="Ce champs ne peut pas être nul")
     * @Assert\Length(
     *      min = 5,
     *      max = 5,
     *      minMessage = "Code postal invalide, il faut {{ limit }} chiffres",
     *      maxMessage = "Code postal invalide, il faut {{ limit }} chiffres",
     * )
     */
    private $codePostal;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotNull(message="Ce champs ne peut pas être nul")
     * @Assert\NotBlank(message="Ce champs ne peut pas être vide")
     */
    private $ville;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Ce champs ne peut pas être vide")
     * @Assert\Length(min=10)
     * @Assert\NotNull(message="Ce champs ne peut pas être nul")
     */
    private $telephone;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="informations", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $tenant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getNumeroAppartement(): ?int
    {
        return $this->numeroAppartement;
    }

    public function setNumeroAppartement(?int $numeroAppartement): self
    {
        $this->numeroAppartement = $numeroAppartement;

        return $this;
    }

    public function getBatiment(): ?string
    {
        return $this->batiment;
    }

    public function setBatiment(?string $batiment): self
    {
        $this->batiment = $batiment;

        return $this;
    }

    public function getEtage(): ?int
    {
        return $this->etage;
    }

    public function setEtage(?int $etage): self
    {
        $this->etage = $etage;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->codePostal;
    }

    public function setCodePostal(int $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(?int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getTenant(): ?User
    {
        return $this->tenant;
    }

    public function setTenant(User $tenant): self
    {
        $this->tenant = $tenant;

        return $this;
    }
}

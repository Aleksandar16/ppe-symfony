<?php

namespace App\Entity;

use App\Repository\CoordonneesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CoordonneesRepository::class)
 */
class Coordonnees
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $telephone;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="coordonnees", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $representative;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDebutContrat;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateFinContrat;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaireRelation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getRepresentaive(): ?User
    {
        return $this->representative;
    }

    public function setRepresentative(User $representative): self
    {
        $this->representative = $representative;

        return $this;
    }

    public function getDateDebutContrat(): ?\DateTimeInterface
    {
        return $this->dateDebutContrat;
    }

    public function setDateDebutContrat(\DateTimeInterface $dateDebutContrat): self
    {
        $this->dateDebutContrat = $dateDebutContrat;

        return $this;
    }

    public function getDateFinContrat(): ?\DateTimeInterface
    {
        return $this->dateFinContrat;
    }

    public function setDateFinContrat(\DateTimeInterface $dateFinContrat): self
    {
        $this->dateFinContrat = $dateFinContrat;

        return $this;
    }

    public function getCommentaireRelation(): ?string
    {
        return $this->commentaireRelation;
    }

    public function setCommentaireRelation(?string $commentaireRelation): self
    {
        $this->commentaireRelation = $commentaireRelation;

        return $this;
    }
}

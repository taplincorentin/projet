<?php

namespace App\Entity;

use App\Repository\SeanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeanceRepository::class)]
class Seance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateHeureDepart = null;

    #[ORM\Column(length: 50)]
    private ?string $ville = null;

    #[ORM\ManyToOne(inversedBy: 'seancesOrganisees')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Personne $organisateur = null;

    #[ORM\ManyToMany(targetEntity: Personne::class, inversedBy: 'seancesParticipees')]
    private Collection $participants;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'seances')]
    private ?Theme $theme = null;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateHeureDepart(): ?\DateTimeInterface
    {
        return $this->dateHeureDepart;
    }

    public function setDateHeureDepart(\DateTimeInterface $dateHeureDepart): static
    {
        $this->dateHeureDepart = $dateHeureDepart;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getOrganisateur(): ?Personne
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?Personne $organisateur): static
    {
        $this->organisateur = $organisateur;

        return $this;
    }

    /**
     * @return Collection<int, Personne>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Personne $participant): static
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
        }

        return $this;
    }

    public function removeParticipant(Personne $participant): static
    {
        $this->participants->removeElement($participant);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function __toString(){
        return $this->nom;
    }

    public function getTheme(): ?Theme
    {
        return $this->theme;
    }

    public function setTheme(?Theme $theme): static
    {
        $this->theme = $theme;

        return $this;
    }
}

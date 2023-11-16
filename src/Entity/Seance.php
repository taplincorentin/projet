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

    #[ORM\Column(length: 100)]
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

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 12, nullable: true)]
    private ?string $pointLatitude = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 12, nullable: true)]
    private ?string $pointLongitude = null;

    #[ORM\OneToOne(inversedBy: 'seance', cascade: ['persist', 'remove'])]
    private ?Topic $topic = null;

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


    public function getTheme(): ?Theme
    {
        return $this->theme;
    }

    public function setTheme(?Theme $theme): static
    {
        $this->theme = $theme;

        return $this;
    }

    public function getPointLatitude(): ?string
    {
        return $this->pointLatitude;
    }

    public function setPointLatitude(?string $pointLatitude): static
    {
        $this->pointLatitude = $pointLatitude;

        return $this;
    }

    public function getPointLongitude(): ?string
    {
        return $this->pointLongitude;
    }

    public function setPointLongitude(?string $pointLongitude): static
    {
        $this->pointLongitude = $pointLongitude;

        return $this;
    }

    public function getTopic(): ?Topic
    {
        return $this->topic;
    }

    public function setTopic(?Topic $topic): static
    {
        $this->topic = $topic;

        return $this;
    }

    public function createAssociatedTopic(){
        
        //create Topic
        $topic = new Topic();

        
        //create and set topic title
        $title = "[DISCUSSION] ".($this->getNom());
        $topic->SetTitre($title);

        //set topic as the walk's topic
        $this->setTopic($topic);
    }

    public function __toString(){
        return $this->nom;
    }

}

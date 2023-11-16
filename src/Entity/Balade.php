<?php

namespace App\Entity;

use App\Entity\Topic;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BaladeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: BaladeRepository::class)]
class Balade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 50)]
    private ?string $ville = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateHeureDepart = null;

    #[ORM\ManyToMany(targetEntity: Personne::class, inversedBy: 'balades')]
    private Collection $personnes;

    #[ORM\ManyToOne(inversedBy: 'baladesOrganisees')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Personne $organisateur = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 12, nullable: true)]
    private ?string $pointLongitude = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 12, nullable: true)]
    private ?string $pointLatitude = null;

    #[ORM\OneToOne(inversedBy: 'balade', cascade: ['persist', 'remove'])]
    private ?Topic $topic = null;


    public function __construct()
    {
        $this->personnes = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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

    public function getDateHeureDepart(): ?\DateTimeInterface
    {
        return $this->dateHeureDepart;
    }

    public function setDateHeureDepart(\DateTimeInterface $dateHeureDepart): static
    {
        $this->dateHeureDepart = $dateHeureDepart;

        return $this;
    }

    /**
     * @return Collection<int, Personne>
     */
    public function getPersonnes(): Collection
    {
        return $this->personnes;
    }

    public function addPersonne(Personne $personne): static
    {
        if (!$this->personnes->contains($personne)) {
            $this->personnes->add($personne);
        }

        return $this;
    }

    public function removePersonne(Personne $personne): static
    {
        $this->personnes->removeElement($personne);

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


    public function getPointLongitude(): ?string
    {
        return $this->pointLongitude;
    }

    public function setPointLongitude(?string $pointLongitude): static
    {
        $this->pointLongitude = $pointLongitude;

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

<?php

namespace App\Entity;

use App\Repository\TopicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TopicRepository::class)]
class Topic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\ManyToOne(inversedBy: 'topics')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    #[ORM\OneToMany(mappedBy: 'topic', targetEntity: Post::class, orphanRemoval: true)]
    private Collection $posts;

    #[ORM\ManyToOne(inversedBy: 'topics')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Personne $auteur = null;

    #[ORM\OneToOne(mappedBy: 'topic', cascade: ['persist', 'remove'])]
    private ?Balade $balade = null;

    #[ORM\OneToOne(mappedBy: 'topic', cascade: ['persist', 'remove'])]
    private ?Seance $seance = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastModified = null;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): static
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setTopic($this);
        }

        return $this;
    }

    public function removePost(Post $post): static
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getTopic() === $this) {
                $post->setTopic(null);
            }
        }

        return $this;
    }

    public function getAuteur(): ?Personne
    {
        return $this->auteur;
    }

    public function setAuteur(?Personne $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function __toString(){
        return $this->titre;
    }

    public function getBalade(): ?Balade
    {
        return $this->balade;
    }

    public function setBalade(?Balade $balade): static
    {
        // unset the owning side of the relation if necessary
        if ($balade === null && $this->balade !== null) {
            $this->balade->setTopic(null);
        }

        // set the owning side of the relation if necessary
        if ($balade !== null && $balade->getTopic() !== $this) {
            $balade->setTopic($this);
        }

        $this->balade = $balade;

        return $this;
    }

    public function getSeance(): ?Seance
    {
        return $this->seance;
    }

    public function setSeance(?Seance $seance): static
    {
        // unset the owning side of the relation if necessary
        if ($seance === null && $this->seance !== null) {
            $this->seance->setTopic(null);
        }

        // set the owning side of the relation if necessary
        if ($seance !== null && $seance->getTopic() !== $this) {
            $seance->setTopic($this);
        }

        $this->seance = $seance;

        return $this;
    }

    public function getLastModified(): ?\DateTimeInterface
    {
        return $this->lastModified;
    }

    public function setLastModified(?\DateTimeInterface $lastModified): static
    {
        $this->lastModified = $lastModified;

        return $this;
    }
}

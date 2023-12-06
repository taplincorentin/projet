<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


#[ORM\Entity(repositoryClass: PersonneRepository::class)]
#[UniqueEntity(fields: ['pseudo'], message: 'username already used')] //check pseudo est unique
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')] //check email est unique

class Personne implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 180, unique: true)] 
    private ?string $pseudo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private $nomImageProfil;


    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $dateCreation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column (nullable: true)]
    private ?bool $isEducateur = null;

    #[ORM\OneToMany(mappedBy: 'personne', targetEntity: Chien::class, orphanRemoval: true)]
    private Collection $chiens;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: Topic::class)]
    private Collection $topics;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: Post::class)]
    private Collection $posts;

    #[ORM\ManyToMany(targetEntity: Balade::class, mappedBy: 'personnes')]
    private Collection $balades;

    #[ORM\OneToMany(mappedBy: 'organisateur', targetEntity: Seance::class, orphanRemoval: true)]
    private Collection $seancesOrganisees;

    #[ORM\ManyToMany(targetEntity: Seance::class, mappedBy: 'participants')]
    private Collection $seancesParticipees;

    #[ORM\OneToMany(mappedBy: 'organisateur', targetEntity: Balade::class, orphanRemoval: true)]
    private Collection $baladesOrganisees;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastLogin = null;


    

    public function __construct()
    {
        $this->chiens = new ArrayCollection();
        $this->topics = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->balades = new ArrayCollection();
        $this->seancesOrganisees = new ArrayCollection();
        $this->seancesParticipees = new ArrayCollection();
        $this->baladesOrganisees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }


    public function getNomImageProfil(): ?string
    {
        return $this->nomImageProfil;
    }

    public function setNomImageProfil(?string $nomImageProfil): self
    {
        $this->nomImageProfil = $nomImageProfil;

        return $this;
    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->pseudo;
    }


    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTime $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

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

    public function isIsEducateur(): ?bool
    {
        return $this->isEducateur;
    }

    public function setIsEducateur(bool $isEducateur): static
    {
        $this->isEducateur = $isEducateur;

        return $this;
    }


    /**
     * @return Collection<int, Chien>
     */
    public function getChiens(): Collection
    {
        return $this->chiens;
    }

    public function addChien(Chien $chien): static
    {
        if (!$this->chiens->contains($chien)) {
            $this->chiens->add($chien);
            $chien->setPersonne($this);
        }

        return $this;
    }

    public function removeChien(Chien $chien): static
    {
        if ($this->chiens->removeElement($chien)) {
            // set the owning side to null (unless already changed)
            if ($chien->getPersonne() === $this) {
                $chien->setPersonne(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Topic>
     */
    public function getTopics(): Collection
    {
        return $this->topics;
    }

    public function addTopic(Topic $topic): static
    {
        if (!$this->topics->contains($topic)) {
            $this->topics->add($topic);
            $topic->setAuteur($this);
        }

        return $this;
    }

    public function removeTopic(Topic $topic): static
    {
        if ($this->topics->removeElement($topic)) {
            // set the owning side to null (unless already changed)
            if ($topic->getAuteur() === $this) {
                $topic->setAuteur(null);
            }
        }

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
            $post->setAuteur($this);
        }

        return $this;
    }

    public function removePost(Post $post): static
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getAuteur() === $this) {
                $post->setAuteur(null);
            }
        }

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    

    /**
     * @return Collection<int, Balade>
     */
    public function getBalades(): Collection
    {
        return $this->balades;
    }

    public function addBalade(Balade $balade): static
    {
        if (!$this->balades->contains($balade)) {
            $this->balades->add($balade);
            $balade->addPersonne($this);
        }

        return $this;
    }

    public function removeBalade(Balade $balade): static
    {
        if ($this->balades->removeElement($balade)) {
            $balade->removePersonne($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Seance>
     */
    public function getSeancesOrganisees(): Collection
    {
        return $this->seancesOrganisees;
    }

    public function addSeancesOrganisee(Seance $seancesOrganisee): static
    {
        if (!$this->seancesOrganisees->contains($seancesOrganisee)) {
            $this->seancesOrganisees->add($seancesOrganisee);
            $seancesOrganisee->setOrganisateur($this);
        }

        return $this;
    }

    public function removeSeancesOrganisee(Seance $seancesOrganisee): static
    {
        if ($this->seancesOrganisees->removeElement($seancesOrganisee)) {
            // set the owning side to null (unless already changed)
            if ($seancesOrganisee->getOrganisateur() === $this) {
                $seancesOrganisee->setOrganisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Seance>
     */
    public function getSeancesParticipees(): Collection
    {
        return $this->seancesParticipees;
    }

    public function addSeancesParticipee(Seance $seancesParticipee): static
    {
        if (!$this->seancesParticipees->contains($seancesParticipee)) {
            $this->seancesParticipees->add($seancesParticipee);
            $seancesParticipee->addParticipant($this);
        }

        return $this;
    }

    public function removeSeancesParticipee(Seance $seancesParticipee): static
    {
        if ($this->seancesParticipees->removeElement($seancesParticipee)) {
            $seancesParticipee->removeParticipant($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Balade>
     */
    public function getBaladesOrganisees(): Collection
    {
        return $this->baladesOrganisees;
    }

    public function addBaladesOrganisee(Balade $baladesOrganisee): static
    {
        if (!$this->baladesOrganisees->contains($baladesOrganisee)) {
            $this->baladesOrganisees->add($baladesOrganisee);
            $baladesOrganisee->setOrganisateur($this);
        }

        return $this;
    }

    public function removeBaladesOrganisee(Balade $baladesOrganisee): static
    {
        if ($this->baladesOrganisees->removeElement($baladesOrganisee)) {
            // set the owning side to null (unless already changed)
            if ($baladesOrganisee->getOrganisateur() === $this) {
                $baladesOrganisee->setOrganisateur(null);
            }
        }

        return $this;
    }


    public function getLastLogin(): ?\DateTime
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTime $lastLogin): static
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function __toString(){
        return $this->pseudo;
    }
}

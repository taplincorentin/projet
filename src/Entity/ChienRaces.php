<?php

namespace App\Entity;

use App\Repository\ChienRacesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChienRacesRepository::class)]
class ChienRaces
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $nomRace = null;

    #[ORM\ManyToOne(inversedBy: 'chienRaces')]
    private ?Chien $chien = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomRace(): ?string
    {
        return $this->nomRace;
    }

    public function setNomRace(string $nomRace): static
    {
        $this->nomRace = $nomRace;

        return $this;
    }

    public function getChien(): ?Chien
    {
        return $this->chien;
    }

    public function setChien(?Chien $chien): static
    {
        $this->chien = $chien;

        return $this;
    }
}

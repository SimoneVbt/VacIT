<?php

namespace App\Entity;

use App\Repository\SollicitatieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SollicitatieRepository::class)
 */
class Sollicitatie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=vacature::class, inversedBy="sollicitaties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vacature;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="sollicitaties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $uitnodiging;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVacature(): ?vacature
    {
        return $this->vacature;
    }

    public function setVacature(?vacature $vacature): self
    {
        $this->vacature = $vacature;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getMotivatie(): ?string
    {
        return $this->motivatie;
    }

    public function setMotivatie(string $motivatie): self
    {
        $this->motivatie = $motivatie;

        return $this;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(string $cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getUitnodiging(): ?bool
    {
        return $this->uitnodiging;
    }

    public function setUitnodiging(?bool $uitnodiging): self
    {
        $this->uitnodiging = $uitnodiging;

        return $this;
    }
}

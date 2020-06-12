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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $uitnodiging;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datum_uitgenodigd;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datum;

    /**
     * @ORM\Column(type="string", length=2000, nullable=true)
     */
    private $motivatie;

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

    public function getUitnodiging(): ?int
    {
        return $this->uitnodiging;
    }

    public function setUitnodiging(?int $uitnodiging): self
    {
        $this->uitnodiging = $uitnodiging;

        return $this;
    }

    public function getDatumUitgenodigd(): ?\DateTimeInterface
    {
        return $this->datum_uitgenodigd;
    }

    public function setDatumUitgenodigd(?\DateTimeInterface $datum_uitgenodigd): self
    {
        $this->datum_uitgenodigd = $datum_uitgenodigd;

        return $this;
    }

    public function getDatum(): ?\DateTimeInterface
    {
        return $this->datum;
    }

    public function setDatum(\DateTimeInterface $datum): self
    {
        $this->datum = $datum;

        return $this;
    }

    public function getMotivatie(): ?string
    {
        return $this->motivatie;
    }

    public function setMotivatie(?string $motivatie): self
    {
        $this->motivatie = $motivatie;

        return $this;
    }
}

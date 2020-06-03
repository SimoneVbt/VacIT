<?php

namespace App\Entity;

use App\Repository\VacatureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VacatureRepository::class)
 */
class Vacature
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="vacatures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $plaatsingsdatum;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $vacaturetitel;

    /**
     * @ORM\Column(type="string", length=5000)
     */
    private $vacaturetekst;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $afbeelding = "default";

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $werkniveau;

    /**
     * @ORM\OneToMany(targetEntity=Sollicitatie::class, mappedBy="vacature")
     */
    private $sollicitaties;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datum_bijgewerkt;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $standplaats;

    public function __construct()
    {
        $this->sollicitaties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPlaatsingsdatum(): ?\DateTimeInterface
    {
        return $this->plaatsingsdatum;
    }

    public function setPlaatsingsdatum(\DateTimeInterface $plaatsingsdatum): self
    {
        $this->plaatsingsdatum = $plaatsingsdatum;

        return $this;
    }

    public function getVacaturetitel(): ?string
    {
        return $this->vacaturetitel;
    }

    public function setVacaturetitel(string $vacaturetitel): self
    {
        $this->vacaturetitel = $vacaturetitel;

        return $this;
    }

    public function getVacaturetekst(): ?string
    {
        return $this->vacaturetekst;
    }

    public function setVacaturetekst(string $vacaturetekst): self
    {
        $this->vacaturetekst = $vacaturetekst;

        return $this;
    }

    public function getAfbeelding(): ?string
    {
        return $this->afbeelding;
    }

    public function setAfbeelding(?string $afbeelding): self
    {
        $this->afbeelding = $afbeelding;

        return $this;
    }

    public function getWerkniveau(): ?string
    {
        return $this->werkniveau;
    }

    public function setWerkniveau(string $werkniveau): self
    {
        $this->werkniveau = $werkniveau;

        return $this;
    }

    public function getDatumBijgewerkt(): ?\DateTimeInterface
    {
        return $this->datum_bijgewerkt;
    }

    public function setDatumBijgewerkt(?\DateTimeInterface $datum_bijgewerkt): self
    {
        $this->datum_bijgewerkt = $datum_bijgewerkt;

        return $this;
    }

    /**
     * @return Collection|Sollicitatie[]
     */
    public function getSollicitaties(): Collection
    {
        return $this->sollicitaties;
    }

    public function addSollicitatie(Sollicitatie $sollicitatie): self
    {
        if (!$this->sollicitaties->contains($sollicitatie)) {
            $this->sollicitaties[] = $sollicitatie;
            $sollicitatie->setVacature($this);
        }

        return $this;
    }

    public function removeSollicitatie(Sollicitatie $sollicitatie): self
    {
        if ($this->sollicitaties->contains($sollicitatie)) {
            $this->sollicitaties->removeElement($sollicitatie);
            // set the owning side to null (unless already changed)
            if ($sollicitatie->getVacature() === $this) {
                $sollicitatie->setVacature(null);
            }
        }

        return $this;
    }

    public function getStandplaats(): ?string
    {
        return $this->standplaats;
    }

    public function setStandplaats(string $standplaats): self
    {
        $this->standplaats = $standplaats;

        return $this;
    }

}

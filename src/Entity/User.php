<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $naam;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $voornaam;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $geboortedatum;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $telefoonnummer;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $adres;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $postcode;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $plaats;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $afbeelding;

    /**
     * @ORM\Column(type="string", length=2000)
     */
    private $motivatie;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $cv;

    /**
     * @ORM\OneToMany(targetEntity=Vacature::class, mappedBy="user")
     */
    
    private $vacatures;

    /**
     * @ORM\OneToMany(targetEntity=Sollicitatie::class, mappedBy="user")
     */
    private $sollicitaties;

    public function __construct()
    {
        parent::__construct();
        $this->vacatures = new ArrayCollection();
        $this->sollicitaties = new ArrayCollection();
    }

    public function getNaam(): ?string
    {
        return $this->naam;
    }

    public function setNaam(string $naam): self
    {
        $this->naam = $naam;

        return $this;
    }

    public function getVoornaam(): ?string
    {
        return $this->voornaam;
    }

    public function setVoornaam(?string $voornaam): self
    {
        $this->voornaam = $voornaam;

        return $this;
    }

    public function getGeboortedatum(): ?\DateTimeInterface
    {
        return $this->geboortedatum;
    }

    public function setGeboortedatum(?\DateTimeInterface $geboortedatum): self
    {
        $this->geboortedatum = $geboortedatum;

        return $this;
    }

    public function getTelefoonnummer(): ?string
    {
        return $this->telefoonnummer;
    }

    public function setTelefoonnummer(string $telefoonnummer): self
    {
        $this->telefoonnummer = $telefoonnummer;

        return $this;
    }

    public function getAdres(): ?string
    {
        return $this->adres;
    }

    public function setAdres(string $adres): self
    {
        $this->adres = $adres;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getPlaats(): ?string
    {
        return $this->plaats;
    }

    public function setPlaats(string $plaats): self
    {
        $this->plaats = $plaats;

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

    /**
     * @return Collection|Vacature[]
     */
    public function getVacatures(): Collection
    {
        return $this->vacatures;
    }

    public function addVacature(Vacature $vacature): self
    {
        if (!$this->vacatures->contains($vacature)) {
            $this->vacatures[] = $vacature;
            $vacature->setUser($this);
        }

        return $this;
    }

    public function removeVacature(Vacature $vacature): self
    {
        if ($this->vacatures->contains($vacature)) {
            $this->vacatures->removeElement($vacature);
            // set the owning side to null (unless already changed)
            if ($vacature->getUser() === $this) {
                $vacature->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Sollicitatie[]
     */
    public function getSollicitaties(): Collection
    {
        return $this->sollicitaties;
    }

    public function addSollicitaty(Sollicitatie $sollicitaty): self
    {
        if (!$this->sollicitaties->contains($sollicitaty)) {
            $this->sollicitaties[] = $sollicitaty;
            $sollicitaty->setUser($this);
        }

        return $this;
    }

    public function removeSollicitaty(Sollicitatie $sollicitaty): self
    {
        if ($this->sollicitaties->contains($sollicitaty)) {
            $this->sollicitaties->removeElement($sollicitaty);
            // set the owning side to null (unless already changed)
            if ($sollicitaty->getUser() === $this) {
                $sollicitaty->setUser(null);
            }
        }

        return $this;
    }
}

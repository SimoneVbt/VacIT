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
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="vacatures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="date")
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
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $afbeelding;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $werkniveau;

    /**
     * @ORM\OneToMany(targetEntity=Sollicitatie::class, mappedBy="vacature")
     */
    private $sollicitaties;

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
            $sollicitaty->setVacature($this);
        }

        return $this;
    }

    public function removeSollicitaty(Sollicitatie $sollicitaty): self
    {
        if ($this->sollicitaties->contains($sollicitaty)) {
            $this->sollicitaties->removeElement($sollicitaty);
            // set the owning side to null (unless already changed)
            if ($sollicitaty->getVacature() === $this) {
                $sollicitaty->setVacature(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\DosageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DosageRepository::class)
 */
class Dosage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $DOS_QUANTITE;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $DOS_UNITE;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDOSQUANTITE(): ?string
    {
        return $this->DOS_QUANTITE;
    }

    public function setDOSQUANTITE(?string $DOS_QUANTITE): self
    {
        $this->DOS_QUANTITE = $DOS_QUANTITE;

        return $this;
    }

    public function getDOSUNITE(): ?string
    {
        return $this->DOS_UNITE;
    }

    public function setDOSUNITE(?string $DOS_UNITE): self
    {
        $this->DOS_UNITE = $DOS_UNITE;

        return $this;
    }
}

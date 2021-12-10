<?php

namespace App\Entity;

use App\Repository\FamilleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FamilleRepository::class)
 */
class Famille
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $fam_code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fam_libelle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFamCode(): ?int
    {
        return $this->fam_code;
    }

    public function setFamCode(int $fam_code): self
    {
        $this->fam_code = $fam_code;

        return $this;
    }

    public function getFamLibelle(): ?string
    {
        return $this->fam_libelle;
    }

    public function setFamLibelle(string $fam_libelle): self
    {
        $this->fam_libelle = $fam_libelle;

        return $this;
    }
}

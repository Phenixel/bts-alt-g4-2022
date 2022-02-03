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
     * @ORM\Column(type="string", length=255)
     */
    private $fam_libelle;

    public function getId(): ?int
    {
        return $this->id;
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

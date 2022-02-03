<?php

namespace App\Entity;

use App\Repository\TypeIndividuRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeIndividuRepository::class)
 */
class TypeIndividu
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
    private $tin_libelle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTinLibelle(): ?string
    {
        return $this->tin_libelle;
    }

    public function setTinLibelle(string $tin_libelle): self
    {
        $this->tin_libelle = $tin_libelle;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\PrescrireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PrescrireRepository::class)
 */
class Prescrire
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
    private $Med_depotlegal;

    /**
     * @ORM\Column(type="integer")
     */
    private $tin_code;

    /**
     * @ORM\Column(type="integer")
     */
    private $dos_code;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMedDepotlegal(): ?int
    {
        return $this->Med_depotlegal;
    }

    public function setMedDepotlegal(int $Med_depotlegal): self
    {
        $this->Med_depotlegal = $Med_depotlegal;

        return $this;
    }

    public function getTinCode(): ?int
    {
        return $this->tin_code;
    }

    public function setTinCode(int $tin_code): self
    {
        $this->tin_code = $tin_code;

        return $this;
    }

    public function getDosCode(): ?int
    {
        return $this->dos_code;
    }

    public function setDosCode(int $dos_code): self
    {
        $this->dos_code = $dos_code;

        return $this;
    }
}

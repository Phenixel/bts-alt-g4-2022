<?php

namespace App\Entity;

use App\Repository\InteractionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InteractionRepository::class)
 */
class Interaction
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
    private $MED_PERTURBATEUR;

    /**
     * @ORM\Column(type="integer")
     */
    private $MED_MED_PERTURBE;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMEDPERTURBATEUR(): ?int
    {
        return $this->MED_PERTURBATEUR;
    }

    public function setMEDPERTURBATEUR(int $MED_PERTURBATEUR): self
    {
        $this->MED_PERTURBATEUR = $MED_PERTURBATEUR;

        return $this;
    }

    public function getMEDMEDPERTURBE(): ?int
    {
        return $this->MED_MED_PERTURBE;
    }

    public function setMEDMEDPERTURBE(int $MED_MED_PERTURBE): self
    {
        $this->MED_MED_PERTURBE = $MED_MED_PERTURBE;

        return $this;
    }
}

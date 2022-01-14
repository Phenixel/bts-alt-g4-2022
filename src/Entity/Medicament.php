<?php

namespace App\Entity;

use App\Repository\MedicamentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MedicamentRepository::class)
 */
class Medicament
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
    private $MED_NOMCOMMERCIAL;

    /**
     * @ORM\Column(type="integer")
     */
    private $FAM_CODE;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $MED_COMPOSITION;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $MED_EFFETS;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $MED_CONTREINDIC;

    /**
     * @ORM\Column(type="float")
     */
    private $MED_PRIXECHANTILLON;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMEDNOMCOMMERCIAL(): ?string
    {
        return $this->MED_NOMCOMMERCIAL;
    }

    public function setMEDNOMCOMMERCIAL(string $MED_NOMCOMMERCIAL): self
    {
        $this->MED_NOMCOMMERCIAL = $MED_NOMCOMMERCIAL;

        return $this;
    }

    public function getFAMCODE(): ?int
    {
        return $this->FAM_CODE;
    }

    public function setFAMCODE(int $FAM_CODE): self
    {
        $this->FAM_CODE = $FAM_CODE;

        return $this;
    }

    public function getMEDCOMPOSITION(): ?string
    {
        return $this->MED_COMPOSITION;
    }

    public function setMEDCOMPOSITION(string $MED_COMPOSITION): self
    {
        $this->MED_COMPOSITION = $MED_COMPOSITION;

        return $this;
    }

    public function getMEDEFFETS(): ?string
    {
        return $this->MED_EFFETS;
    }

    public function setMEDEFFETS(string $MED_EFFETS): self
    {
        $this->MED_EFFETS = $MED_EFFETS;

        return $this;
    }

    public function getMEDCONTREINDIC(): ?string
    {
        return $this->MED_CONTREINDIC;
    }

    public function setMEDCONTREINDIC(string $MED_CONTREINDIC): self
    {
        $this->MED_CONTREINDIC = $MED_CONTREINDIC;

        return $this;
    }

    public function getMEDPRIXECHANTILLON(): ?float
    {
        return $this->MED_PRIXECHANTILLON;
    }

    public function setMEDPRIXECHANTILLON(float $MED_PRIXECHANTILLON): self
    {
        $this->MED_PRIXECHANTILLON = $MED_PRIXECHANTILLON;

        return $this;
    }
}

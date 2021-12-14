<?php

namespace App\Entity;

use App\Repository\StatsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatsRepository::class)
 */
class Stats
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * @var collection|System
     * @ORM\ManyToOne(targetEntity=System::class, inversedBy="stats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $statSystem;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getStatSystem(): ?System
    {
        return $this->statSystem;
    }

    public function setStatSystem(?System $statSystem): self
    {
        $this->statSystem = $statSystem;

        return $this;
    }
}

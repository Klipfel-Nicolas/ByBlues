<?php

namespace App\Entity;

use App\Entity\traits\Timer;
use App\Repository\SystemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass=SystemRepository::class)
 * @ORM\Table(name="`system`")
 */
class System
{
    /**
     * TimesTampableTrait
     */
    use Timer;

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="systems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var collection|Stats
     * @ORM\OneToMany(targetEntity=Stats::class, mappedBy="statSystem")
     */
    private $stats;

    public function __construct()
    {
        $this->stats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Stats[]
     */
    public function getStats(): Collection
    {
        return $this->stats;
    }

    public function addStat(Stats $stat): self
    {
        if (!$this->stats->contains($stat)) {
            $this->stats[] = $stat;
            $stat->setStatSystem($this);
        }

        return $this;
    }

    public function removeStat(Stats $stat): self
    {
        if ($this->stats->removeElement($stat)) {
            if ($stat->getStatSystem() === $this) {
                $stat->setStatSystem(null);
            }
        }

        return $this;
    }
}

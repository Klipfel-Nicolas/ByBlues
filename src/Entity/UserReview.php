<?php

namespace App\Entity;

use App\Entity\traits\Timer;
use App\Repository\UserReviewRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass=UserReviewRepository::class)
 */
class UserReview
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
     * @var float
     * @ORM\Column(type="float")
     */
    private $note;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $review;

    /**
     * @var collection|User
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userReviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var collection|Item
     * @ORM\ManyToOne(targetEntity=Item::class, inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $item;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getReview(): ?string
    {
        return $this->review;
    }

    public function setReview(string $review): self
    {
        $this->review = $review;

        return $this;
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

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }
}

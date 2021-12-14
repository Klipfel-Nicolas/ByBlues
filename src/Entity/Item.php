<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ItemRepository::class)
 */
class Item
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $displayPerDay;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $quantityAviable;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $isPreOrder;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var collection|Order
     * @ORM\ManyToMany(targetEntity=Order::class, inversedBy="items")
     */
    private $orders;

    /**
     * @var collection|Image
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="item", orphanRemoval=true)
     */
    private $images;

    /**
     * @var collection|UserReview
     * @ORM\OneToMany(targetEntity=UserReview::class, mappedBy="item", orphanRemoval=true)
     */
    private $reviews;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDisplayPerDay(): ?int
    {
        return $this->displayPerDay;
    }

    public function setDisplayPerDay(int $displayPerDay): self
    {
        $this->displayPerDay = $displayPerDay;

        return $this;
    }

    public function getQuantityAviable(): ?int
    {
        return $this->quantityAviable;
    }

    public function setQuantityAviable(int $quantityAviable): self
    {
        $this->quantityAviable = $quantityAviable;

        return $this;
    }

    public function getIsPreOrder(): ?bool
    {
        return $this->isPreOrder;
    }

    public function setIsPreOrder(bool $isPreOrder): self
    {
        $this->isPreOrder = $isPreOrder;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        $this->orders->removeElement($order);

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setItem($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            if ($image->getItem() === $this) {
                $image->setItem(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserReview[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(UserReview $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setItem($this);
        }

        return $this;
    }

    public function removeReview(UserReview $review): self
    {
        if ($this->reviews->removeElement($review)) {
            if ($review->getItem() === $this) {
                $review->setItem(null);
            }
        }

        return $this;
    }
}

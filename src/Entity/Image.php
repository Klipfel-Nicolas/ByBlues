<?php

namespace App\Entity;

use App\Entity\traits\Timer;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ImageRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 * @Vich\Uploadable
 */
class Image
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
     * @var int
     * @ORM\Column(type="integer")
     */
    private $imagePlace;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
      * @Vich\UploadableField(mapping="path_file", fileNameProperty="path")
      * @var File
      */
      private $pathFile;

    /**
     * @var Item
     * @ORM\ManyToOne(targetEntity=Item::class, inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     */
    private $item;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

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

    public function setpathFile(?File $image = null): Image
    {
        $this->pathFile = $image;
        $this->updatedAt = new \DateTime();

        return $this;
    }

    public function getPathFile(): ?File
    {
        return $this->pathFile;
    }

    public function setImagePlace(?int $imagePlace): self
    {
        $this->imagePlace = $imagePlace;

        return $this;
    }

    public function getImagePlace(): ?int
    {
        return $this->imagePlace;
    }
}

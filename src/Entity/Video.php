<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Collection;

/**
 *
 * @property  Category
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
 */
class Video
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="5")
     * @ORM\Column(type="text", nullable=false)
     */
    private $title;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="datetime")
     * @ORM\Column(type="text", nullable=false)
     */
    private $createdAt;

    /**
     *
     * @ORM\Column(type="boolean")
     */
   /* private $published;

    /**
     * @Assert\Url
     * @ORM\Column(type="string", length=255)
     * @ORM\Column(type="text", nullable=false)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="videos")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="videos")
     */
    private $user;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
    }

    public function getPublished()
    {
        return $this->published;
    }

    public function setPublished(string $published): void
    {
        $this->published = $published;

    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }


    public function __construct()
    {
        $this->categoryie= new ArrayCollection();
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategory(): Collection
    {
        return $this->categories;
    }


    public function addCategory(Category $category): self
{
    if (!$this->category->contains($category)) {
        $this->category[] = $category;
    }
    return $this;
}

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            // set the owning side to null (unless already changed)
//            if ($category->getUser() === $this) {
//                $category->setUser(null);
//            }
        }

        return $this;
    }



    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }
}

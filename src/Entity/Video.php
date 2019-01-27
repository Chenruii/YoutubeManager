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
     * @Assert\NotBlank()
     * @ORM\Column(type="boolean", length=255)
     * @ORM\Column(type="text", nullable=false)
     */
    private $published;

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
     * @var ArrayCollection
     */
    private $categories;

    /**@ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="videos")
     * @ORM\JoinColumn(nullable=true)
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPublished(): ?string
    {
        return $this->published;
    }

    public function setPublished(string $published): self
    {
        $this->published = $published;

        return $this;
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
        $this->roles =array('ROLE_USER');
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }


    public function addCategories(Category $category): self
{
    if (!$this->categories->contains($category)) {
        $this->categories[] = $category;
        $category->setUser($this);
    }

    return $this;
}

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            // set the owning side to null (unless already changed)
            if ($category->getUser() === $this) {
                $category->setUser(null);
            }
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

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Entity\User;
use App\Entity\Lists;

/**
 * @ApiResource
 * @ORM\Entity()
 */
class Board
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="boards")
     * @ORM\JoinColumn(nullable=false)
     */
    public $userId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="Lists", mappedBy="boardId", cascade={"all"}, orphanRemoval=true)
     * @ApiSubresource
     */
    private $lists;

    public function __construct()
    {
        $this->lists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): User
    {
        return $this->userId;
    }

    public function setUserid(User $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        $this->setSlug($name);
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

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $slug = strtolower($slug);
        $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug);
        $slug = trim($slug, "-");
        $this->slug = $slug;
        return $this;
    }

    public function getLists(): Collection
    {
        return $this->lists;
    }

    public function addList(Lists $list): self
    {
        if (!$this->lists->contains($list)) {
            $this->lists[] = $list;
            $list->setBoardId($this);
        }
        return $this;
    }

    public function removeList(Lists $list): self
    {
        if ($this->lists->contains($list)) {
            $this->lists->removeElement($list);
            if ($list->getBoardId() === $this) {
                $list->setBoardId(null);
            }
        }
        return $this;
    }
}

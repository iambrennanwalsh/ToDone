<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ApiResource
 * @ORM\Entity(repositoryClass="App\Repository\BoardsRepository")
 */
class Boards
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="boards")
     * @ORM\JoinColumn(nullable=false)
     */
    public $userid;

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
    private $created;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modified;

    /**
     * @ORM\Column(type="integer")
     */
    private $total;

    /**
     * @ORM\Column(type="integer")
     */
    private $completed;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Lists", mappedBy="boardid", cascade={"all"}, orphanRemoval=true)
		 * @ApiSubresource
     */
    private $lists;
	
		public function __construct() {
			$this->tasks = new ArrayCollection();
		}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserid(): ?Users
    {
        return $this->userid;
    }

    public function setUserid(?Users $userid): self
    {
        $this->userid = $userid;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreated(): ?string
    {
        return $this->created;
    }

    public function setCreated(string $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getModified(): ?string
    {
        return $this->modified;
    }

    public function setModified(string $modified): self
    {
        $this->modified = $modified;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getCompleted(): ?int
    {
        return $this->completed;
    }

    public function setCompleted(int $completed): self
    {
        $this->completed = $completed;

        return $this;
    }

    public function getLists(): Array
    {
				$temp = array();
				foreach($this->lists as $value) {
					$temp[$value->getPosition()] = $value;
				}
        return $temp;
    }

    public function addLists(Lists $list): self
    {
        if (!$this->lists->contains($list)) {
            $this->lists[] = $list;
            $list->setBoardid($this);
        }

        return $this;
    }

    public function removeTasks(Lists $list): self
    {
        if ($this->lists->contains($list)) {
            $this->lists->removeElement($list);
            if ($list->getBoardid() === $this) {
                $list->setBoardid(null);
            }
        }
        return $this;
    }
}
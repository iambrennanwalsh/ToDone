<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Lists;

/**
 * @ApiResource(attributes={"order"={"position": "ASC"}})
 * @ORM\Entity()
 */
class Card
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Lists", inversedBy="cards")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    public $listId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getListId(): Lists
    {
        return $this->listId;
    }

    public function setListId(Lists $listId): self
    {
        $this->listId = $listId;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;
        return $this;
    }
}

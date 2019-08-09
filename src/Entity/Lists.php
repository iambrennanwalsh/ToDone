<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Entity\Card;
use App\Entity\Board;

/**
 * @ApiResource(attributes={"order"={"position": "ASC"}})
 * @ORM\Entity()
 */
class Lists
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Board", inversedBy="lists")
     * @ORM\JoinColumn(nullable=false)
     */
    public $boardId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @ORM\OneToMany(targetEntity="Card", mappedBy="listId", cascade={"all"}, orphanRemoval=true)
     * @ApiSubresource
     */
    private $cards;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBoardId(): Board
    {
        return $this->boardId;
    }

    public function setBoardId(Board $boardId): self
    {
        $this->boardId = $boardId;
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

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;
        return $this;
    }

    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function addCards(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
            $card->setListId($this);
        }
        return $this;
    }

    public function removeCards(Card $card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
            if ($card->getListId() === $this) {
                $card->setListId(null);
            }
        }
        return $this;
    }
}

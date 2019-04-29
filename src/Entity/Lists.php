<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ApiResource
 * @ORM\Entity(repositoryClass="App\Repository\ListsRepository")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Boards", inversedBy="lists")
     * @ORM\JoinColumn(nullable=false)
     */
    public $boardid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cards", mappedBy="cardid", cascade={"all"}, orphanRemoval=true)
		 * @ApiSubresource
     */
    private $cards;
	
		public function __construct() {
			$this->tasks = new ArrayCollection();
		}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBoardid(): ?Boards
    {
        return $this->boardid;
    }

    public function setBoardid(?Boards $boardid): self
    {
        $this->boardid = $boardid;

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

    public function getCards(): Array
    {
				$temp = array();
				foreach($this->cards as $value) {
					$temp[$value->getPosition()] = $value;
				}
        return $temp;
    }

    public function addCards(Cards $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
            $task->setListid($this);
        }

        return $this;
    }

    public function removeCards(Cards $card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
            if ($card->getListid() === $this) {
                $card->setListid(null);
            }
        }
        return $this;
    }
}
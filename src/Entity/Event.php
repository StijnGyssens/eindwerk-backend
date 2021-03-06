<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"event:read"}},
 *     denormalizationContext={"groups"={"event:write"}},
 *     collectionOperations={
 *          "get",
 *          "post"={"security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_SUPERADMIN')"}
 *      },
 *     itemOperations={
 *          "get",
 *          "put"={"security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_SUPERADMIN')"},
 *          "patch"={"security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_SUPERADMIN')"},
 *          "delete"={"security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_SUPERADMIN')"}
 *      }
 *     )
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endDate;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"group:read","event:read","event:write"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"event:read","event:write"})
     */
    private $location;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"event:read","event:write"})
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Group::class, mappedBy="events")
     * @Groups({"event:read","event:write"})
     */
    private $groups;

    /**
     * @ORM\OneToOne(targetEntity=SocialMedia::class, inversedBy="event", cascade={"persist", "remove"})
     * @Groups({"event:read","event:write"})
     */
    private $socials;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    /**
     * @Groups({"group:read","event:read"})
     */
    public function getStartDateString(): ?string
    {
        return $this->startDate->format('Y-m-d H:i');
    }

    /**
     *
     * @Groups({"event:write"})
     */
    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    /**
     * @Groups({"group:read","event:read"})
     */
    public function getEndDateString(): ?string
    {
        return $this->endDate->format('Y-m-d H:i');
    }

    /**
     *
     * @Groups({"event:write"})
     */
    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = strip_tags($description);

        return $this;
    }

    /**
     * @return Collection<int, Group>
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->addEvent($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->groups->removeElement($group)) {
            $group->removeEvent($this);
        }

        return $this;
    }

    public function getSocials(): ?SocialMedia
    {
        return $this->socials;
    }

    public function setSocials(?SocialMedia $socials): self
    {
        $this->socials = $socials;

        return $this;
    }


    public function __toString(): string
    {
        return $this->getName();
    }
}

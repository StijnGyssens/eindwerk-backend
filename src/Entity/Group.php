<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"group:read"}},
 *     denormalizationContext={"groups"={"group:write"}},
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
 * )
 * @ORM\Entity(repositoryClass=GroupRepository::class)
 * @ORM\Table(name="`group`")
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"group:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"group:read","group:write","member:read","event:read","region:read","style:read","time:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups({"group:read","group:write"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"group:read","group:write"})
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity=Style::class, inversedBy="groups")
     * @Groups({"group:read","group:write"})
     */
    private $fightingStyle;

    /**
     * @ORM\ManyToOne(targetEntity=Region::class, inversedBy="groups")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"group:read","group:write"})
     */
    private $historicalRegion;

    /**
     * @ORM\ManyToOne(targetEntity=Timeperiode::class, inversedBy="groups")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"group:read","group:write"})
     */
    private $timeperiode;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, inversedBy="groups")
     * @Groups({"group:read","group:write"})
     */
    private $events;

    /**
     * @ORM\ManyToMany(targetEntity=Member::class, inversedBy="groups")
     * @Groups({"group:read","group:write"})
     */
    private $members;

    /**
     * @ORM\OneToOne(targetEntity=SocialMedia::class, cascade={"persist", "remove"})
     * @Groups({"group:read","group:write"})
     */
    private $socials;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->members = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = strip_tags($description);

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

    public function getFightingStyle(): ?Style
    {
        return $this->fightingStyle;
    }

    public function setFightingStyle(?Style $fightingStyle): self
    {
        $this->fightingStyle = $fightingStyle;

        return $this;
    }

    public function getHistoricalRegion(): ?Region
    {
        return $this->historicalRegion;
    }

    public function setHistoricalRegion(?Region $historicalRegion): self
    {
        $this->historicalRegion = $historicalRegion;

        return $this;
    }

    public function getTimeperiode(): ?Timeperiode
    {
        return $this->timeperiode;
    }

    public function setTimeperiode(?Timeperiode $timeperiode): self
    {
        $this->timeperiode = $timeperiode;

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        $this->events->removeElement($event);

        return $this;
    }

    /**
     * @return Collection<int, Member>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Member $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
        }

        return $this;
    }

    public function removeMember(Member $member): self
    {
        $this->members->removeElement($member);

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

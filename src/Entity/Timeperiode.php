<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TimeperiodeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"time:read"}},
 *     denormalizationContext={"groups"={"time:write"}},
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
 * @ORM\Entity(repositoryClass=TimeperiodeRepository::class)
 */
class Timeperiode
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"group:read","time:read","time:write"})
     */
    private $timeperiode;

    /**
     * @ORM\OneToMany(targetEntity=Group::class, mappedBy="timeperiode")
     * @Groups({"time:read","time:write"})
     */
    private $groups;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimeperiode(): ?string
    {
        return $this->timeperiode;
    }

    public function setTimeperiode(string $timeperiode): self
    {
        $this->timeperiode = $timeperiode;

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
            $group->setTimeperiode($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->groups->removeElement($group)) {
            // set the owning side to null (unless already changed)
            if ($group->getTimeperiode() === $this) {
                $group->setTimeperiode(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getTimeperiode();
    }
}

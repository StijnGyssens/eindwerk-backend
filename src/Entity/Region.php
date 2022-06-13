<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RegionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"region:read"}},
 *     denormalizationContext={"groups"={"region:write"}},
 *     )
 * @ORM\Entity(repositoryClass=RegionRepository::class)
 */
class Region
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"group:read","region:read","region:write"})
     */
    private $historicalRegion;

    /**
     * @ORM\OneToMany(targetEntity=Group::class, mappedBy="historicalRegion")
     * @Groups({"region:read","region:write"})
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

    public function getHistoricalRegion(): ?string
    {
        return $this->historicalRegion;
    }

    public function setHistoricalRegion(string $historicalRegion): self
    {
        $this->historicalRegion = $historicalRegion;

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
            $group->setHistoricalRegion($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->groups->removeElement($group)) {
            // set the owning side to null (unless already changed)
            if ($group->getHistoricalRegion() === $this) {
                $group->setHistoricalRegion(null);
            }
        }

        return $this;
    }
}

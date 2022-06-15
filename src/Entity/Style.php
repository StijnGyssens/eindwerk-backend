<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StyleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"style:read"}},
 *     denormalizationContext={"groups"={"style:write"}},
 * )
 * @ORM\Entity(repositoryClass=StyleRepository::class)
 */
class Style
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"group:read","style:read","style:write"})
     */
    private $fightingStyle;

    /**
     * @ORM\Column(type="text")
     * @Groups({"style:read","style:write"})
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Group::class, mappedBy="fightingStyle")
     * @Groups({"style:read","style:write"})
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

    public function getFightingStyle(): ?string
    {
        return $this->fightingStyle;
    }

    public function setFightingStyle(string $fightingStyle): self
    {
        $this->fightingStyle = $fightingStyle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = nl2br($description);

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
            $group->setFightingStyle($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->groups->removeElement($group)) {
            // set the owning side to null (unless already changed)
            if ($group->getFightingStyle() === $this) {
                $group->setFightingStyle(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getFightingStyle();
    }
}

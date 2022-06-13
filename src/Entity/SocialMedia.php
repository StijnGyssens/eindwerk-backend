<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SocialMediaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SocialMediaRepository::class)
 */
class SocialMedia
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"group:read","group:write","member:read","member:write","event:read","event:write"})
     */
    private $facebook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"group:read","group:write","member:read","member:write","event:read","event:write"})
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"group:read","group:write","member:read","member:write","event:read","event:write"})
     */
    private $instagram;

    /**
     * @ORM\OneToOne(targetEntity=Member::class, mappedBy="socials", cascade={"persist", "remove"})
     */
    private $member;

    /**
     * @ORM\OneToOne(targetEntity=Event::class, mappedBy="socials", cascade={"persist", "remove"})
     */
    private $event;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): self
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): self
    {
        // unset the owning side of the relation if necessary
        if ($member === null && $this->member !== null) {
            $this->member->setSocials(null);
        }

        // set the owning side of the relation if necessary
        if ($member !== null && $member->getSocials() !== $this) {
            $member->setSocials($this);
        }

        $this->member = $member;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        // unset the owning side of the relation if necessary
        if ($event === null && $this->event !== null) {
            $this->event->setSocials(null);
        }

        // set the owning side of the relation if necessary
        if ($event !== null && $event->getSocials() !== $this) {
            $event->setSocials($this);
        }

        $this->event = $event;

        return $this;
    }
}

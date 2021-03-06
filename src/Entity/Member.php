<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MemberRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"member:read"}},
 *     denormalizationContext={"groups"={"member:write"}},
 *     collectionOperations={
 *          "get",
 *          "post"
 *      },
 *     itemOperations={
 *          "get",
 *          "put"={"security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_SUPERADMIN')"},
 *          "patch"={"security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_SUPERADMIN')"},
 *          "delete"={"security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_SUPERADMIN')"}
 *      }
 *     )
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Member implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"member:read","member:write"})
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    private $simplePassword;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"group:read","member:read","member:write"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"group:read","member:read","member:write"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"group:read","member:read","member:write"})
     */
    private $leader;

    /**
     * @ORM\ManyToMany(targetEntity=Group::class, mappedBy="members")
     * @Groups({"member:read","member:write"})
     */
    private $groups;

    /**
     * @ORM\OneToOne(targetEntity=SocialMedia::class, inversedBy="member", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Groups({"member:read","member:write"})
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


    /**
     * @Groups({"member:write"})
     */
    public function setSimplePassword(string $password): self
    {
        $this->password = password_hash($password,PASSWORD_DEFAULT);
        $this->simplePassword = $password;

        return $this;
    }

    public function getSimplePassword() :string
    {
        return $this->simplePassword;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function isLeader(): ?bool
    {
        return $this->leader;
    }

    public function setLeader(bool $leader): self
    {
        $this->leader = $leader;

        if ($leader){
            $this->setRoles(["ROLE_ADMIN"]);
        }
        else{
            $this->setRoles(["ROLE_USER"]);
        }

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
            $group->addMember($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->groups->removeElement($group)) {
            $group->removeMember($this);
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
        return $this->getFirstName() . " " . $this->getLastName();
    }
}

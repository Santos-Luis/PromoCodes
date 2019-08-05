<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="User")
 */
class User implements UserInterface
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     * @ORM\Id
     */
    private $userName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     */
    private $roles;

    public function __construct(string $userName, string $password, array $roles)
    {
        $this->userName = $userName;
        $this->password = $password;
        $this->roles = json_encode($roles);
    }

    public function getUsername(): string
    {
        return $this->userName;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        return json_decode($this->roles, true);
    }

    public function getSalt(): void
    {
        return null;
    }

    public function eraseCredentials(): void
    {
        // Do nothing
    }
}

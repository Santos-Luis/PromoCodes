<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
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
     * @ORM\Id
     * @ORM\Column(type="string", length=50)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var array
     *
     * @ORM\Column(type="json")
     */
    private $roles;

    public function __construct(string $username, string $password, array $roles)
    {
        $this->username = $username;
        $this->password = $password;
        $this->roles = $roles;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function getSalt(): void
    {
        // Not needed when using the bcrypt algorithm
    }

    public function eraseCredentials(): void
    {
        // Do nothing
    }
}

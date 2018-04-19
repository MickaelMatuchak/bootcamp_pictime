<?php

namespace Bootcamp\Entities;

class User
{
    private $id;
    private $email;
    private $password;
    private $personages;

    public function __construct(string $email, string $password)
    {
        $this->setEmail($email);
        $this->setPassword($password);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getPersonages(): array
    {
        return $this->personages;
    }

    public function setPersonages(array $personages)
    {
        $this->personages = $personages;
    }

    public function setSession()
    {
        $_SESSION['email'] = $this->getEmail();
    }

    public function __toString(): string
    {
        return 'Hello, ' . $this->getEmail();
    }
}

<?php

namespace Bootcamp\Entities;

Abstract class Personage
{
    protected $name;
    protected $life;
    protected $status;
    protected $race;
    protected $user;
    protected $stats;

    const RACES = ['Dwarf', 'Elf', 'Orc', 'Human'];

    public function __construct(string $name, int $life = 100)
    {
        $this->status = true;

        $this->setName($name);
        $this->setLife($life);
        $this->setRace();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getLife(): int
    {
        return $this->life;
    }

    public function setLife(int $life)
    {
        if ($life <= 0) {
            $this->life = 0;
            $this->status = false;
        } else {
            $this->status = true;
            $this->life = $life;
        }
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function getRace(): string
    {
        return $this->race;
    }

    public function setRace()
    {
        $race = explode('\\', \get_class($this));
        $this->race = end($race);
    }

    public function getUser(): int
    {
        return $this->user;
    }

    public function setUser(int $user)
    {
        $this->user = $user;
    }

    public function getStats(): array
    {
        return $this->stats;
    }

    public function setStats(string $name, int $value): bool
    {
        // La caractéristique est définie alors on l'a modifie
        if (in_array($name, Stat::ATTRIBUTES)) {
            $this->stats[$name] = $value;
            return true;
        }

        return false;
    }

    public function attack(Personage $perso, int $jet): bool
    {
        if ($jet - $perso->getStats()['dexterity'] <= 50) {
            return false;
        } else {
            // On récupère les HP de perso et on fait le calcul ((0.2 * perso.armure) - this.force))
            $hp = $perso->getLife() - ($this->getStats()['force'] - (0.2 * $perso->getStats()['armor']));
            $perso->setLife($hp);

            return true;
        }
    }

    public static function jet(): int
    {
        return rand(0, 100);
    }

    public function revive()
    {
        if ($this->getStatus() === false) {

            $this->setLife(75);

            if ($this->getRace() === 'Human')
                $this->setLife(100);
        }
    }
}

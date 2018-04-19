<?php

namespace Bootcamp\Entities;

class Stat
{
    private $id;
    private $race;
    private $name;
    private $value;

    const ATTRIBUTES = ['armor', 'force', 'dexterity'];

    public function __construct(string $race, string $name, int $value)
    {
        $this->setRace($race);
        $this->setName($name);
        $this->setValue($value);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getRace(): string
    {
        return $this->race;
    }

    public function setRace(string $race)
    {
        $expectedRaces = Personage::RACES;

        array_push($expectedRaces, 'Default');

        if (in_array($race, $expectedRaces)) {
            $this->race = $race;
        } else {
            throw new \InvalidArgumentException('Race not accepted');
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        if (in_array($name, self::ATTRIBUTES)) {
            $this->name = $name;
        } else {
            throw new \InvalidArgumentException('Name not accepted');
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value)
    {
        $this->value = $value;
    }
}

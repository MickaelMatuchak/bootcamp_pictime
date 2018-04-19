<?php

namespace Tests;

use Bootcamp\Entities\Personage;
use PHPUnit\Framework\TestCase;
use Bootcamp\Entities\Stat;

class StatTest extends TestCase
{
    /**
     * @test
     */
    public function expectedRace()
    {
        $stat = new Stat(Personage::RACES[0], 'armor', 0);
        $stat1 = new Stat('Default', 'armor', 0);

        $this->assertEquals('Dwarf', $stat->getRace());
        $this->assertEquals('Default', $stat1->getRace());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function badRace()
    {
        $stat = new Stat('BadRace', 'armor', 0);
    }

    /**
     * @test
     */
    public function expectedName()
    {
        $stat = new Stat(Personage::RACES[0], 'armor', 0);
        $stat1 = new Stat(Personage::RACES[0], 'force', 0);
        $stat2 = new Stat(Personage::RACES[0], 'dexterity', 0);

        $this->assertEquals('armor', $stat->getName());
        $this->assertEquals('force', $stat1->getName());
        $this->assertEquals('dexterity', $stat2->getName());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function badName()
    {
        $stat = new Stat(Personage::RACES[0], 'badName', 0);
    }
}

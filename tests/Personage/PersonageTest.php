<?php

namespace Tests;

use Bootcamp\Entities\Personage;
use PHPUnit\Framework\TestCase;
use Bootcamp\Entities\Dwarf;
use Bootcamp\Entities\Elf;

class PersonageTest extends TestCase
{
    /**
     * @test
     */
    public function expectedLife()
    {
        $perso = new Dwarf('Test', 87);

        $this->assertEquals(87, $perso->getLife());
        $this->assertEquals(true, $perso->getStatus());
    }

    /**
     * @test
     */
    public function badLife()
    {
        $perso = new Dwarf('Test', -100);

        $this->assertEquals(0, $perso->getLife());
        $this->assertEquals(false, $perso->getStatus());
    }

    /**
     * @test
     */
    public function exceptedJet()
    {
        $jet = Personage::jet();

        $this->assertGreaterThanOrEqual(0, $jet);
        $this->assertLessThanOrEqual(100, $jet);
    }

    /**
     * @test
     */
    public function expectedRace()
    {
        $perso = new Dwarf('Test', 100);

        $this->assertEquals('Dwarf', $perso->getRace());
    }
}

<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Bootcamp\Entities\Personage;
use Bootcamp\Entities\Human;
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

    /**
     * @test
     */
    public function expectedHumanAtk()
    {
        $perso1 = new Human('Test', 100);
        $perso2 = new Human('Test1', 100);

        $perso1->setStats('force', 30);
        $perso1->setStats('armor', 20);
        $perso1->setStats('dexterity', 10);

        $perso2->setStats('force', 30);
        $perso2->setStats('armor', 20);
        $perso2->setStats('dexterity', 10);

        $this->assertEquals(true, $perso1->attack($perso2, 61));
        $this->assertEquals(false, $perso1->attack($perso2, 60));
        $this->assertEquals(74, $perso2->getLife());
    }

    /**
     * @test
     */
    public function expectedSetStat()
    {
        $perso = new Human('Test', 100);

        $this->assertEquals(true, $perso->setStats('armor', 10));
        $this->assertEquals(true, $perso->setStats('force', 10));
        $this->assertEquals(true, $perso->setStats('dexterity', 10));
        $this->assertEquals(false, $perso->setStats('test', 10));
    }

    /**
     * @test
     */
    public function expectedHumanRevive()
    {
        $perso = new Human('Test', 0);

        $perso->revive();

        $this->assertEquals(true, $perso->getStatus());
        $this->assertEquals(100, $perso->getLife());
    }

    /**
     * @test
     */
    public function expectedDwarfRevive()
    {
        $perso = new Dwarf('Test', 0);

        $perso->revive();

        $this->assertEquals(true, $perso->getStatus());
        $this->assertEquals(75, $perso->getLife());
    }
}

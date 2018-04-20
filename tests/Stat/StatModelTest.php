<?php

namespace Tests;

use Bootcamp\Model\StatModel;
use Bootcamp\Entities\Stat;
use Bootcamp\Entities\Personage;
use Bootcamp\Entities\Pdo;

use PHPUnit\Framework\TestCase;

class StatModelTest extends TestCase
{
    /**
     * @test
     */
    public function expectedHydrateStat()
    {
        $db = Pdo::getInstance();
        $statModel = new StatModel($db);

        $statModel->hydrate(Personage::RACES['0'], 'force');
        $stat = $statModel->fetch();

        $this->assertEquals('4', $stat->getId());
        $this->assertEquals(Personage::RACES['0'], $stat->getRace());
        $this->assertEquals('force', $stat->getName());
        $this->assertEquals('1', $stat->getValue());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function badRaceHydrateStat()
    {
        $db = Pdo::getInstance();
        $statModel = new StatModel($db);

        $statModel->hydrate('badRace', 'armor');
        $stat = $statModel->fetch();
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function badNameHydrateStat()
    {
        $db = Pdo::getInstance();
        $statModel = new StatModel($db);

        $statModel->hydrate(Personage::RACES['1'], 'badName');
        $stat = $statModel->fetch();
    }
}

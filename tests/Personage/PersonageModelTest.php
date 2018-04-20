<?php

namespace Tests;

use Bootcamp\Entities\Elf;
use Bootcamp\Model\PersonageModel;
use PHPUnit\Framework\TestCase;

class PersonageModelTest extends TestCase
{
    /**
     * @test
     */
    public function expectedPersoExist()
    {
        $db = Pdo::getInstance();
        $persoModel = new PersonageModel($db);

        $this->assertEquals(true, $persoModel->isExist('Bidou'));
    }

    /**
     * @test
     */
    public function expectedPersoNotExist()
    {
        $perso = new Elf('N0T3X!stP3rs0', 100);

        $db = Pdo::getInstance();
        $persoModel = new PersonageModel($db);

        $this->assertEquals(false, $persoModel->isExist($perso->getName()));
    }
}

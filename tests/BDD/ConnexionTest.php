<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

// Classe PDO propre aux tests
class Pdo
{
    private static $db = null;

    public function __construct() {}

    public static function getInstance()
    {
        if (is_null(self::$db)) {
            self::$db = new \PDO('mysql:host=localhost;dbname=bootcamp_test', 'root', 'adminroot');
        }

        return self::$db;
    }
}

class ConnexionTest extends TestCase
{
    use TestCaseTrait;

    public function getConnection()
    {
        $database = 'bootcamp_test';
        $db = Pdo::getInstance();

        return $this->createDefaultDBConnection($db, $database);
    }

    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(__DIR__ . '/../fixtures.xml');
    }

    public function testGetRowCount()
    {
        $this->assertEquals(1, $this->getConnection()->getRowCount('user'));
        $this->assertEquals(1, $this->getConnection()->getRowCount('personage'));
        $this->assertEquals(15, $this->getConnection()->getRowCount('stat'));
    }
}

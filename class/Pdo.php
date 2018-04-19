<?php

namespace Bootcamp\Entities;

class Pdo
{
    private static $db = null;

    public function __construct() {}

    public static function getInstance()
    {
        if (is_null(self::$db)) {
            self::$db = new \PDO('mysql:host=localhost;dbname=bootcamp', 'root', 'adminroot');
        }

        return self::$db;
    }
}

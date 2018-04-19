<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Bootcamp\Entities\User;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function expectedToString()
    {
        $user = new User('mika@gmail.com', '');

        $this->assertEquals('Hello, ' . $user->getEmail(), $user->__toString());
    }
}

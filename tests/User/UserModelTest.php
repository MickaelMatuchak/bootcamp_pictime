<?php

namespace Tests;

use Bootcamp\Entities\User;
use Bootcamp\Model\UserModel;
use Bootcamp\Entities\Pdo;

use PHPUnit\Framework\TestCase;

class UserModelTest extends TestCase
{
    /**
     * @test
     */
    public function expectedUserEmailExist()
    {
        $user = new User('mickael.matuchak@pictime-groupe.com', '');

        $db = Pdo::getInstance();
        $userModel = new UserModel($db);

        $this->assertEquals(true, $userModel->isEmailExist($user->getEmail()));
    }

    /**
     * @test
     */
    public function userEmailNotExist()
    {
        $user = new User('testNotExist@gmail.com', '');

        $db = Pdo::getInstance();
        $userModel = new UserModel($db);

        $this->assertEquals(false, $userModel->isEmailExist($user->getEmail()));
    }

    /**
     * @test
     */
    public function expectedUserIdExist()
    {
        $user = new User('mickael.matuchak@pictime-groupe.com', '');
        $user->setId(3);

        $db = Pdo::getInstance();
        $userModel = new UserModel($db);

        $this->assertEquals(true, $userModel->isIdExist($user->getId()));
    }

    /**
     * @test
     */
    public function userIdNotExist()
    {
        $user = new User('mickael.matuchak@pictime-groupe.com', '');
        $user->setId(1585486561484615);

        $db = Pdo::getInstance();
        $userModel = new UserModel($db);

        $this->assertEquals(false, $userModel->isIdExist($user->getId()));
    }

    /**
     * @test
     */
    public function expectedHydrateUser()
    {
        $user = new User('mickael.matuchak@pictime-groupe.com', '');

        $db = Pdo::getInstance();
        $userModel = new UserModel($db);

        $userModel->hydrate($user->getEmail());
        $user = $userModel->fetch();

        $this->assertEquals(1, $user->getId());
        $this->assertEquals('mickael.matuchak@pictime-groupe.com', $user->getEmail());
        $this->assertEquals('azerty', $user->getPassword());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function hydrateFakeUser()
    {
        $user = new User('testNotExist@gmail.com', '');

        $db = Pdo::getInstance();
        $userModel = new UserModel($db);

        $userModel->hydrate($user->getEmail());
    }

    /**
     * @test
     */
    public function badPasswordLogin()
    {
        $user = new User('mickael.matuchak@pictime-groupe.com', 'abcdef');

        $db = Pdo::getInstance();
        $userModel = new UserModel($db);

        $this->assertEquals(false, $userModel->isAllowConnexion($user));
    }

    /**
     * @test
     */
    public function badEmailLogin()
    {
        $user = new User('mickael.matuchak@fake.com', 'azerty');

        $db = Pdo::getInstance();
        $userModel = new UserModel($db);

        $this->assertEquals(false, $userModel->isAllowConnexion($user));
    }

    /**
     * @test
     */
    public function expectedLogin()
    {
        $user = new User('mickael.matuchak@pictime-groupe.com', 'abcdef');

        $db = Pdo::getInstance();
        $userModel = new UserModel($db);

        $this->assertEquals(false, $userModel->isAllowConnexion($user));
    }
}

<?php

namespace Bootcamp\Model;

use Bootcamp\Entities\Personage;
use Bootcamp\Entities\User;

class UserModel
{
    private $db;
    private $user;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    // Vérifie si un utilisateur existe en BDD avec son email
    public function isEmailExist(string $email): bool
    {
        $req = $this->db->prepare('SELECT id FROM user WHERE email = :email');
        $req->execute(array('email' => $email));

        $user = $req->fetch();
        $req->closeCursor();

        return ($user !== false) ? true : false;
    }

    // Vérifie si un utilisateur existe en BDD avec son ID
    public function isIdExist(int $id): bool
    {
        $req = $this->db->prepare('SELECT email FROM user WHERE id = :id');
        $req->execute(array('id' => $id));

        $user = $req->fetch();
        $req->closeCursor();

        return ($user !== false) ? true : false;
    }

    // Enregistre un utilisateur en BDD
    public function saveUser(User $user)
    {
        $req = $this->db->prepare('INSERT INTO user (email, password) VALUES (:email, :password)');
        $req->execute(array('email' => $user->getEmail(), 'password' => $user->getPassword()));

        $req->closeCursor();
    }

    // Fournit les données de la BDD à l'objet
    public function hydrate($email)
    {
        $req = $this->db->prepare('SELECT id, email, password FROM user WHERE email = :email');
        $req->execute(array('email' => $email));

        $data = $req->fetch();
        $req->closeCursor();

        if ($data !== false) {
            $user = new User($data['email'], $data['password']);
            $user->setId($data['id']);

            // Recherche tous les personnages du joueur
            $personages = new PersonageModel($this->db);
            $data = $personages->fetchAllFromUser($user->getId());

            $user->setPersonages($data);

            $this->user = $user;
        } else {
            throw new \InvalidArgumentException('User not found');
        }
    }

    // Vérifie si un utilisateur est en BDD email et MDP
    public function isAllowConnexion(User $user): bool
    {
        $req = $this->db->prepare('SELECT email, password FROM user WHERE email = :email AND password = :password');
        $req->execute(array('email' => $user->getEmail(), 'password' => $user->getPassword()));

        $user = $req->fetch();
        $req->closeCursor();

        return ($user !== false) ? true : false;
    }

    // Retourne l'utilisateur
    public function fetch(): User
    {
        return $this->user;
    }
}

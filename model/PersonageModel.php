<?php

namespace Bootcamp\Model;

use Bootcamp\Entities\Personage;
use Bootcamp\Entities\Stat;
use Bootcamp\Entities\User;

class PersonageModel
{
    private $db;
    private $personage;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    // Enregistre un personnage en BDD
    public function isExist(string $name): bool
    {
        $req = $this->db->prepare('SELECT id FROM personage WHERE name = :name');
        $req->execute(array('name' => $name));

        $perso = $req->fetch();
        $req->closeCursor();

        return ($perso !== false) ? true : false;
    }

    // Enregistre un personnage en BDD
    public function savePersonage(Personage $perso)
    {
        $req = $this->db->prepare('INSERT INTO personage (name, life, status, race, user) VALUES (:name, :life, :status, :race, :user)');
        $req->execute(
            array(
                'name' => $perso->getName(),
                'life' => $perso->getLife(),
                'status' => $perso->getStatus(),
                'race' => $perso->getRace(),
                'user' => $perso->getUser()
            )
        );

        $req->closeCursor();
    }

    // Retourne un personnage ennemi
    public function getRandomEnemy(int $user)
    {
        $req = $this->db->prepare('SELECT name FROM personage WHERE user != :user AND status = :status');
        $req->execute(array('user' => $user, 'status' => 1));

        $persos = $req->fetchAll();

        $perso = $persos[rand(0, count($persos) - 1)];

        $req->closeCursor();

        return $perso['name'];
    }

    // Fournit les données de la BDD à l'objet
    public function hydrate(string $name)
    {
        $req = $this->db->prepare('SELECT id, life, status, race, user FROM personage WHERE name = :name');
        $req->execute(array('name' => $name));

        $perso = $req->fetch();

        // On récupère la classe de la race
        $class = "Bootcamp\Entities\\" . $perso['race'];
        $this->personage = new $class($name, $perso['life']);

        // Récupère l'utilisateur
        $userModel = new UserModel($this->db);
        $this->personage->setUser($perso['user']);

        $statModel = new StatModel($this->db);

        // On calcul les caractéristiques du perso
        foreach (Stat::ATTRIBUTES as $statName) {
            try {
                $statModel->hydrate($this->personage->getRace(), $statName);
                $stat = $statModel->fetch();
            } catch (\InvalidArgumentException $exception) {
                echo $exception;
                return ;
            }

            try {
                $statModel->hydrate('Default', $statName);
                $statDefault = $statModel->fetch();
            } catch (\InvalidArgumentException $exception) {
                echo $exception;
                return ;
            }

            $this->personage->setStats($stat->getName(), $stat->getValue() + $statDefault->getValue());
        }

        $req->closeCursor();
    }

    // Retourne le personnage
    public function fetch(): Personage
    {
        return $this->personage;
    }

    // Retourne les personnages d'un utilisateur
    public function fetchAllFromUser($id): array
    {
        // Recherche tous les personnages du joueur
        $req = $this->db->prepare('SELECT id, name, life, status, race FROM personage WHERE user = :user');
        $req->execute(array('user' => $id));

        $personages = $req->fetchAll();
        $req->closeCursor();

        $data = array();

        if ($personages !== false) {
            foreach ($personages as $perso) {
                // On récupère la classe de la race
                $class = "Bootcamp\Entities\\" . $perso['race'];
                $perso = new $class($perso['name'], $perso['life']);

                $statModel = new StatModel($this->db);

                // On calcul les caractéristiques du perso
                foreach (Stat::ATTRIBUTES as $statName) {
                    $statModel->hydrate($perso->getRace(), $statName);
                    $stat = $statModel->fetch();

                    $statModel->hydrate('Default', $statName);
                    $statDefault = $statModel->fetch();

                    $perso->setStats($stat->getName(), $stat->getValue() + $statDefault->getValue());
                }

                array_push($data, $perso);
            }
        }

        return $data;
    }

    // Met à jour le personnage
    public function update(Personage $perso)
    {
        $req = $this->db->prepare('UPDATE personage SET status = :status, life = :life WHERE name = :name');
        $req->execute(array(
            'status' => $perso->getStatus() ? 1 : 0,
            'life' => $perso->getLife(),
            'name' => $perso->getName()
        ));

        $req->closeCursor();
    }
}

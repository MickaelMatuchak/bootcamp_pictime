<?php

namespace Bootcamp\Model;

use Bootcamp\Entities\Stat;

class StatModel
{
    private $db;
    private $stat;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    // Fournit les données de la BDD à l'objet
    public function hydrate(string $race, string $name)
    {
        $req = $this->db->prepare('SELECT id, value FROM stat WHERE name = :name AND race = :race');
        $req->execute(array('name' => $name, 'race' => $race));

        $data = $req->fetch();
        $req->closeCursor();

        if ($data !== false) {
            $stat = new Stat($race, $name, $data['value']);
            $stat->setId($data['id']);

            $this->stat = $stat;
        } else {
            throw new \InvalidArgumentException('Stat not found');
        }

    }

    // Retourne la statistique
    public function fetch()
    {
        return $this->stat;
    }
}

<?php

// Gère la sauvegarde d'un personnage

session_start();

// Si l'utilisateur n'est pas connecté on le redirige
if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
}

require_once '../../vendor/autoload.php';

use Bootcamp\Entities\Pdo;
use Bootcamp\Entities\Personage;
use Bootcamp\Model\PersonageModel;
use Bootcamp\Model\UserModel;

// Si l'email et le password sont vérifiés
if (isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['race']) && isset($_POST['user'])) {

    // Si la race existe
    if (in_array($_POST['race'], Personage::RACES)) {

        // On récupère la classe de la race
        $class = "Bootcamp\Entities\\" . $_POST['race'];
        $perso = new $class($_POST['name'], 100);
        $perso->setUser($_POST['user']);

        $db = Pdo::getInstance();
        $userModel = new UserModel($db);
        $persoModel = new PersonageModel($db);

        // Si le propriétaire utilisateur existe
        if ($userModel->isIdExist($perso->getUser())) {
            // Si le nom du perso n'existe pas
            if (!$persoModel->isExist($perso->getName())) {
                // Sauvegarde du perso
                $persoModel->savePersonage($perso);
            }
        }
    }
}

header('Location: ../account.php');

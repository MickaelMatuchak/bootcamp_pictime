<?php

// Gère la connexion de utilisateur

session_start();

require_once '../../vendor/autoload.php';

use Bootcamp\Entities\User;
use Bootcamp\Entities\Pdo;
use Bootcamp\Model\UserModel;

// Si l'email et le password sont vérifiés
if (isset($_POST['email']) && isset($_POST['password'])) {
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

        $db = Pdo::getInstance();

        $userModel = new UserModel($db);

        // Si l'email n'est pas en BDD on redirige
        try {
            $userModel->hydrate('email', $_POST['email']);
            $user = $userModel->fetch();
        } catch (InvalidArgumentException $exception) {
            header('Location: ../index.php');
        }

        // Si le password est valide on ajoute en session
        if ($user !== false && password_verify('piCraft' . $_POST['password'], $user->getPassword())) {
            // Ouvre une session
            $user->setSession();
        }

    }
}

header('Location: ../index.php');

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

        $user = new User($_POST['email'], $_POST['password']);
        $userModel = new UserModel($db);

        // Vérifie si l'utilisateur existe avec le bon MDP
        if ($userModel->isAllowConnexion($user)) {
            // Ouvre une session
            $user->setSession();
        }
    }
}

// Redirige sur la page d'accueil
header('Location: ../index.php');

<?php

// Gère l'inscription d'un utilisateur

session_start();

require_once '../vendor/autoload.php';

use Bootcamp\Entities\User;
use Bootcamp\Entities\Pdo;
use Bootcamp\Model\UserModel;

// Si l'email et le password sont vérifiés
if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['retype-password'])) {
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && $_POST['password'] === $_POST['retype-password']) {

        $db = Pdo::getInstance();

        $user = new User($_POST['email'], $_POST['password']);
        $userModel = new UserModel($db);

        // Vérifie si l'email n'est pas déjà utilisée
        if (!$userModel->isEmailExist($user->getEmail())) {

            // Sauvegarde l'utilisateur et ouvre une session
            $userModel->saveUser($user);
            $user->setSession();
        }
    }
}

// Redirige sur la page d'accueil
header('Location: index.php');

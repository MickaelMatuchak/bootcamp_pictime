<?php

// Gère le combat entre deux personnages

session_start();

if (!$_SESSION['email']) {
    header('Location: ../index.php');
}

require_once '../../vendor/autoload.php';

use Bootcamp\Entities\Personage;
use Bootcamp\Entities\User;
use Bootcamp\Entities\Pdo;
use Bootcamp\Model\PersonageModel;
use Bootcamp\Model\UserModel;

$db = Pdo::getInstance();
$userModel = new UserModel($db);
$persoModel = new PersonageModel($db);

try {
    $userModel->hydrate('email', $_SESSION['email']);
    $user = $userModel->fetch();
} catch (InvalidArgumentException $exception){
    echo $exception;
    die();
}

// Si un personnage et un ennemie ont été envoyé ont commence le traitement du combat
if ($_POST['perso']) {

    $persoModel->hydrate($_POST['perso']);
    $perso = $persoModel->fetch();

    // Si la session utilisateur est différente du personnage ont redirige
    if ($user->getId() !== $perso->getUser()) header('Location: ../account.php');

    $perso->revive();

    $persoModel->update($perso);
}

header('Location: ../account.php');

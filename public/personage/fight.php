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
    $userModel->hydrate($_SESSION['email']);
    $user = $userModel->fetch();
} catch (InvalidArgumentException $exception){
    echo $exception;
    die();
}

// Si un personnage et un ennemie ont été envoyé ont commence le traitement du combat
if ($_POST['perso'] && $_POST['enemy']) {

    $persoModel->hydrate($_POST['perso']);
    $perso = $persoModel->fetch();

    $persoModel->hydrate($_POST['enemy']);
    $enemy = $persoModel->fetch();

    // Si la session utilisateur est différente du personnage || ou le propriétaire des deux personnages est identiques ont redirige
    if ($user->getId() !== $perso->getUser() || $enemy->getUser() === $perso->getUser()) header('Location: ../account.php');

    // On peut commencer le combat
    $combatMsg = array();

    $error = false;
    if (!$perso->getStatus() || !$enemy->getStatus()) $error = true;

    while($perso->getStatus() && $enemy->getStatus()) {
        $result = $perso->attack($enemy, Personage::jet());

        if ($result) {
            array_push($combatMsg,
                '<span class="atk">' . $perso->getName() . '(' . $perso->getLife() . ' HP) a touché ' . $enemy->getName() . ' (' . $enemy->getLife() . ' HP)</span>');
        } else {
            array_push($combatMsg, '<span class="miss">'. $perso->getName() . ' a loupé son coup !</span>');
        }

        // Riposte de l'ennemi si sa vie est supérieure à 0
        if ($enemy->getLife() > 0) {
            $result = $enemy->attack($perso, Personage::jet());

            if ($result) {
                array_push($combatMsg,
                    '<span class="atk"> ' . $enemy->getName() . '(' . $enemy->getLife() . ' HP) a touché ' . $perso->getName() . ' (' . $perso->getLife() . ' HP)</span>');
            } else {
                array_push($combatMsg, '<span class="miss">'. $enemy->getName() . ' a loupé son coup !</span>');
            }
        }
    }

    $persoModel->update($enemy);
    $persoModel->update($perso);

    // On détermine le gagnant
    if ($perso->getLife() > 0) {
        $winner = $perso;
    } else {
        $winner = $enemy;
    }

} else {
    header('Location: ../account.php');
}
?>

<html>
<head>
    <title>PiCraft</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
          integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous" />
    <link rel="stylesheet" href="../css/styles.css" />
</head>
<body>
    <h1>Duel PiCraft</h1>

    <a href="../account.php" class="btn btn-warning">My account</a>

    <hr>

    <?php if ($error): ?>
        <h4>Un personnage est mort avant le combat... Un lâche !</h4>
    <?php else: ?>
        <?php if ($winner === $perso): ?>
            <h4>Ton personnage <?= $perso->getName() ?> possède une médaille de plus à son palmarès</h4>
        <?php else: ?>
            <h4>Ton personnage <?= $perso->getName() ?> est à terre...</h4>
        <?php endif; ?>

        <p>Déroulement du combat : </p>
        <ul>
            <?php foreach ($combatMsg as $msg): ?>
                <li><?= $msg; ?></li>
            <?php endforeach; ?>
        </ul>

        <hr>

        <h2>Le grand gagnant est <?= $winner->getName(); ?></h2>
        <h3><?= $winner; ?></h3>
    <?php endif; ?>
</body>

<?php

// Page profil d'un utilisateur

session_start();

if (!$_SESSION['email']) {
    header('Location: index.php');
}

require_once '../vendor/autoload.php';

use Bootcamp\Entities\Pdo;
use Bootcamp\Model\UserModel;
use Bootcamp\Model\PersonageModel;
use Bootcamp\Entities\Personage;

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

$enemyName = $persoModel->getRandomEnemy($user->getId());

if ($enemyName !== null) {
    $persoModel->hydrate($persoModel->getRandomEnemy($user->getId()));
    $enemy = $persoModel->fetch();
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
        <h1>Hello, <?= htmlentities($user->getEmail()); ?> | PiCraft</h1>

        <hr>

        <h2>Objectif kill this Hero :</h2>
        <?php if ($enemyName && isset($enemy)): ?>
            <p>Hello, my name is <b><?= $enemy->getName(); ?> (<?= $enemy->getLife(); ?> HP)</b>. I'm <b><?= $enemy->getRace() ?></b>.</p>
            <p>
                Stats : <br>
                <?php foreach ($enemy->getStats() as $key => $value): ?>
                    <?= $key; ?> : <?= $value; ?> <br>
                <?php endforeach; ?>
            </p>
        <?php else: ?>
            <p>Wait for enemy</p>
        <?php endif; ?>
        <hr>

        <h2>List of your Personages :</h2>
        <?php if (count($user->getPersonages()) > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Race</th>
                        <th>Life</th>
                        <th>Armor</th>
                        <th>Force</th>
                        <th>Dexterity</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <?php foreach ($user->getPersonages() as $perso): ?>
                    <tr>
                        <td><?= $perso->getName(); ?></td>
                        <td><?= $perso->getRace(); ?></td>
                        <td><?= $perso->getLife(); ?> HP : <?= ($perso->getStatus() === true) ? 'In life' : 'Dead'; ?></td>

                        <?php foreach ($perso->getStats() as $key => $value): ?>
                            <td><?= $value; ?></td>
                        <?php endforeach; ?>

                        <td>
                            <?php if ($perso->getStatus()): ?>
                                <?php if (isset($enemy)): ?>
                                    <form action="personage/fight.php" method="post">
                                        <input type="hidden" name="perso" value="<?= $perso->getName(); ?>" />
                                        <input type="hidden" name="enemy" value="<?= $enemy->getName(); ?>" />

                                        <input class="btn btn-success" type="submit" value="To the victory !" />
                                    </form>
                                <?php endif; ?>

                            <?php else: ?>
                                <input class="btn btn-danger" type="submit" value="Revive" />
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Create your Hero now !</p>
        <?php endif; ?>

        <hr>

        <h2>Create new Personage</h2>
        <form action="personage/create.php" method="post">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" placeholder="Thor, Hercule, Captain America..." name="name" class="form-control" id="name" />
            </div>
            <div class="form-group">
                <label for="race">Race</label>
                <select name="race" id="race" class="form-control">
                    <option value="none">Select your race...</option>
                    <?php foreach (Personage::RACES as $race): ?>
                        <option value="<?= $race ?>"><?= $race ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" name="user" value="<?= $user->getId(); ?>" />
            <input type="submit" class="btn btn-success" value="Ok" />
        </form>

        <hr>

        <h2>Rage quit ?</h2>
        <form action="logout.php" method="post">
            <input type="submit" class="btn btn-danger" value="Log out" />
        </form>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    </body>
</html>


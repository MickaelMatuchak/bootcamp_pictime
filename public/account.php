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
     $userModel->hydrate('email', $_SESSION['email']);
     $user = $userModel->fetch();
} catch (InvalidArgumentException $exception){
    echo $exception;
    die();
}

$enemyName = $persoModel->getRandomEnemy($user->getId());

if ($enemyName !== null) {
    // Récupère le personnage ennemi
    $persoModel->hydrate($persoModel->getRandomEnemy($user->getId()));
    $enemy = $persoModel->fetch();

    // Récupère l'utilisateur du personnage ennemi
    $userModel->hydrate('id', $enemy->getUser());
    $userEnemy = $userModel->fetch();
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
        <p>Victory : <?= $user->getVictory(); ?></p>
        <p>Fight : <?= $user->getFight(); ?></p>
        <?php if ($user->getFight() !== 0) : ?>
            <p>Ratio : <?= 100 * $user->getVictory() / $user->getFight(); ?> %</p>
        <?php endif; ?>
        <p>Points : <?= $user->getPoints(); ?></p>

        <hr>

        <h2>Objectif kill this Hero :</h2>
        <?php if ($enemyName && isset($enemy)): ?>
            <p>User : <?= $userEnemy->getEmail() ?></p>
            <p>Hello, my name is <b><?= $enemy->getName(); ?> (<?= $enemy->getLife(); ?> HP)</b>. I'm <b><?= $enemy->getRace() ?></b>.</p>
            <p>
                Stats :
                <ul>
                    <?php foreach ($enemy->getStats() as $key => $value): ?>
                        <li><?= $key; ?> : <?= $value; ?> </li>
                    <?php endforeach; ?>
                </ul>
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
                        <td>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?= $perso->getLife(); ?>"
                                     aria-valuemin="0" aria-valuemax="100" style="width:<?= $perso->getLife(); ?>%">
                                    <span class="sr-only"><?= $perso->getLife(); ?> HP : <?= ($perso->getStatus() === true) ? 'In life' : 'Dead'; ?></span>
                                </div>
                            </div>
                            <?= $perso->getLife(); ?> HP : <?= ($perso->getStatus() === true) ? 'In life' : 'Dead'; ?>
                        </td>

                        <?php foreach ($perso->getStats() as $key => $value): ?>
                            <td>
                                <?= $value; ?>
                                <button class="btn btn-light" disabled title="Coast: 300 points">+</button>
                            </td>
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
                                <form action="personage/revive.php" method="post">
                                    <input type="hidden" name="perso" value="<?= $perso->getName(); ?>" />
                                    <input class="btn btn-dark" type="submit" value="Revive" />
                                </form>
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

        <h3>Information : </h3>
        <p>Basic statistics : 30 Force, 20 Armor, 10 Dexterity - Revive with 75HP !</p>
        <h4>Races</h4>
        <ul>
            <li>Dwarf : +5 Force, +5 Armor, -2 Dexterity</li>
            <li>Elf : -10 Force, +0 Armor, +10 Dexterity</li>
            <li>Human : Basic statistics but he revive with 90 HP !</li>
            <li>Orc : +4 Force, +4 Armor, +0 Dexterity</li>
        </ul>
        <h4>Fight</h4>
            <p>Each round is like this :</p>
            <p>While Personage 1 or Personage 2 are alive</p>
            <ul>
                <li>Personage 1 -> atk -> Personage 2</li>
                <li>Personage 2 -> atk -> Personage 1</li>
            </ul>
            <br>
            <p>Each attack contains random number between 0;100. If : (random number - $persoDef->getDexterity) <= 50,
                BOOOOM. Else LOOSER YOU MISS THE HIT !</p>
            <p>Dammage are calculted with this method : $persoDef->getLife - ($persoAtk->getForce - (20% * $persoDef->getArmor))</p>
        <hr>

        <h2>Rage quit ?</h2>
        <form action="user/logout.php" method="post">
            <input type="submit" class="btn btn-danger" value="Log out" />
        </form>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    </body>
</html>


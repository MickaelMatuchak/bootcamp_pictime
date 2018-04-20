<?php

// Supprime la session en cours et redirige sur la page d'accueil

session_start();

if (isset($_SESSION['email'])) {
    unset($_SESSION['email']);
}

header('Location: ../../index.php');

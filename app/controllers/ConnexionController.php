<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'utilisateurModel.php';
require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'gestionVue.php';

function obtenirInfosPage(): array
{
    return [
        'titre' => 'Connexion',
        'description' => 'Bienvenue sur la page de connexion du site.'
    ];
}

function afficherConnexion()
{
    $args = obtenirInfosPage();

    // Si des erreurs ou messages existent
    if (!empty($_SESSION['connexion_erreur'])) {
        $args['erreur'] = $_SESSION['connexion_erreur'];
        unset($_SESSION['connexion_erreur']);
    }

    if (!empty($_SESSION['ancienPseudo'])) {
        $args['pseudo'] = $_SESSION['ancienPseudo'];
        unset($_SESSION['ancienPseudo']);
    }

    afficherVue('connexion.php', $args);
}

function traiterConnexion()
{
    $pseudo = trim($_POST['connexion_pseudo'] ?? '');
$motDePasse = $_POST['connexion_motDePasse'] ?? '';

if ($pseudo === '' || $motDePasse === '') {
    $_SESSION['connexion_erreur'] = "Tous les champs sont obligatoires.";
    $_SESSION['ancienPseudo'] = $pseudo;
    header("Location: /connexion", true, 303);
    exit();
}

$connexionReussie = connecterUtilisateur($pseudo, $motDePasse);

if ($connexionReussie) {
    header("Location: /profil", true, 303);
    exit();
} else {
    $_SESSION['connexion_erreur'] = "Identifiants invalides.";
    $_SESSION['ancienPseudo'] = $pseudo;
    header("Location: /connexion", true, 303);
    exit();
}
}

function afficherDeconnexion() {
    deconnecterUtilisateur();
    header('Location: /connexion', true, 303);
    exit();
}
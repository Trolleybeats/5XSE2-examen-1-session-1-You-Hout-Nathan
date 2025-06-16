<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'utilisateurModel.php';
require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'gestionVue.php';

function afficherProfil()
{
    if (!isset($_SESSION['utilisateurId'])) {
        header('Location: /connexion');
        exit;
    }

    $utilisateur = obtenirUtilisateurParId($_SESSION['utilisateurId']);

    if (!$utilisateur) {
        $_SESSION['erreurs']['global'] = "Impossible de récupérer les informations de l'utilisateur.";
        header('Location: /');
        exit;
    }

    $args = [
        'titre' => 'Profil',
        'description' => 'Page de profil utilisateur',
        'utilisateur' => $utilisateur
    ];

    afficherVue('profil.php', $args);
}
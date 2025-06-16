<?php

require_once dirname(__DIR__, 2) . '/core/GestionVue.php';

function obtenirInfosPage(): array
{
    return [
        'titre' => 'Accueil',
        'description' => 'Bienvenue sur la page d\'accueil du site.'
    ];
}

function afficherAccueil()
{
    $args = obtenirInfosPage();
    afficherVue('accueil.php', $args);
}

?>
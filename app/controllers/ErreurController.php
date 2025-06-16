<?php

require_once dirname(__DIR__, 2) . '/core/GestionVue.php';

function obtenirInfosPage(): array
{
    return [
        'titre' => 'Erreur404',
        'description' => 'Impossible de trouver la page'
    ];
}

function afficherErreur404()
{
    $args = obtenirInfosPage();
    afficherVue('erreur404.php', $args);
}

?>


?>
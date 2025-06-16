<?php

require_once dirname(__DIR__, 2) . '/core/GestionVue.php';

function obtenirInfosPage(): array
{
    return [
        'titre' => 'Contact',
        'description' => 'Contactez-nous via ce formulaire.'
    ];
}

function afficherContact()
{
    $args = obtenirInfosPage();
    afficherVue('contact.php', $args);
}

?>
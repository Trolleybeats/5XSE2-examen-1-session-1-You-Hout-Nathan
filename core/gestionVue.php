<?php

function afficherVue(string $nomVue, array $args = [])
{
    $cheminTemplates = dirname(__DIR__) . '/app/views/templates/';
    $cheminVue = dirname(__DIR__) . '/app/views/' . $nomVue;

    // Inclure l'en-tête, la vue et le pied de page
    require_once $cheminTemplates . 'header.php';
    require_once $cheminVue;
    require_once $cheminTemplates . 'footer.php';
}

?>
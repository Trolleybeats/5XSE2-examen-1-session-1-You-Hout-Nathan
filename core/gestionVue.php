<?php

function afficherVue(string $nomVue, array $args = [])
{
    $cheminTemplates = dirname(__DIR__) . '/app/views/templates/';
    $cheminVue = dirname(__DIR__) . '/app/views/' . $nomVue;

    if (file_exists($cheminVue)) {
        extract($args); // rend $erreurs, $entreesUtilisateur disponibles
        include $cheminTemplates . 'header.php';
        include $cheminVue;
        include $cheminTemplates . 'footer.php';
    } else {
        echo "Vue $nomVue introuvable.";
    }
}

?>
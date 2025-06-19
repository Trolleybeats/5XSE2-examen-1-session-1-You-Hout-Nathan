<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR .'constante.php';

function afficherVue(string $nomVue, array $args = [])
{
    $cheminTemplates = dirname(__DIR__) . '/app/views/templates/';
    $cheminVue = dirname(__DIR__) . '/app/views/' . $nomVue;

    if (!file_exists($cheminVue)) {
        echo "Vue introuvable à l'emplacement : $cheminVue";
        die();
    }

    extract($args);
    include $cheminTemplates . 'header.php';
    include $cheminVue;
    include $cheminTemplates . 'footer.php';
}


?>
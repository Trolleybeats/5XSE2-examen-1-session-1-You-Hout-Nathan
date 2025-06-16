<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

// Récupérer le chemin demandé dans l'URL (sans paramètres).
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$methode = $_SERVER['REQUEST_METHOD'];

$base = '/forum/public';
if (str_starts_with($url, $base)) {
    $url = substr($url, strlen($base));
    if ($url === '') {
        $url = '/';
    }
}

// Stocker le chemin vers le dossier des contrôleurs.
$cheminControleurs = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR;

// Les contrôleurs sont appelés selon l'URL et la méthode de la requête.
if ($url === '/' && $methode === 'GET')
{
    require_once $cheminControleurs . 'AccueilController.php';
    afficherAccueil();
}
else if ($url === '/contact' && $methode === 'GET')
{
    require_once $cheminControleurs . 'ContactController.php';
    afficherContact();
}
else
{
    require_once $cheminControleurs . 'ErreurController.php';
    afficherErreur404();
}

?>
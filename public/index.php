<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'gestionSession.php';
initialiserSession();

// Récupérer le chemin demandé dans l'URL (sans paramètres).
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


$methode = $_SERVER['REQUEST_METHOD'];

$base = '/public';
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
else if ($url === '/' && $methode === 'POST') {
    require_once $cheminControleurs . 'AccueilController.php';
    traiterCommentaireForm();
}
else if ($url === '/commentaire/supprimer' && $methode === 'POST') {
    require_once $cheminControleurs . 'AccueilController.php';
    traiterSuppressionCommentaire();
}
else if ($url === '/commentaire/modifier' && $methode === 'POST') {
    require_once $cheminControleurs . 'AccueilController.php';
    traiterModificationCommentaire();
}

else if ($url === '/contact' && $methode === 'GET')
{
    require_once $cheminControleurs . 'ContactController.php';
    afficherContact();
}
elseif ($url === '/contact' && $methode === 'POST') {
    require_once $cheminControleurs . 'ContactController.php';
    traiterContactForm($_POST);
}
else if ($url === '/connexion' && $methode === 'GET')
{
    require_once $cheminControleurs . 'ConnexionController.php';
    afficherConnexion();
}
else if ($url === '/connexion' && $methode === 'POST') {
    require_once $cheminControleurs . 'ConnexionController.php';
    traiterConnexion();
}
elseif ($url === '/inscription' && $methode === 'GET') {
    require_once $cheminControleurs . 'InscriptionController.php';
    afficherInscription();
}
elseif ($url === '/inscription' && $methode === 'POST') {
    require_once $cheminControleurs . 'InscriptionController.php';
    traiterFormulaireInscription($_POST);
}
else if ($url === '/profil' && $methode === 'GET') {
    require_once $cheminControleurs . 'ProfilController.php';
    afficherProfil();
}
else if ($url === '/deconnexion' && $methode === 'GET') {
    require_once $cheminControleurs . 'ConnexionController.php';
    afficherDeconnexion();
}
else
{
    require_once $cheminControleurs . 'ErreurController.php';
    afficherErreur404();
}

?>
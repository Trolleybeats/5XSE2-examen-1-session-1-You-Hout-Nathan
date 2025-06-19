<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'utilisateurModel.php';
require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'gestionVue.php';
require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'gestionSession.php';

function obtenirInfosPage(): array
{
    return [
        'titre' => 'Inscription',
        'description' => 'Bienvenue sur la page d\'inscription du site.'
    ];
}


function afficherInscription()
{
    
    $args = obtenirInfosPage();

    // Récupération des erreurs s'il y en a eu
    $args['erreurs'] = $_SESSION['erreurs'] ?? null;
    unset($_SESSION['erreurs']);

    // Récupération des valeurs pré-remplies
    $args['valeurs'] = $_SESSION['valeurs'] ?? [];
    unset($_SESSION['valeurs']);

     $args['csrf_token'] = genererTokenCSRF();

    afficherVue('inscription.php', $args);
}

function traiterFormulaireInscription(array $post)
{

    if (!isset($post['csrf_token']) || !verifierTokenCSRF($post['csrf_token'])) {
    $_SESSION['erreurs'] = ['global' => "Jeton CSRF invalide ou expiré."];
    header("Location: /inscription", true, 303);
    exit();
}

    $erreurs = [];
    $valeurs = [];

    // Nettoyage des champs
    $pseudo = trim($post['inscription_pseudo'] ?? '');
    $email = trim($post['inscription_email'] ?? '');
    $motDePasse = trim($post['inscription_motDePasse'] ?? '');
    $motDePasseConfirmation = trim($post['inscription_motDePasse_confirmation'] ?? '');

    // Validation du pseudo
    if ($pseudo === '') {
        $erreurs['pseudo'] = "<p>Le pseudo est requis !</p>";
    } elseif (mb_strlen($pseudo) < 2 || mb_strlen($pseudo) > 255) {
        $erreurs['pseudo'] = "<p>Le pseudo doit contenir entre 2 et 255 caractères !</p>";
    } elseif (pseudoExiste($pseudo)) {
        $erreurs['pseudo'] = "<p>Ce pseudo est déjà utilisé !</p>";
    }

    // Validation de l'email
    if ($email === '') {
        $erreurs['email'] = "<p>L'email est requis !</p>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs['email'] = "<p>Adresse email invalide !</p>";
    } elseif (emailExiste($email)) {
        $erreurs['email'] = "<p>Cette adresse email est déjà utilisée !</p>";
    }

    // Validation des mots de passe
    if ($motDePasse === '' || $motDePasseConfirmation === '') {
        $erreurs['motDePasse'] = "<p>Le mot de passe et sa confirmation sont requis !</p>";
    } elseif ($motDePasse !== $motDePasseConfirmation) {
        $erreurs['motDePasse'] = "<p>Les mots de passe ne correspondent pas !</p>";
    } elseif (mb_strlen($motDePasse) < 8 || mb_strlen($motDePasse) > 72) {
        $erreurs['motDePasse'] = "<p>Le mot de passe doit contenir entre 8 et 72 caractères !</p>";
    }

    // Stockage des valeurs échappées pour le retour en formulaire
    $valeurs = [
        'pseudo' => htmlspecialchars($pseudo),
        'email' => htmlspecialchars($email),
    ];

    // S'il y a des erreurs, les stocker en session + valeurs
    if (!empty($erreurs)) {
        $_SESSION['erreurs'] = $erreurs;
        $_SESSION['valeurs'] = $valeurs;

        header("Location: /inscription", true, 303);
    exit();
    } else {
        // Tout est bon, insertion
        $hash = password_hash($motDePasse, PASSWORD_DEFAULT);
        $insertionOK = insererNouvelUtilisateur($pseudo, $email, $hash);

        if ($insertionOK) {
            // Inscription réussie, on redirige vers page de connexion (ou accueil)
            $_SESSION['message'] = "Inscription réussie, vous pouvez vous connecter.";
            header("Location: /connexion", true, 303);
            exit;
        } else {
            $_SESSION['erreurs'] = ['global' => "Erreur lors de l'insertion en base."];
            $_SESSION['valeurs'] = $valeurs;
            header("Location: /inscription", true, 303);
        exit();
        }
    }
}



?>

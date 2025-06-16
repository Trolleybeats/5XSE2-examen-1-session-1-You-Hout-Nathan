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
    $args = obtenirInfosPage('contact');

    // Toujours initialiser les erreurs, même si vide (pour affichage succès)
    if (isset($_SESSION['erreurs'])) {
        $args['erreurs'] = $_SESSION['erreurs'];
        unset($_SESSION['erreurs']);
    } else {
        $args['erreurs'] = null; // ou [] si tu préfères
    }

    // Même logique pour les entrées utilisateur
    if (isset($_SESSION['entreesUtilisateur'])) {
        $args['entreesUtilisateur'] = $_SESSION['entreesUtilisateur'];
        unset($_SESSION['entreesUtilisateur']);
    } else {
        $args['entreesUtilisateur'] = [];
    }

    afficherVue('contact.php', $args);
}




function traiterContactForm($post) {

    $erreurs = [];
    $entreesUtilisateur = [];

    // Nettoyage des entrées
    $nom = trim($post['nom'] ?? '');
    $prenom = trim($post['prenom'] ?? '');
    $email = trim($post['email'] ?? '');
    $message = trim($post['message'] ?? '');

    // Validation
    if ($nom === '') {
        $erreurs['nom'] = "Le nom est requis.";
    } elseif (mb_strlen($nom) < 2 || mb_strlen($nom) > 50) {
        $erreurs['nom'] = "Le nom doit contenir entre 2 et 50 caractères.";
    }

    if ($prenom === '') {
        $erreurs['prenom'] = "Le prénom est requis.";
    } elseif (mb_strlen($prenom) < 2 || mb_strlen($prenom) > 50) {
        $erreurs['prenom'] = "Le prénom doit contenir entre 2 et 50 caractères.";
    }

    if ($email === '') {
        $erreurs['email'] = "L'email est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs['email'] = "L'email n'est pas valide.";
    }

    if ($message === '') {
        $erreurs['message'] = "Le message est requis.";
    } elseif (mb_strlen($message) < 10 || mb_strlen($message) > 3000) {
        $erreurs['message'] = "Le message doit contenir entre 10 et 3000 caractères.";
    }

    // Stockage des données échappées
    $entreesUtilisateur = [
    'nom' => $nom,
    'prenom' => $prenom,
    'email' => $email,
    'message' => $message,
];


     if (!empty($erreurs)) {
        $_SESSION['erreurs'] = $erreurs;
        $_SESSION['entreesUtilisateur'] = $entreesUtilisateur;
    } else {
        // ✅ Ici tu pourras envoyer l’email plus tard
        // mail(...);
        $_SESSION['erreurs'] = []; // utile pour détecter succès dans la vue
    }

    // Redirection PRG
    header("Location: " . $_SERVER['REQUEST_URI'], true, 303);
    exit();
}
?>
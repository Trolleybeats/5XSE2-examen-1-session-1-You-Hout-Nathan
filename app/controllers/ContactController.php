<?php

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'gestionVue.php';

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
    // Envoi de l’email si validation réussie
    $ok = envoyerCourrielFormContact($post);

    // Enregistre un message de succès ou une erreur d'envoi
    if ($ok) {
        $_SESSION['erreurs'] = []; // succès = erreurs vides
    } else {
        $_SESSION['erreurs'] = ['global' => "L'envoi du courriel a échoué. Veuillez réessayer plus tard."];
        $_SESSION['entreesUtilisateur'] = $entreesUtilisateur;
    }
}


    // Redirection PRG
    header("Location: " . $_SERVER['REQUEST_URI'], true, 303);
    exit();
}

function envoyerCourrielFormContact(array $donnees): bool
{
    $expediteur = "Page Contact <forum@framework.be>";
    $destinataire = "nathan.yh@hotmail.com";
    $sujet = "Projet Framework - Formulaire de contact";

    $entetes = [
        "From: " . $expediteur,
        "Reply-To: " . $donnees['email'],
        "MIME-Version: 1.0",
        "Content-Type: text/html; charset=UTF-8",
        "Content-Transfer-Encoding: quoted-printable"
    ];

    // Sécurisation des données utilisateur
    $nom = htmlspecialchars(trim($donnees['nom'] ?? ''));
    $prenom = htmlspecialchars(trim($donnees['prenom'] ?? ''));
    $email = htmlspecialchars(trim($donnees['email'] ?? ''));
    $messageTexte = nl2br(htmlspecialchars(trim($donnees['message'] ?? '')));

    // Composition du message HTML
    ob_start();
    ?>
    <html>
        <body>
            <h2>Message depuis le formulaire de contact</h2>
            <ul>
                <li><strong>Nom :</strong> <?= $nom ?></li>
                <li><strong>Prénom :</strong> <?= $prenom ?></li>
                <li><strong>Email :</strong> <?= $email ?></li>
                <li><strong>Message :</strong><br><?= $messageTexte ?></li>
            </ul>
        </body>
    </html>
    <?php
    $messageHTML = ob_get_clean();
    $messageHTML = quoted_printable_encode($messageHTML);

    // Envoi
    return mail($destinataire, $sujet, $messageHTML, implode("\r\n", $entetes));
}

?>
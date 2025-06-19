<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'CommentaireModel.php';
require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'gestionVue.php';
require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'gestionSession.php';

function obtenirInfosPage(): array
{
    return [
        'titre' => 'Accueil',
        'description' => 'Bienvenue sur la page d\'accueil du site.'
    ];
}

function afficherAccueil()
{
    $args = obtenirInfosPage();

    $args['erreurs'] = $_SESSION['erreurs'] ?? [];
    $args['entreesUtilisateur'] = $_SESSION['entreesUtilisateur'] ?? [];
    $args['commentaires'] = recupererCommentaires();

    unset($_SESSION['erreurs'], $_SESSION['entreesUtilisateur']);
    
    $args['csrf_token'] = genererTokenCSRF();
    
    afficherVue('accueil.php', $args);
}

function traiterCommentaireForm() {
    // Vérifier que l'utilisateur est connecté
    if (!isset($_SESSION['utilisateurId'])) {
        $_SESSION['erreurs']['global'] = "Vous devez être connecté pour publier un commentaire.";
        header('Location: /', true, 303);
        exit;
    }

     if (!isset($_POST['csrf_token']) || !verifierTokenCSRF($_POST['csrf_token'])) {
        $_SESSION['erreurs']['global'] = "Jeton CSRF invalide ou expiré.";
        $_SESSION['entreesUtilisateur']['contenu'] = $_POST['contenu'] ?? '';
        header('Location: /');
        exit;
    }

    $contenu = trim($_POST['contenu'] ?? '');
    $_SESSION['entreesUtilisateur']['contenu'] = $contenu;
    $erreurs = [];

    // Validation
    if ($contenu === '') {
        $erreurs['contenu'] = "Le champ commentaire est requis.";
    } elseif (strlen($contenu) < 10) {
        $erreurs['contenu'] = "Le commentaire doit contenir au moins 10 caractères.";
    } elseif (strlen($contenu) > 3000) {
        $erreurs['contenu'] = "Le commentaire ne peut pas dépasser 3000 caractères.";
    }

    if (!empty($erreurs)) {
        $_SESSION['erreurs'] = $erreurs;
        header("Location: /", true, 303); // Redirection PRG
        exit;
    }

    // Ajout en base
    ajouterCommentaire($contenu);

    // Nettoyer les anciennes valeurs
    unset($_SESSION['entreesUtilisateur']);
    $_SESSION['message_succes'] = "Votre commentaire a été publié avec succès.";
    header("Location: /", true, 303); // PRG
    exit;
}

function traiterSuppressionCommentaire() {
    if (!isset($_SESSION['utilisateurId'])) {
        header("Location: /connexion", true, 303);
        exit;
    }

    $id = intval($_POST['commentaire_id'] ?? 0);
    supprimerCommentaireParId($id, $_SESSION['utilisateurId']);
    header("Location: /", true, 303);
    exit;
}

function traiterModificationCommentaire() {
    if (!isset($_SESSION['utilisateurId'])) {
        header("Location: /connexion", true, 303);
        exit;
    }

    $id = intval($_POST['commentaire_id'] ?? 0);
    $contenu = trim($_POST['nouveau_contenu'] ?? '');

    if (strlen($contenu) >= 10 && strlen($contenu) <= 3000) {
        modifierCommentaireParId($id, $_SESSION['utilisateurId'], $contenu);
    }

    header("Location: /", true, 303);
    exit;
}


?>
<?php

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'gestionErreur.php';
require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'gestionBdd.php';

//Connexion

function connecterUtilisateur($pseudo, $mot_de_passe){
    $pdo=obtenirConnexionBdd();

try{
$stmt = $pdo->prepare("SELECT uti_id, uti_motdepasse FROM t_utilisateur_uti WHERE uti_pseudo = :pseudo");
$stmt->bindParam(':pseudo', $pseudo);

        $stmt->execute();

        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($utilisateur && password_verify($mot_de_passe, $utilisateur['uti_motdepasse'])) {
            
             session_regenerate_id(true);
            // Connexion réussie : on enregistre l'ID de l'utilisateur en session
            $_SESSION['utilisateurId'] = $utilisateur['uti_id'];
        return true;
        } else {
            // Connexion échouée : identifiants incorrects
            return false;
        }

    } catch (PDOException $e) {
        gererExceptions($e);
    return false;
} finally {
    // Libérer la connexion
    $pdo = null;
}
}

//Inscription

// Vérifie si un pseudo est déjà utilisé
function pseudoExiste(string $pseudo): bool {
    $pdo = obtenirConnexionBdd();
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM t_utilisateur_uti WHERE uti_pseudo = ?");
        $stmt->execute([$pseudo]);
        return $stmt->fetchColumn() > 0;
    } catch (PDOException $e) {
        gererExceptions($e);
        return false;
    } finally {
        $pdo = null;
    }
}

// Vérifie si un email est déjà utilisé
function emailExiste(string $email): bool {
    $pdo = obtenirConnexionBdd();
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM t_utilisateur_uti WHERE uti_email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    } catch (PDOException $e) {
        gererExceptions($e);
        return false;
    } finally {
        $pdo = null;
    }
}

// Insère un nouvel utilisateur
function insererNouvelUtilisateur(string $pseudo, string $email, string $motDePasseHash): bool {
    $pdo = obtenirConnexionBdd();
    try {
        $stmt = $pdo->prepare("INSERT INTO t_utilisateur_uti (uti_pseudo, uti_email, uti_motdepasse) VALUES (?, ?, ?)");
        return $stmt->execute([$pseudo, $email, $motDePasseHash]);
    } catch (PDOException $e) {
        gererExceptions($e);
        return false;
    } finally {
        $pdo = null;
    }
}

// Page Profil

function obtenirUtilisateurParId(int $id): ?array {
    $pdo = obtenirConnexionBdd();
    try {
        $stmt = $pdo->prepare("SELECT uti_pseudo, uti_email FROM t_utilisateur_uti WHERE uti_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        gererExceptions($e);
        return null;
    } finally {
        $pdo = null;
    }
}

?>
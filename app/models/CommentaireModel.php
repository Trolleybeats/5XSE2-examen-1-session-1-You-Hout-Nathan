<?php
require_once dirname(__DIR__, 2) . '/core/gestionBdd.php';
require_once dirname(__DIR__, 2) . '/core/gestionErreur.php';

function recupererCommentaires(): array {
    $pdo = obtenirConnexionBdd();
    try {
        $sql = "SELECT c.*, u.uti_pseudo
                FROM t_commentaires_com c
                JOIN t_utilisateur_uti u ON c.id_utilisateur = u.uti_id
                ORDER BY c.date_creation DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        gererExceptions($e);
        return [];
    } finally {
        $pdo = null;
    }
}



function ajouterCommentaire(string $contenu): bool {
    $pdo = obtenirConnexionBdd();
    try {
        $sql = "INSERT INTO t_commentaires_com (contenu, date_creation, id_utilisateur)
                VALUES (:contenu, NOW(), :id_utilisateur)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':contenu' => $contenu,
            ':id_utilisateur' => $_SESSION['utilisateurId']
        ]);
    } catch (PDOException $e) {
        gererExceptions($e);
        return false;
    } finally {
        $pdo = null;
    }
}

function supprimerCommentaireParId(int $id, int $idUtilisateur): bool {
    $pdo = obtenirConnexionBdd();
    try {
        $sql = "DELETE FROM t_commentaires_com WHERE id = :id AND id_utilisateur = :id_utilisateur";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':id' => $id, ':id_utilisateur' => $idUtilisateur]);
    } catch (PDOException $e) {
        gererExceptions($e);
        return false;
    } finally {
        $pdo = null;
    }
}

function modifierCommentaireParId(int $id, int $idUtilisateur, string $contenu): bool {
    $pdo = obtenirConnexionBdd();
    try {
        $sql = "UPDATE t_commentaires_com SET contenu = :contenu WHERE id = :id AND id_utilisateur = :id_utilisateur";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':contenu' => $contenu,
            ':id' => $id,
            ':id_utilisateur' => $idUtilisateur
        ]);
    } catch (PDOException $e) {
        gererExceptions($e);
        return false;
    } finally {
        $pdo = null;
    }
}


?>

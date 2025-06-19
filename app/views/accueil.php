<?php
if (isset($erreurs)) {
    if (!empty($erreurs)) {
        echo "<p style='color: red;'>Une ou plusieurs erreurs sont survenues. Veuillez corriger les champs indiqués.</p>";
    }
}
?>

<h1><?= htmlspecialchars($args['titre']) ?></h1>

<?php if (isset($_SESSION['utilisateurId'])): ?>

    <!-- Formulaire de commentaire -->
    <form method="POST" action="/">
        <label for="contenu">Votre commentaire :</label><br>
        <textarea name="contenu" id="contenu" required minlength="10" maxlength="3000"><?= htmlspecialchars($args['entreesUtilisateur']['contenu'] ?? '') ?></textarea><br>
        <?php if (!empty($args['erreurs']['contenu'])): ?>
            <p class="erreur"><?= htmlspecialchars($args['erreurs']['contenu']) ?></p>
        <?php endif; ?>

         <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($args['csrf_token']) ?>">
    

        <button type="submit">Envoyer</button>
    </form>
<?php else: ?>
    <p>Vous devez <a href="/connexion">vous connecter</a> pour écrire un commentaire.</p>
<?php endif; ?>


<?php foreach ($args['commentaires'] as $commentaire): ?>
    <div class="commentaire">
        <p><strong><?= htmlspecialchars($commentaire['uti_pseudo']) ?></strong> a écrit :</p>
        <p class="commentaire"><?= nl2br(htmlspecialchars($commentaire['contenu'])) ?></p>
        <p><small>Posté le <?= $commentaire['date_creation'] ?></small></p>

        <?php if (isset($_SESSION['utilisateurId']) && $_SESSION['utilisateurId'] == $commentaire['id_utilisateur']): ?>
            <!-- Formulaire de suppression -->
            <form method="POST" action="/commentaire/supprimer" onsubmit="return confirm('Supprimer ce commentaire ?');">
                <input type="hidden" name="commentaire_id" value="<?= $commentaire['id'] ?>">
                 <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($args['csrf_token']) ?>">
                <button type="submit">Supprimer</button>
            </form>

            <!-- Formulaire de modification -->
            <form method="POST" action="/commentaire/modifier">
                <input type="hidden" name="commentaire_id" value="<?= $commentaire['id'] ?>">
                 <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($args['csrf_token']) ?>">
                <textarea name="nouveau_contenu" required minlength="10" maxlength="3000"><?= htmlspecialchars($commentaire['contenu']) ?></textarea>
                <button type="submit">Modifier</button>
            </form>
        <?php endif; ?>
    </div>
<?php endforeach; ?>



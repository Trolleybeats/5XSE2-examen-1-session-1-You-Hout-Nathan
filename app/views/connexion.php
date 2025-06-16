<h1>Connexion</h1>

<?php if (!empty($erreur)) : ?>
    <p style="color: red;"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>

<form method="post" action="/connexion">
    <div class="form-group">
        <label for="connexion_pseudo">Votre pseudo :</label>
        <input name="connexion_pseudo" id="connexion_pseudo" type="text"
               value="<?= htmlspecialchars($pseudo ?? '') ?>"
               minlength="2" maxlength="255" required>

        <label for="connexion_motDePasse">Votre mot de passe :</label>
        <input name="connexion_motDePasse" id="connexion_motDePasse" type="password"
               value="" minlength="8" maxlength="72" required>

        <button type="submit">Se connecter</button>
    </div>
</form>

<p><a href="<?= BASE_URL ?>/inscription">Inscrivez-vous</a></p>


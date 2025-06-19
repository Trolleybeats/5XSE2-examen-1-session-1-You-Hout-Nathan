<?php
if (isset($erreurs)) {
    if (!empty($erreurs)) {
        echo "<p style='color: red;'>Une ou plusieurs erreurs sont survenues. Veuillez corriger les champs indiqués.</p>";
    }
}
?>

<h1>Connexion</h1>

<form method="post" action="/connexion">
    <input type="hidden" name="csrf_token" value="<?= genererTokenCSRF() ?>">

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


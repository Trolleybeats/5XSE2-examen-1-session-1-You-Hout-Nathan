<?php
if (isset($erreurs)) {
    if (!empty($erreurs)) {
        echo "<p style='color: red;'>Une ou plusieurs erreurs sont survenues. Veuillez corriger les champs indiqués.</p>";
    }
}
?>

<h1> Inscription </h1>

<form method="post">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(genererTokenCSRF()) ?>">

    <div class="form-group">
        <label for="inscription_pseudo">Votre pseudo :</label>
        <input name="inscription_pseudo" id="inscription_pseudo" type="text"
               value="<?= htmlspecialchars($valeurs['pseudo'] ?? '') ?>"
               minlength="2" maxlength="255" required>
        <?php 
        if (isset($erreurs['pseudo'])) {
            echo $erreurs['pseudo'];
        }
        ?>

        <label for="inscription_email">Votre email :</label>
        <input name="inscription_email" id="inscription_email" type="email"
               value="<?= htmlspecialchars($valeurs['email'] ?? '') ?>"
               required>
        <?php 
        if (isset($erreurs['email'])) {
            echo $erreurs['email'];
        }
        ?>

        <label for="inscription_motDePasse">Votre mot de passe :</label>
        <input name="inscription_motDePasse" id="inscription_motDePasse" type="password"
               value="" minlength="8" maxlength="72" required>
        <?php 
        if (isset($erreurs['motDePasse'])) {
            echo $erreurs['motDePasse'];
        }
        ?>

        <label for="inscription_motDePasse_confirmation">Confirmez votre mot de passe :</label>
        <input name="inscription_motDePasse_confirmation" id="inscription_motDePasse_confirmation"
               type="password" value="" minlength="8" maxlength="72" required>
        <?php 
        if (isset($erreurs['motDePasse'])) {
            echo $erreurs['motDePasse'];
        }
        ?>

        <button type="submit">Envoyer</button>
    </div>
</form>

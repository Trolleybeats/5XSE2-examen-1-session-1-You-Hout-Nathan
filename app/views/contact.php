<h1>Contact</h1>

<?php
if (isset($erreurs)) {
    if (empty($erreurs)) {
        echo "<p style='color: green;'>Votre message a été envoyé avec succès !</p>";
    } elseif (!empty($erreurs['global'])) {
        echo "<p style='color: red;'>{$erreurs['global']}</p>";
    } else {
        echo "<p style='color: red;'>Une ou plusieurs erreurs sont survenues. Veuillez corriger les champs indiqués.</p>";
    }
}

// Raccourcis pour éviter répétition
$entrees = $entreesUtilisateur ?? [];
$erreurs = $erreurs ?? [];
?>

<form method="post">
    <div class="form-group">

        <!-- Champ nom -->
        <label for="nom">Votre nom :</label>
        <input name="nom" id="nom" type="text"
               value="<?= htmlspecialchars($entrees['nom'] ?? '') ?>"
               minlength="2" maxlength="50" required>
        <?= $erreurs['nom'] ?? '' ?>

        <!-- Champ prénom -->
        <label for="prenom">Votre prénom :</label>
        <input name="prenom" id="prenom" type="text"
               value="<?= htmlspecialchars($entrees['prenom'] ?? '') ?>"
               maxlength="255">

        <!-- Champ email -->
        <label for="email">Votre email :</label>
        <input name="email" id="email" type="email"
               value="<?= htmlspecialchars($entrees['email'] ?? '') ?>" required>
        <?= $erreurs['email'] ?? '' ?>

        <!-- Champ message -->
        <label for="message">Message :</label>
        <textarea name="message" id="message"
                  minlength="10" maxlength="3000" required><?= htmlspecialchars($entrees['message'] ?? '') ?></textarea>
        <?= $erreurs['message'] ?? '' ?>

        <!-- Bouton envoyer -->
        <button type="submit">Envoyer</button>

    </div>
</form>

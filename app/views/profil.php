<h1>Profil</h1>

<p><strong>Pseudo :</strong> <?= htmlspecialchars($utilisateur['uti_pseudo']) ?></p>
<p><strong>Email :</strong> <?= htmlspecialchars($utilisateur['uti_email']) ?></p>

<?php if (estConnecte()) : ?>
    <a href="/deconnexion">Déconnexion</a>
<?php else : ?>
    <a href="/connexion">Connexion</a>
<?php endif; ?>

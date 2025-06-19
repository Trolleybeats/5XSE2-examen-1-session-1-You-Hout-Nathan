
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title><?= $args['titre'] ?? 'Titre par défaut' ?></title>
    <meta name="description" content="<?= $args['description'] ?? '' ?>">
    <meta name="author" content="Nathan You-Hout">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/reset.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
</head>
<body>
    <header>
        <nav>
    <?php

require_once 'navigation.php';


genererMenu([
    'Accueil' => '/',
    'Contact' => '/contact',
    'Connexion' => '/connexion',
    'Profil' => '/profil'
]);
?>
        </nav>
    </header>
    <main>
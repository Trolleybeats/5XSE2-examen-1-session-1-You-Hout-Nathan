<?php

function initialiserSession(){
    if (session_status() === PHP_SESSION_NONE)
    {
        ini_set('session.use_strict_mode', 1);
        ini_set('session.use_only_cookies', 1);

        // En local sans HTTPS, 'secure' => false
        $secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';

        if (!isset($_COOKIE[session_name()]))
        {
            session_set_cookie_params([
                'secure' => $secure,
                'httponly' => true,
                'samesite' => 'lax'
            ]);
        }

        session_start();
    }
}


function estConnecte() {

    return isset($_SESSION['utilisateurId']);
}


function deconnecterUtilisateur() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Supprimer la variable de session spécifique à l'utilisateur
    unset($_SESSION['utilisateurId']);

    if (ini_get("session.use_cookies"))
{
    $params = session_get_cookie_params();

    setcookie(
        session_name(),     // Exemple : "PHPSESSID"
        '',                 // Valeur vide
        [
            'expires' => time() - 3600,
            'path' => $params['path'],
            'domain' => $params['domain']
        ]
    );
}

    session_destroy();
}

function genererTokenCSRF(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifierTokenCSRF($token) {
    $valide = isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    if ($valide) {
        unset($_SESSION['csrf_token']); 
    }
    return $valide;
}



?>
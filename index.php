<?php
/**
 * VIVORA – Routeur principal
 * Point d'entrée unique de l'application.
 * Dispatche les requêtes vers le bon contrôleur et la bonne action
 * selon les paramètres GET : index.php?controller=X&action=Y
 *
 * Exemple : index.php?controller=lieu&action=list
 */

// ── Constante BASE_URL (chemin de base du projet sous XAMPP) ─
// Adapter si le dossier du projet s'appelle autrement.
define('BASE_URL', '/PROJET WEB1/');

// ── Démarrage de session (pour messages flash, etc.) ─────────
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ── Chargement automatique des contrôleurs ───────────────────
spl_autoload_register(function (string $classe): void {
    $fichier = __DIR__ . '/controllers/' . $classe . '.php';
    if (file_exists($fichier)) {
        require_once $fichier;
    }
});

// Chargement manuel des modèles (pas de namespace)
require_once __DIR__ . '/models/Lieu.php';
require_once __DIR__ . '/models/Evenement.php';

// ── Lecture et nettoyage des paramètres GET ──────────────────
// On accepte uniquement les lettres, chiffres et tirets bas pour éviter toute injection
$controller = isset($_GET['controller']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['controller']) : 'lieu';
$action     = isset($_GET['action'])     ? preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['action'])     : 'list';

// ── Tableau de routage : contrôleur => [actions autorisées] ──
$routes = [
    'lieu' => [
        'list'        => 'LieuController',
        'show'        => 'LieuController',
        'adminList'   => 'LieuController',
        'adminCreate' => 'LieuController',
        'adminEdit'   => 'LieuController',
        'adminDelete' => 'LieuController',
    ],
    'evenement' => [
        'list'               => 'EvenementController',
        'show'               => 'EvenementController',
        'inscription'        => 'EvenementController',
        'adminDashboard'     => 'EvenementController',
        'adminList'          => 'EvenementController',
        'adminCreate'        => 'EvenementController',
        'adminEdit'          => 'EvenementController',
        'adminDelete'        => 'EvenementController',
        'adminParticipants'  => 'EvenementController',
    ],
];

// ── Dispatch de la requête ────────────────────────────────────
if (isset($routes[$controller][$action])) {
    $classeControleur = $routes[$controller][$action];

    // Chargement du fichier contrôleur si l'autoload ne l'a pas fait
    $fichierControleur = __DIR__ . '/controllers/' . $classeControleur . '.php';
    if (!class_exists($classeControleur) && file_exists($fichierControleur)) {
        require_once $fichierControleur;
    }

    // Vérification que la classe et la méthode existent
    if (class_exists($classeControleur) && method_exists($classeControleur, $action)) {
        $objet = new $classeControleur();
        $objet->$action();
    } else {
        // Méthode introuvable
        http_response_code(500);
        die('Erreur interne : contrôleur ou action invalide.');
    }
} else {
    // Route inconnue → page 404
    http_response_code(404);
    echo '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page introuvable – Vivora</title>
    <style>
        body { font-family: sans-serif; text-align: center; padding: 60px; background: #F6F4EE; color: #123B3A; }
        h1   { color: #E07A5F; }
        a    { color: #1F7A72; }
    </style>
</head>
<body>
    <h1>404 – Page introuvable</h1>
    <p>La page que vous cherchez n\'existe pas.</p>
    <a href="index.php?controller=lieu&action=list">← Retour à l\'accueil</a>
</body>
</html>';
}

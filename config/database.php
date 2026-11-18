<?php
/**
 * VIVORA – Configuration de la base de données
 * Connexion PDO via le patron de conception Singleton :
 * une seule instance de connexion pour toute l'application.
 *
 * Usage dans un contrôleur :
 *   $pdo = Database::getInstance()->getConnection();
 */

class Database
{
    // ── Paramètres de connexion ──────────────────────────────
    private const DB_HOST    = 'localhost';
    private const DB_NAME    = 'vivora_db';
    private const DB_USER    = 'root';       // Modifier si nécessaire
    private const DB_PASS    = '';           // Modifier si nécessaire
    private const DB_CHARSET = 'utf8mb4';

    // ── Instance unique (Singleton) ──────────────────────────
    private static ?Database $instance = null;

    // ── Objet de connexion PDO ───────────────────────────────
    private PDO $connexion;

    /**
     * Constructeur privé : empêche l'instanciation directe.
     * Crée la connexion PDO et configure les options.
     */
    private function __construct()
    {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            self::DB_HOST,
            self::DB_NAME,
            self::DB_CHARSET
        );

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lance des exceptions en cas d'erreur SQL
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Résultats en tableaux associatifs
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Requêtes préparées natives
        ];

        try {
            $this->connexion = new PDO($dsn, self::DB_USER, self::DB_PASS, $options);
        } catch (PDOException $e) {
            // En production, ne jamais afficher les détails de l'erreur
            error_log('Erreur de connexion à la base de données : ' . $e->getMessage());
            die('Connexion à la base de données impossible. Veuillez contacter l\'administrateur.');
        }
    }

    /**
     * Retourne l'instance unique de la classe (crée si elle n'existe pas).
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Retourne l'objet PDO pour exécuter des requêtes.
     */
    public function getConnection(): PDO
    {
        return $this->connexion;
    }

    // ── Blocage du clonage et de la désérialisation ──────────
    private function __clone() {}
    public function __wakeup(): void
    {
        throw new \Exception('Désérialisation du Singleton interdite.');
    }
}

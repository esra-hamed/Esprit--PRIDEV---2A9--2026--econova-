<?php
/**
 * VIVORA – Contrôleur Evenement
 * Gère toutes les actions liées aux événements : front office et back office.
 * Squelettes prêts pour l'intégration CRUD.
 */

// Chargement des dépendances
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Lieu.php';
require_once __DIR__ . '/../models/Evenement.php';

class EvenementController
{
    // ── Instance PDO ─────────────────────────────────────────
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    // ================================================================
    // FRONT OFFICE
    // ================================================================

    /**
     * Action : list
     * Affiche la liste de tous les événements à venir.
     * URL : index.php?controller=evenement&action=list
     */
    public function list(): void
    {
        // TODO (étape CRUD) : récupérer les événements depuis la base (avec jointure lieu)
        $evenements = [];

        require __DIR__ . '/../views/front/evenements/liste.php';
    }

    /**
     * Action : show
     * Affiche le détail d'un événement.
     * URL : index.php?controller=evenement&action=show&id=1
     */
    public function show(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        // TODO (étape CRUD) : récupérer l'événement et le lieu associé
        $evenement = null;

        require __DIR__ . '/../views/front/evenements/detail.php';
    }

    /**
     * Action : inscription
     * Affiche le formulaire d'inscription à un événement.
     * URL : index.php?controller=evenement&action=inscription&id=1
     */
    public function inscription(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        // TODO (étape CRUD) : récupérer l'événement pour afficher le contexte
        $evenement = null;
        $erreurs   = [];
        $succes    = false;

        // Traitement du formulaire si soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // TODO (étape CRUD) : valider et enregistrer l'inscription
        }

        require __DIR__ . '/../views/front/evenements/inscription.php';
    }

    // ================================================================
    // BACK OFFICE
    // ================================================================

    /**
     * Action : adminDashboard
     * Affiche le tableau de bord du module (statistiques).
     * URL : index.php?controller=evenement&action=adminDashboard
     */
    public function adminDashboard(): void
    {
        // TODO (étape CRUD) : calculer les statistiques depuis la base
        $stats = [
            'nb_lieux'            => 0,
            'nb_evenements'       => 0,
            'evenements_a_venir'  => 0,
            'lieux_accessibles'   => 0, // Lieux avec les 4 critères cochés
        ];

        require __DIR__ . '/../views/back/dashboard.php';
    }

    /**
     * Action : adminList
     * Tableau de gestion des événements (avec nom du lieu via jointure).
     * URL : index.php?controller=evenement&action=adminList
     */
    public function adminList(): void
    {
        // TODO (étape CRUD) : requête SELECT avec JOIN sur lieu
        $evenements = [];

        require __DIR__ . '/../views/back/evenements/liste.php';
    }

    /**
     * Action : adminCreate
     * Formulaire d'ajout d'un événement.
     * URL : index.php?controller=evenement&action=adminCreate
     */
    public function adminCreate(): void
    {
        // TODO (étape CRUD) : récupérer la liste des lieux pour le <select>
        $lieux     = [];
        $evenement = new Evenement();
        $action    = 'create';

        require __DIR__ . '/../views/back/evenements/formulaire.php';
    }

    /**
     * Action : adminEdit
     * Formulaire de modification d'un événement existant.
     * URL : index.php?controller=evenement&action=adminEdit&id=1
     */
    public function adminEdit(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        // TODO (étape CRUD) : récupérer l'événement et la liste des lieux
        $evenement = new Evenement(['id' => $id]);
        $lieux     = [];
        $action    = 'edit';

        require __DIR__ . '/../views/back/evenements/formulaire.php';
    }

    /**
     * Action : adminDelete
     * Supprime un événement.
     * URL : index.php?controller=evenement&action=adminDelete&id=1
     */
    public function adminDelete(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        // TODO (étape CRUD) : supprimer l'événement de la base

        header('Location: index.php?controller=evenement&action=adminList&message=deleted');
        exit;
    }

    /**
     * Action : adminParticipants
     * Affiche la liste des participants inscrits à un événement.
     * URL : index.php?controller=evenement&action=adminParticipants&id=1
     */
    public function adminParticipants(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        // TODO (étape CRUD) : récupérer les participants et l'événement
        $evenement    = null;
        $participants = [];

        require __DIR__ . '/../views/back/evenements/participants.php';
    }
}

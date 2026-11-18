<?php
/**
 * VIVORA – Contrôleur Lieu
 * Gère toutes les actions liées aux lieux : front office et back office.
 * Pour l'instant, ce sont des squelettes qui chargent les vues.
 * La logique CRUD sera ajoutée à l'étape suivante.
 */

// Chargement des dépendances
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Lieu.php';
require_once __DIR__ . '/../models/Evenement.php';

class LieuController
{
    // ── Instance PDO (sera utilisée à l'étape CRUD) ─────────
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
     * Affiche la liste des lieux accessibles avec filtres.
     * URL : index.php?controller=lieu&action=list
     */
    public function list(): void
    {
        // TODO (étape CRUD) : récupérer les lieux depuis la base avec filtres
        $lieux = []; // Tableau vide pour l'instant

        // Chargement de la vue front
        require __DIR__ . '/../views/front/lieux/liste.php';
    }

    /**
     * Action : show
     * Affiche la fiche détaillée d'un lieu et ses événements.
     * URL : index.php?controller=lieu&action=show&id=1
     */
    public function show(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        // TODO (étape CRUD) : récupérer le lieu et ses événements depuis la base
        $lieu       = null;
        $evenements = [];

        require __DIR__ . '/../views/front/lieux/fiche.php';
    }

    // ================================================================
    // BACK OFFICE
    // ================================================================

    /**
     * Action : adminList
     * Affiche le tableau de gestion des lieux (back office).
     * URL : index.php?controller=lieu&action=adminList
     */
    public function adminList(): void
    {
        // TODO (étape CRUD) : récupérer tous les lieux pour le tableau
        $lieux = [];

        require __DIR__ . '/../views/back/lieux/liste.php';
    }

    /**
     * Action : adminCreate
     * Affiche le formulaire d'ajout d'un nouveau lieu.
     * URL : index.php?controller=lieu&action=adminCreate
     */
    public function adminCreate(): void
    {
        $lieu   = new Lieu(); // Objet vide pour le formulaire
        $action = 'create';  // Indique au formulaire qu'il est en mode "création"

        require __DIR__ . '/../views/back/lieux/formulaire.php';
    }

    /**
     * Action : adminEdit
     * Affiche le formulaire de modification d'un lieu existant.
     * URL : index.php?controller=lieu&action=adminEdit&id=1
     */
    public function adminEdit(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        // TODO (étape CRUD) : récupérer le lieu à modifier
        $lieu   = new Lieu(['id' => $id]); // Objet temporaire
        $action = 'edit'; // Indique au formulaire qu'il est en mode "modification"

        require __DIR__ . '/../views/back/lieux/formulaire.php';
    }

    /**
     * Action : adminDelete
     * Supprime un lieu (sera implémenté à l'étape CRUD).
     * URL : index.php?controller=lieu&action=adminDelete&id=1
     */
    public function adminDelete(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        // TODO (étape CRUD) : supprimer le lieu de la base de données

        // Redirection vers la liste après suppression
        header('Location: index.php?controller=lieu&action=adminList&message=deleted');
        exit;
    }
}

<?php
/**
 * VIVORA – Modèle Evenement
 * Représente un événement organisé dans un lieu accessible.
 * Relation N–1 avec Lieu via l'attribut $lieuId.
 * Aucune requête SQL ici.
 */

class Evenement
{
    // ── Attributs privés ────────────────────────────────────
    private ?int    $id;
    private int     $lieuId;           // Clé étrangère vers lieu.id
    private string  $titre;
    private ?string $description;
    private string  $dateEvenement;    // Format : YYYY-MM-DD
    private string  $heure;            // Format : HH:MM:SS
    private int     $nbPlaces;
    private ?string $image;            // Nom du fichier image

    // Attribut de jointure (non stocké en base, rempli par requête JOIN)
    private ?string $nomLieu = null;   // Nom du lieu, pour affichage dans les vues

    // ── Constructeur ────────────────────────────────────────
    /**
     * Crée un objet Evenement à partir des données passées en tableau.
     * Accepte aussi les colonnes issues d'une jointure (ex. nom_lieu).
     *
     * @param array $donnees Tableau associatif des données de l'événement
     */
    public function __construct(array $donnees = [])
    {
        $this->id             = isset($donnees['id'])      ? (int) $donnees['id']       : null;
        $this->lieuId         = isset($donnees['lieu_id']) ? (int) $donnees['lieu_id']  : 0;
        $this->titre          = $donnees['titre']          ?? '';
        $this->description    = $donnees['description']    ?? null;
        $this->dateEvenement  = $donnees['date_evenement'] ?? '';
        $this->heure          = $donnees['heure']          ?? '00:00:00';
        $this->nbPlaces       = isset($donnees['nb_places']) ? (int) $donnees['nb_places'] : 0;
        $this->image          = $donnees['image']          ?? null;
        $this->nomLieu        = $donnees['nom_lieu']       ?? null; // Rempli par JOIN
    }

    // ── Getters ─────────────────────────────────────────────
    public function getId(): ?int             { return $this->id; }
    public function getLieuId(): int          { return $this->lieuId; }
    public function getTitre(): string        { return $this->titre; }
    public function getDescription(): ?string { return $this->description; }
    public function getDateEvenement(): string { return $this->dateEvenement; }
    public function getHeure(): string        { return $this->heure; }
    public function getNbPlaces(): int        { return $this->nbPlaces; }
    public function getImage(): ?string       { return $this->image; }
    public function getNomLieu(): ?string     { return $this->nomLieu; }

    // ── Setters ─────────────────────────────────────────────
    public function setId(?int $id): void               { $this->id = $id; }
    public function setLieuId(int $lieuId): void        { $this->lieuId = $lieuId; }
    public function setTitre(string $titre): void       { $this->titre = htmlspecialchars(strip_tags($titre)); }
    public function setDescription(?string $desc): void { $this->description = $desc; }
    public function setDateEvenement(string $date): void { $this->dateEvenement = $date; }
    public function setHeure(string $heure): void       { $this->heure = $heure; }
    public function setNbPlaces(int $nb): void          { $this->nbPlaces = max(0, $nb); }
    public function setImage(?string $image): void      { $this->image = $image; }
    public function setNomLieu(?string $nom): void      { $this->nomLieu = $nom; }

    // ── Méthodes utilitaires ────────────────────────────────
    /**
     * Retourne la date formatée en français (ex. : "15 janvier 2027").
     */
    public function getDateFormatee(): string
    {
        if (empty($this->dateEvenement)) {
            return '';
        }
        $timestamp = strtotime($this->dateEvenement);
        // Noms des mois en français
        $mois = [
            1  => 'janvier', 2  => 'février',  3  => 'mars',
            4  => 'avril',   5  => 'mai',       6  => 'juin',
            7  => 'juillet', 8  => 'août',      9  => 'septembre',
            10 => 'octobre', 11 => 'novembre', 12 => 'décembre',
        ];
        return date('j', $timestamp) . ' ' . $mois[(int) date('n', $timestamp)] . ' ' . date('Y', $timestamp);
    }

    /**
     * Indique si l'événement est à venir (date >= aujourd'hui).
     */
    public function estAVenir(): bool
    {
        return strtotime($this->dateEvenement) >= strtotime(date('Y-m-d'));
    }

    /**
     * Retourne l'heure au format HH:MM (sans les secondes).
     */
    public function getHeureCourte(): string
    {
        return substr($this->heure, 0, 5);
    }
}

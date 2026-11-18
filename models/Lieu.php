<?php
/**
 * VIVORA – Modèle Lieu
 * Représente un lieu accessible (salle, parc, centre culturel, etc.).
 * Contient uniquement les attributs, le constructeur et les accesseurs (getters/setters).
 * Aucune requête SQL ici : la logique de persistance viendra dans la prochaine étape.
 */

class Lieu
{
    // ── Attributs privés ────────────────────────────────────
    private ?int    $id;
    private string  $nom;
    private string  $ville;
    private string  $adresse;
    private ?string $description;
    private bool    $rampeAcces;       // Rampe d'accès présente
    private bool    $ascenseur;        // Ascenseur présent
    private bool    $toilettesAdaptees; // Toilettes adaptées PMR
    private bool    $parkingPmr;       // Parking réservé PMR
    private ?string $image;            // Nom du fichier image

    // ── Constructeur ────────────────────────────────────────
    /**
     * Crée un objet Lieu à partir des données passées en tableau
     * (par exemple, une ligne retournée par PDO::FETCH_ASSOC).
     *
     * @param array $donnees Tableau associatif des données du lieu
     */
    public function __construct(array $donnees = [])
    {
        $this->id                 = isset($donnees['id']) ? (int) $donnees['id'] : null;
        $this->nom                = $donnees['nom']      ?? '';
        $this->ville              = $donnees['ville']    ?? '';
        $this->adresse            = $donnees['adresse']  ?? '';
        $this->description        = $donnees['description']        ?? null;
        $this->rampeAcces         = (bool) ($donnees['rampe_acces']         ?? false);
        $this->ascenseur          = (bool) ($donnees['ascenseur']           ?? false);
        $this->toilettesAdaptees  = (bool) ($donnees['toilettes_adaptees']  ?? false);
        $this->parkingPmr         = (bool) ($donnees['parking_pmr']         ?? false);
        $this->image              = $donnees['image'] ?? null;
    }

    // ── Getters ─────────────────────────────────────────────
    public function getId(): ?int            { return $this->id; }
    public function getNom(): string         { return $this->nom; }
    public function getVille(): string       { return $this->ville; }
    public function getAdresse(): string     { return $this->adresse; }
    public function getDescription(): ?string { return $this->description; }
    public function hasRampeAcces(): bool    { return $this->rampeAcces; }
    public function hasAscenseur(): bool     { return $this->ascenseur; }
    public function hasToilettesAdaptees(): bool { return $this->toilettesAdaptees; }
    public function hasParkingPmr(): bool    { return $this->parkingPmr; }
    public function getImage(): ?string      { return $this->image; }

    // ── Setters ─────────────────────────────────────────────
    public function setId(?int $id): void               { $this->id = $id; }
    public function setNom(string $nom): void           { $this->nom = htmlspecialchars(strip_tags($nom)); }
    public function setVille(string $ville): void       { $this->ville = htmlspecialchars(strip_tags($ville)); }
    public function setAdresse(string $adresse): void   { $this->adresse = htmlspecialchars(strip_tags($adresse)); }
    public function setDescription(?string $desc): void { $this->description = $desc; }
    public function setRampeAcces(bool $val): void      { $this->rampeAcces = $val; }
    public function setAscenseur(bool $val): void       { $this->ascenseur = $val; }
    public function setToilettesAdaptees(bool $val): void { $this->toilettesAdaptees = $val; }
    public function setParkingPmr(bool $val): void      { $this->parkingPmr = $val; }
    public function setImage(?string $image): void      { $this->image = $image; }

    // ── Méthode utilitaire ──────────────────────────────────
    /**
     * Retourne le nombre de critères d'accessibilité satisfaits (0 à 4).
     * Utile pour afficher un score ou filtrer les lieux "100 % accessibles".
     */
    public function getNombreCriteres(): int
    {
        return (int) $this->rampeAcces
             + (int) $this->ascenseur
             + (int) $this->toilettesAdaptees
             + (int) $this->parkingPmr;
    }

    /**
     * Indique si le lieu est 100 % accessible (tous les critères cochés).
     */
    public function estTotalementAccessible(): bool
    {
        return $this->getNombreCriteres() === 4;
    }
}

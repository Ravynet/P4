<?php

/**
 * Class Billet
 */
class Billet {

    private $erreur = [], $id, $titre, $contenu, $datePublication, $dateModification, $statut, $auteur, $nbComs, $nbComSignale;

    const AUTEUR_INVALIDE = 1;
    const TITRE_INVALIDE = 2;
    const CONTENU_INVALIDE = 3;

    /**
     * Billet constructor.
     * @param array $donnees
     */
    public function __construct($donnees = []) {
        if (!empty($donnees))
        {
            $this->hydrate($donnees);
        }
    }

    /**
     * @param $donnees
     */
    public function hydrate($donnees) {

        foreach ($donnees as $key => $value)
        {
            $method = 'set'.ucfirst($key);

            if (method_exists($this, $method))
            {
              $this->$method($value);
            }
        }

    }

    // Getter

    /**
     * @return array
     */
    public function getErreur() {
        return $this->erreur;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->titre;
    }

    /**
     * @return mixed
     */
    public function getContent() {
        return $this->contenu;
    }

    /**
     * @return mixed
     */
    public function getDatePublication() {
        return $this->datePublication;
    }

    /**
     * @return mixed
     */
    public function getDateModification() {
        return $this->dateModification;
    }

    /**
     * @return array
     */
    public function getStatut() {
        return $this->statut;
    }

    /**
     * @return array
     */
    public function getAuthor() {
        return $this->auteur;
    }

    /**
     * @return array
     */
    public function getNbcoms() {
        return $this->nbComs;
    }

    /**
     * @return array
     */
    public function getNbComSignale() {
        return $this->nbComSignale;
    }

    // Setter

    /**
     * @param $id
     */
    public function setId($id) {
        $this->id = (int) $id;
    }

    /**
     * @param $titre
     */
    public function setTitle($titre) {
        if (!is_string($titre) || empty($titre)) {
            $this->erreur[] = self::TITRE_INVALIDE;
            $this->titre = $titre;
        } else {
            $this->titre = $titre;
        }
    }

    /**
     * @param $contenu
     */
    public function setContent($contenu) {
        if (!is_string($contenu) || empty($contenu)) {
            $this->erreur[] = self::CONTENU_INVALIDE;
            $this->contenu = $contenu;
        } else {
            $this->contenu = $contenu;
        }
    }

    /**
     * @param DateTime $datePublication
     */
    public function setDatePublication(DateTime $datePublication) {
        $this->datePublication = $datePublication;
    }

    /**
     * @param DateTime $dateModification
     */
    public function setDateModification(DateTime $dateModification) {
        $this->dateModification = $dateModification;
    }

    /**
     * @param $statut
     */
    public function setStatut($statut) {
        $this->statut = $statut;
    }

    /**
     * @param $auteur
     */
    public function setAuthor($auteur) {
        if (!is_string($auteur) || empty($auteur)) {
            $this->erreur[] = self::AUTEUR_INVALIDE;
            $this->auteur = $auteur;
        } else {
            $this->auteur = $auteur;
        }
    }

    /**
     * @param $nbComs
     */
    public function setNbcoms($nbComs) {
        $this->nbComs = (int) $nbComs;
    }

    /**
     * @param $nbComSignale
     */
    public function setNbComSignale($nbComSignale) {
        $this->nbComSignale = (int) $nbComSignale;
    }

}
<?php

class Billet {

    private $erreur = [], $id, $titre, $contenu, $datePublication, $dateModification, $statut, $auteur, $nbComs, $nbComSignale;

    const AUTEUR_INVALIDE = 1;
    const TITRE_INVALIDE = 2;
    const CONTENU_INVALIDE = 3;

    public function __construct($donnees = []) {
        if (!empty($donnees))
        {
            $this->hydrate($donnees);
        }
    }

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
    public function getErreur() {
        return $this->erreur;
    }

	public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->titre;
    }

    public function getContent() {
        return $this->contenu;
    }

    public function getDatePublication() {
        return $this->datePublication;
    }

    public function getDateModification() {
        return $this->dateModification;
    }

    public function getStatut() {
        return $this->statut;
    }

    public function getAuthor() {
        return $this->auteur;
    }

    public function getNbcoms() {
        return $this->nbComs;
    }

    public function getNbComSignale() {
        return $this->nbComSignale;
    }

    // Setter
    public function setId($id) {
        $this->id = (int) $id;
    }

    public function setTitle($titre) {
        if (!is_string($titre) || empty($titre)) {
            $this->erreur[] = self::TITRE_INVALIDE;
            $this->titre = $titre;
        } else {
            $this->titre = $titre;
        }
    }

    public function setContent($contenu) {
        if (!is_string($contenu) || empty($contenu)) {
            $this->erreur[] = self::CONTENU_INVALIDE;
            $this->contenu = $contenu;
        } else {
            $this->contenu = $contenu;
        }
    }

    public function setDatePublication(DateTime $datePublication) {
        $this->datePublication = $datePublication;
    }

    public function setDateModification(DateTime $dateModification) {
        $this->dateModification = $dateModification;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
    }

    public function setAuthor($auteur) {
        if (!is_string($auteur) || empty($auteur)) {
            $this->erreur[] = self::AUTEUR_INVALIDE;
            $this->auteur = $auteur;
        } else {
            $this->auteur = $auteur;
        }
    }

    public function setNbcoms($nbComs) {
        $this->nbComs = (int) $nbComs;
    }

    public function setNbComSignale($nbComSignale) {
        $this->nbComSignale = (int) $nbComSignale;
    }

}
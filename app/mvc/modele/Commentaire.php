<?php

class Commentaire {

    protected $com_id, $com_date, $com_auteur, $com_contenu, $bil_id, $com_signale;

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

    // GETTER
    /**
     * @return mixed
     */
    public function getComId()
    {
        return $this->com_id;
    }

    /**
     * @return mixed
     */
    public function getComDate()
    {
        return $this->com_date;
    }

    /**
     * @return mixed
     */
    public function getComAuteur()
    {
        return $this->com_auteur;
    }

    /**
     * @return mixed
     */
    public function getComContenu()
    {
        return $this->com_contenu;
    }

    /**
     * @return mixed
     */
    public function getTicketId()
    {
        return $this->bil_id;
    }

    public function getComSignale()
    {
        return $this->com_signale;
    }

    // SETTER
    /**
     * @param mixed $com_id
     */
    public function setComId($com_id)
    {
        $this->com_id = $com_id;
    }

    /**
     * @param mixed $com_date
     */
    public function setComDate(DateTime $com_date)
    {
        $this->com_date = $com_date;
    }

    /**
     * @param mixed $com_auteur
     */
    public function setComAuthor($com_auteur)
    {
        $this->com_auteur = $com_auteur;
    }

    /**
     * @param mixed $com_contenu
     */
    public function setComContent($com_contenu)
    {
        $this->com_contenu = $com_contenu;
    }

    /**
     * @param mixed $bil_id
     */
    public function setTicketId($bil_id)
    {
        $this->bil_id = $bil_id;
    }

    public function setComSignale($com_signale)
    {
        $this->com_signale = $com_signale;
    }

}
<?php

/**
 * Class TicketsManagerPDO
 */
class TicketsManagerPDO extends Manager
{

    // RECUPERE L'ARTICLE SELECTIONNE ET LE NOMBRE COMMENTAIRES
    /**
     * @param $id
     * @return mixed
     */
    public function getTicket($id) {

        $q = $this->getBdd()->prepare('SELECT billets.*, 
                                                DATE_FORMAT(billets.datePublication, "%d/%m/%Y à %Hh%i") AS datePublication,
                                                DATE_FORMAT(billets.dateModification, "%d/%m/%Y à %Hh%i") AS dateModification,
                                                COUNT(commentaires.bil_id) AS nbComs,
                                                SUM(if(commentaires.com_signale = 1, 1, 0)) AS nbComSignale
                                                FROM billets
                                                LEFT JOIN commentaires
                                                  ON commentaires.bil_id = :id
                                                WHERE billets.id = :id
                                                GROUP BY billets.id
                                                ORDER BY billets.id DESC');
        $q->bindValue(':id', $id, PDO::PARAM_INT);
        $q->execute();

        $q->setFetchMode(PDO::FETCH_CLASS, 'Billet');

        $billet = $q->fetch();

        return $billet;

    }

    // RECUPERE TOUT LES ARTICLES ET LE NOMBRE DE COMMENTAIRE ASSOCIE
    /**
     * @param $nbBillets
     * @param $perPage
     * @param $cPage
     * @return array
     */
    public function getAllBillets($nbBillets, $perPage, $cPage){

        if ($cPage != null) {
            $nbPages = ceil($nbBillets['nbBillets']/$perPage);

            $q = $this->getBdd()->query("SELECT billets.*,
                                                DATE_FORMAT(billets.datePublication, \"%d/%m/%Y à %Hh%i\") AS datePublication,
                                                DATE_FORMAT(billets.dateModification, \"%d/%m/%Y à %Hh%i\") AS dateModification,
                                                COUNT(commentaires.bil_id) AS nbComs,
                                                SUM(if(commentaires.com_signale = 1, 1, 0)) AS nbComSignale
                                                FROM billets
                                                LEFT JOIN commentaires
                                                  ON billets.id = commentaires.bil_id
                                                GROUP BY billets.id
                                                ORDER BY billets.id DESC
                                                LIMIT ".(($cPage-1)*$perPage).",$perPage");

            $billets = $q->fetchAll(PDO::FETCH_CLASS,'Billet');
        }

        return $billets;

    }

    // SUPPRIME L'ARTICLE SELECTIONNE
    /**
     * @param $id
     */
    public function delete($id) {
        $q = $this->getBdd()->prepare('DELETE billets, commentaires
                                        FROM billets 
                                        LEFT JOIN commentaires
                                          ON commentaires.bil_id = billets.id
                                        WHERE id = :id');
        $q->bindValue(':id', $id, PDO::PARAM_INT);

        $q->execute();
    }

    // MISE A JOUR D'UN ARTICLE
    /**
     * @param Billet $billet
     */
    public function update(Billet $billet) {

        $q = $this->getBdd()->prepare('UPDATE billets
                                                SET titre = :titre, contenu = :contenu, auteur = :auteur, dateModification = NOW()
                                                WHERE id = :id');
        $q->bindValue(':titre', $billet->getTitle());
        $q->bindValue(':contenu', $billet->getContent());
        $q->bindValue(':auteur', $billet->getAuthor());
        $q->bindValue(':id', $billet->getId(), PDO::PARAM_INT);

        $q->execute();
    }

    // AJOUT D'UN ARTICLE
    /**
     * @param Billet $billet
     */
    public function addTicket(Billet $billet){

        $q = $this->getBdd()->prepare('INSERT INTO billets(titre, contenu, auteur, datePublication, dateModification)
                                                VALUES (:titre, :contenu, :auteur, NOW(), NOW())');
        $q->bindValue(':titre', $billet->getTitle());
        $q->bindValue(':contenu', $billet->getContent());
        $q->bindValue(':auteur', $billet->getAuthor());

        $q->execute();

    }

    /**
     * @return string
     */
    public function lastId() {
        $lastId = $this->getBdd()->lastInsertId();

        return $lastId;
    }

}
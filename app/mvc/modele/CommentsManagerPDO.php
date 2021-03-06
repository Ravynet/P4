<?php

/**
 * Class CommentsManagerPDO
 */
class CommentsManagerPDO extends Manager
{

    // RECUPERE LES COMMENTAIRES SIGNALES POUR L'ADMIN
    /**
     * @param $nbBillets
     * @param $perPage
     * @param $cPage
     * @return array
     */
    public function getCommentaireSignale($nbBillets, $perPage, $cPage)
    {
        if ($cPage != null) {
            $nbPages = ceil($nbBillets/$perPage);

            $q = $this->getBdd()->query("SELECT billets.*,
                                                SUM(if(commentaires.com_signale >= 0, 1, 0)) AS nbComs,
                                                SUM(if(commentaires.com_signale = 1, 1, 0)) AS nbComSignale
                                                FROM billets
                                                INNER JOIN commentaires ON billets.id = commentaires.bil_id
                                                WHERE commentaires.com_signale = 1
                                                GROUP BY billets.id
                                                ORDER BY billets.id DESC
                                                LIMIT ".(($cPage-1)*$perPage).",$perPage");

            $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Billet');

            $billets = $q->fetchAll();

            foreach ($billets as $billet) {
                $billet->setDatePublication(new DateTime($billet->getDatePublication()));
                $billet->setDateModification(new DateTime($billet->getDateModification()));
            }
        }

        return $billets;

    }

    // RECUPERE LE NOMBRE TOTAL DE COMMENTAIRES SIGNALES POUR L'ADMIN
    /**
     * @return mixed
     */
    public function getNbComSignaleTotal()
    {
        $q = $this->getBdd()->query('SELECT
                                              SUM(if(commentaires.com_signale = 1, 1, 0)) AS nbComSignaleTotal
                                              FROM commentaires');
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $res = $q->fetchAll();

        $nbComSignaleTotal = $res[0];

        return $nbComSignaleTotal;
    }

    /**
     * @return mixed
     */
    public function getTicketsWithComReported () {
        $q = $this->getBdd()->query('SELECT COUNT(DISTINCT commentaires.bil_id) AS nbBilletsWithComSignale FROM commentaires WHERE commentaires.com_signale = 1');
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $res = $q->fetchAll();
        $nbBilletsWithComSignale = $res[0];

        return $nbBilletsWithComSignale;
    }

    // RECUPERE LES COMMENTAIRES SUIVANT L'ARTICLE SELECTIONNE
    /**
     * @param $id
     * @return array
     */
    public function getComments($id){

        $q = $this->getBdd()->prepare('SELECT commentaires.*,
                                                DATE_FORMAT(commentaires.com_date, "%d/%m/%Y à %Hh%i") AS com_date
                                                FROM commentaires
                                                WHERE commentaires.bil_id = :id
                                                ORDER BY commentaires.com_date DESC');

        $q->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $q->execute();

        $q->setFetchMode(PDO::FETCH_CLASS, 'Commentaire');

        $commentaires = $q->fetchAll();

        return $commentaires;
    }

    // RECUPERE LE COMMENTAIRES SIGNALE
    /**
     * @param $id
     * @return array
     */
    public function getComment($id){

        $q = $this->getBdd()->prepare('SELECT commentaires.*
                                                FROM commentaires
                                                WHERE commentaires.com_id = :id');

        $q->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $q->execute();

        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Commentaire');

        $commentaire = $q->fetchAll();

        return $commentaire;
    }

    // AJOUT D'UN COMMENTAIRE
    /**
     * @param Commentaire $commentaire
     */
    public function addComment(Commentaire $commentaire){

        $q = $this->getBdd()->prepare('INSERT INTO commentaires(com_auteur, com_contenu, bil_id, com_date)
                                                VALUES (:nom, :contenu, :id_billet, NOW())');

        $q->bindValue(':nom', $commentaire->getComAuteur());
        $q->bindValue(':contenu', $commentaire->getComContenu());
        $q->bindValue(':id_billet', $commentaire->getTicketId(), PDO::PARAM_INT);

        $q->execute();

    }

    // SIGNALE UN COMMENTAIRE
    /**
     * @param $commentaire
     */
    public function report($commentaire) {

        $q = $this->getBdd()->prepare('UPDATE commentaires SET com_signale = 1 WHERE com_id = :id');

        $q->bindValue(':id', $commentaire, PDO::PARAM_INT);

        $q->execute();
    }

    // SUPPRIME UN COMMENTAIRE
    /**
     * @param $id
     */
    public function deleteCom($id) {
        $q = $this->getBdd()->prepare('DELETE FROM commentaires
                                                WHERE com_id = :id');
        $q->bindValue(':id', $id, PDO::PARAM_INT);
        $q->execute();
    }

    // MODERE UN COMMENTAIRE
    /**
     * @param Commentaire $commentaire
     */
    public function moderateCom(Commentaire $commentaire) {

        $q = $this->getBdd()->prepare('UPDATE commentaires
                                                SET com_signale = 2, com_contenu = :contenu
                                                WHERE com_id = :id');

        $q->bindValue(':id', $commentaire->getComID(), PDO::PARAM_INT);
        $q->bindValue(':contenu', $commentaire->getComContenu());

        $q->execute();
    }

    /**
     * @param $user
     * @return mixed
     */
    public function lastComment($user) {
        $q = $this->getBdd()->prepare('SELECT *,
                                                DATE_FORMAT(commentaires.com_date, "%d/%m/%Y à %Hh%i") AS com_date
                                                FROM commentaires
                                                WHERE com_auteur = :user
                                                ORDER BY com_id DESC LIMIT 1');
        $q->bindValue(':user', $user, PDO::PARAM_STR);
        $q->execute();

        $q->setFetchMode(PDO::FETCH_CLASS, 'Commentaire');

        $lastComment = $q->fetch();

        return $lastComment;
    }

}
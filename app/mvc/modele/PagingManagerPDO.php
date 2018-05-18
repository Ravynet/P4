<?php

class PagingManagerPDO extends Manager
{
    public function getPaging()
    {
        $q = $this->getBdd()->query('SELECT COUNT(id) AS nbBillets FROM billets');
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $res = $q->fetchAll();
        $nbBillets = $res[0];

        return $nbBillets;
    }
}
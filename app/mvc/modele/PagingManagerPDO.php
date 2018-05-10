<?php
/**
 * Created by PhpStorm.
 * User: yannr
 * Date: 12/11/2017
 * Time: 11:04
 */

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
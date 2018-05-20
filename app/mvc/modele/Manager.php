<?php

/**
 * Class Manager
 */
abstract class Manager {

    protected $db;

    /**
     * @return PDO
     */
    public function getBdd()
    {
        if ($this->db == null) {
            $this->db = DBFactory::getMysqlConnexionWithPDO();
        }

        return $this->db;
    }

}


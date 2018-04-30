<?php

abstract class Manager {

    protected $db;

    public function getBdd()
    {
        if ($this->db == null) {
            $this->db = DBFactory::getMysqlConnexionWithPDO();
        }

        return $this->db;
    }

}


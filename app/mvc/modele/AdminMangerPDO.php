<?php

/**
 * Class AdminMangerPDO
 */
class AdminMangerPDO extends Manager
{
    /**
     * @param $username
     * @param $pass_hache
     * @return mixed
     */
    public function connexion($username, $pass_hache)
    {
        // Vérification des identifiants
        $req = $this->getBdd()->prepare('SELECT * FROM admin WHERE username = :username AND password = :password');
        $req->execute(array(
            'username' => $username,
            'password' => $pass_hache));

        $resultat = $req->fetch();

        return $resultat;
    }

}
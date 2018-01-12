<?php

class UploadException
{
private $message;

    public function __construct($code)
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $this->message = "Le fichier excède la taille maximum autorisé.";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $this->message = "Le fichier excède la taille maximum autorisé. (" . floor(Config::get('max_size') / 1000000) . ' Mo)';
                break;
            case UPLOAD_ERR_PARTIAL:
                $this->message = "Le fichier a été transféré partiellement. Veuillez recommencer";
                break;
            case UPLOAD_ERR_NO_FILE:
                $this->message = "Ce champ est requis.";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $this->message = "Dossier temporaire introuvable.";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $this->message = "Une erreur d'écriture c'est produite.";
                break;
            case UPLOAD_ERR_EXTENSION:
                $this->message = "L' extension n'est pas autorisée.";
                break;
        }
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

}
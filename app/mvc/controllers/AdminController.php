<?php

/**
 * Class AdminController
 */
class AdminController extends Controller
{

    /**
     * @var AdminMangerPDO
     */
    private $connexion;

    /**
     * AdminController constructor.
     */
    function __construct()
    {
        $this->connexion = new AdminMangerPDO();
        parent::__construct();
    }

    /**
     * @return string
     */
    public function index()
    {
        if ($this->params != null) {
            if (isset($_COOKIE['id']) && !isset($_SESSION['id'])) {

                $auth = explode('-', $_COOKIE['id']);
                $user = $this->connexion->connexion($auth[1], $auth[2]);
                $key = $user['username'] . '-' . $user['password'];

                if ($key == $auth[1] . '-' . $auth[2]) {
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['pseudo'] = $user['pseudo'];
                    $_SESSION['username'] = $user['username'];
                    setcookie('id', $user['id'] . '-' . $user['username'] . '-' . $user['password'], time() + 3600 * 24 * 3, '/', null, false, true);
                } else {
                    setcookie('id', '');
                }
            }

            $cPage = $this->params;
            $nbTicket = $this->paging->getPaging();
            $nbPages = ceil($nbTicket['nbBillets']/Config::get("art_per_page_admin"));

            if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
                $tickets = $this->ticket->getAllBillets($nbTicket, Config::get("art_per_page_admin"), $cPage);
                $sumComReported = $this->comment->getNbComSignaleTotal();

                array_push($this->data, $tickets);
                array_push($this->data, $nbPages);
                array_push($this->data, $cPage);
                array_push($this->data, $sumComReported);
                $_SESSION['sumComReported'] = $sumComReported;
            } else {
                header('location: admin/login');
            }
        } else {
            return APP.DS."template".DS.'404.php';
        }
    }

    /**
     *
     */
    public function ajouter()
    {

        if (!empty($_POST)) {

            $newTicket = new Billet();
            $newTicket->setContent($_POST['contenu']);
            $newTicket->setAuthor(strip_tags($_POST['auteur']));
            $newTicket->setTitle(strip_tags($_POST['titre']));

            $newImage = $_FILES['image']['tmp_name'];
            $code = $_FILES['image']['error'];

            if ($newImage == '') {
                $code = UPLOAD_ERR_NO_FILE;
            } else {

                $image_sizes = getimagesize($newImage);
                $image_size = $_FILES['image']['size'];
                //var_dump($image_size);
                $extension_valid = Config::get('extension_valid');
                //1. strrchr renvoie l'extension avec le point (« . »).
                //2. substr(chaine,1) ignore le premier caractère de chaine.
                //3. strtolower met l'extension en minuscules.
                $extension_upload = strtolower(substr(strrchr($_FILES['image']['name'],'.') ,1));

                if (!in_array($extension_upload,$extension_valid)) { $code = UPLOAD_ERR_EXTENSION; }
                if ($image_size > Config::get('max_size')) { $code = UPLOAD_ERR_FORM_SIZE; }
            }

            $errorImage = new UploadException($code);

            if ($newTicket->getTitle() != "" && $newTicket->getContent() != "" && $newTicket->getAuthor() != "" && $code === UPLOAD_ERR_OK) {
                $this->ticket->addTicket($newTicket);

                    $name = ($this->ticket->lastId());

                    $destination = WEBROOT.DS.'images'.DS.$name.'.'.$extension_upload;

                    if ($image_sizes[0] > Config::get('max_width') OR $image_sizes[1] > Config::get('max_height')) {
                        $this->resize_crop_image(Config::get('max_width'), Config::get('max_height'), $newImage, $destination);
                    } else {
                        move_uploaded_file($_FILES['image']['tmp_name'],$destination);
                    }
                $message = 'L\' article a bien été ajouté.';
                $errorImage = null;
            } else {
                $message = null;
            }

            array_push($this->data, $newTicket);
            array_push($this->data, $message);
            array_push($this->data, $errorImage);

        } else {
            $newTicket = null;
            $message = null;
            $errorImage = null;
            array_push($this->data, $newTicket);
            array_push($this->data, $message);
            array_push($this->data, $errorImage);
        }
    }

    /**
     * @param $max_width
     * @param $max_height
     * @param $source_file
     * @param $dst_dir
     * @return bool
     */
    function resize_crop_image($max_width, $max_height, $source_file, $dst_dir)
    {
        $imgsize = getimagesize($source_file);
        $width = $imgsize[0];
        $height = $imgsize[1];
        $mime = $imgsize['mime'];

        switch ($mime) {
            case 'image/gif':
                $image_create = "imagecreatefromgif";
                $image = "imagegif";
                break;

            case 'image/png':
                $image_create = "imagecreatefrompng";
                $image = "imagepng";
                $quality = Config::get('quality_png');
                break;

            case 'image/jpeg':
                $image_create = "imagecreatefromjpeg";
                $image = "imagejpeg";
                $quality = Config::get('quality_jpeg');
                break;

            default:
                return false;
                break;
        }

        $dst_img = imagecreatetruecolor($max_width, $max_height);
        $src_img = $image_create($source_file);

        $width_new = $height * $max_width / $max_height;
        $height_new = $width * $max_height / $max_width;
        //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
        if ($width_new > $width) {
            //cut point by height
            $h_point = (($height - $height_new) / 2);
            //copy image
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
        } else {
            //cut point by width
            $w_point = (($width - $width_new) / 2);
            imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
        }

        $image($dst_img, $dst_dir, $quality);
    }

    /**
     * @param $idTicket
     */
    public function modifier($idTicket)
    {
        if (!empty($_POST)) {

            $newTicket = $this->ticket->getTicket($idTicket);
            $newTicket->setContent($_POST['contenu']);
            $newTicket->setAuthor(strip_tags($_POST['auteur']));
            $newTicket->setTitle(strip_tags($_POST['titre']));

            if (!empty($_FILES['image']['name'])) {

                $newImage = $_FILES['image']['tmp_name'];
                $code = $_FILES['image']['error'];

                if ($newImage == '') {
                    $code = UPLOAD_ERR_FORM_SIZE;
                } else {
                    $image_sizes = getimagesize($newImage);
                    $image_size = $_FILES['image']['size'];

                    $extension_valid = Config::get('extension_valid');
                    //1. strrchr renvoie l'extension avec le point (« . »).
                    //2. substr(chaine,1) ignore le premier caractère de chaine.
                    //3. strtolower met l'extension en minuscules.
                    $extension_upload = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));

                    if (!in_array($extension_upload, $extension_valid)) {
                        $code = UPLOAD_ERR_EXTENSION;
                    }
                    if ($image_size > Config::get('max_size')) {
                        $code = UPLOAD_ERR_FORM_SIZE;
                    }
                }
            } else {
                $code = 0;
            }

            $errorImage = new UploadException($code);

            if ($newTicket->getTitle() != "" && $newTicket->getContent() != "" && $newTicket->getAuthor() != "" && $code == 0) {
                $this->ticket->update($newTicket);
                $message = 'L\' article a bien été modifié.';

                if ($_FILES['image']['tmp_name'] != '') {
                    $name = ($idTicket);

                    $destination = WEBROOT.DS.'images'.DS.$name.'.'.$extension_upload;

                    if (file_exists($destination)) {
                        unlink($destination);
                        clearstatcache();
                    }

                    if ($image_sizes[0] > Config::get('max_width') OR $image_sizes[1] > Config::get('max_height')) {
                        $this->resize_crop_image(Config::get('max_width'), Config::get('max_height'), $newImage, $destination);
                    } else {
                        move_uploaded_file($_FILES['image']['tmp_name'],$destination);
                    }
                }
            } else {
                $message = null;
            }

            $comment = $this->comment->getComments($idTicket);
            array_push($this->data, $newTicket);
            array_push($this->data, $comment);
            array_push($this->data, $message);
            array_push($this->data, $errorImage);
        } else {
            $newTicket = $this->ticket->getTicket($idTicket);
            $comment = $this->comment->getComments($idTicket);
            $message = null;
            $errorImage = null;
            array_push($this->data, $newTicket);
            array_push($this->data, $comment);
            array_push($this->data, $message);
            array_push($this->data, $errorImage);
        }
    }

    /**
     *
     */
    public function supprimer()
    {
        if (!empty($_POST)) {

            $img = $_POST['id'];
            $dir = WEBROOT.DS.'images'.DS;
            $ext_list = array('.gif', '.jpg', '.jpeg', '.png');
            foreach($ext_list as $ext){
                if(file_exists($dir.$img.$ext)){
                    unlink($dir.$img.$ext);
                }
            }
            $this->ticket->delete($_POST['id']);
            header('location: ' . LOCAL . 'admin?1');
        }
    }

    /**
     * @param $idCom
     */
    public function supprimerCom($idCom)
    {
        header('location: modifier?'.$_POST['id']);
        $this->comment->deleteCom($idCom);
        $_SESSION['sumComReported']['nbComSignaleTotal']= $_SESSION['sumComReported']['nbComSignaleTotal'] - 1;
    }

    /**
     * @param $idCom
     */
    public function modererCom($idCom)
    {
        if (!empty($_POST)) {
            $comment = $this->comment->getComment($idCom);
            $comModere = $comment[0];
            $comModere->setComId($idCom);
            $comModere->setComContent($_POST['contenuCommentaire']);

            $this->comment->moderateCom($comModere);
        }
        if (App::isAjax()){
            $_SESSION['sumComReported']['nbComSignaleTotal']= $_SESSION['sumComReported']['nbComSignaleTotal'] - 1;
        } else {
            header('location: modifier?'.$_POST['id']);
        }
    }

    /**
     * @return string
     */
    public function commentaire()
    {
        if ($this->params != null) {
            $nbTicket = $this->comment->getTicketsWithComReported();
            $nbTicket = $nbTicket['nbBilletsWithComSignale'];

            $cPage = $this->params;

            $nbPages = ceil($nbTicket/Config::get("art_per_page_admin"));

            $tickets = $this->comment->getCommentaireSignale($nbTicket, Config::get("art_per_page_admin"), $cPage);

            array_push($this->data, $tickets);
            array_push($this->data, $nbPages);
            array_push($this->data, $cPage);
        } else {
            return APP.DS."template".DS.'404.php';
        }
    }

    /**
     *
     */
    public function login()
    {
        if (!empty($_POST)) {
            $username = $_POST['username'];
            // Hachage du mot de passe
            $pass_hache = hash('sha256', $_POST['password'], false);

            $user = $this->connexion->connexion($username, $pass_hache);

            if ($user)
            {
                $_SESSION['id'] = $user['id'];
                $_SESSION['pseudo'] = $user['pseudo'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['password'] = $user['password'];

                if (isset($_POST['connexion-auto'])) {
                    setcookie('id', $user['id'] . '-' . $user['username'] . '-' . $user['password'], time()+ 3600*24*3 , '/', null, false, true);
                }

                header('location: ../admin?1');
            }
            else
            {
                $error = 'Identifiant ou mot de passe incorrect !';
                array_push($this->data, $error);
            }
        }
    }

    /**
     *
     */
    public function deconnexion()
    {
        // Suppression des variables de session et de la session
        $_SESSION = array();
        session_destroy();

        // Suppression des cookies de connexion automatique
        setcookie('id', '', time() -1, '/');

        header('location: ../blog?1');
    }
}
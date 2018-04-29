<?php

class BlogController extends Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $cPage = $this->params;
        if ($cPage != null) {
            $nbTicket = $this->ticket->getPaging();
            $nbPages = ceil($nbTicket['nbBillets']/Config::get("art_per_page_blog"));

            $tickets = $this->ticket->getAllBillets($nbTicket, Config::get("art_per_page_blog"), $cPage);

            array_push($this->data, $tickets);
            array_push($this->data, $nbPages);
            array_push($this->data, $cPage);
        } else {
            return APP.DS."template".DS.'404.php';
        }
    }

    // Show one ticket
    public function billet($id)
    {
        $ticket = $this->ticket->getTicket($id);
        if ($ticket != false) {
            array_push($this->data, $ticket);
            $comment = $this->comment->getComments($id);
            array_push($this->data, $comment);
        } else {
            return APP.DS."template".DS.'404.php';
        }
    }

    public function commenter($idTicket)
    {
        if (!empty($_POST)) {

            $newComment = new Commentaire();

            $newComment->setComAuthor($_POST['nom']);
            $newComment->setComContent($_POST['contenu']);
            $newComment->setTicketId($idTicket);

            $this->comment->addComment($newComment);
            header('location: billet?' . $idTicket);
        }
    }

    public function signaler($idTicket)
    {
        $comment = $this->comment->getComment($idTicket);
        $data = $comment[0];
        $this->comment->report($idTicket);
        header('location: billet?' . $data->getTicketId());
    }
}
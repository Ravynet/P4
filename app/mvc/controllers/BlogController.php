<?php

class BlogController extends Controller
{
    private $ticket;
    private $comment;

    function __construct($data = null)
    {
        $this->ticket = new TicketsManagerPDO();
        $this->comment = new CommentsManagerPDO();

        parent::__construct($data);

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

    // Affiche les détails sur un billet
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
        var_dump($data);
        $this->comment->report($idTicket);
        header('location: billet?' . $data->getTicketId());
    }
}
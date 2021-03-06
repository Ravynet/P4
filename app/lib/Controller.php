<?php

/**
 * Class Controller
 */
abstract class Controller
{

    /**
     * @var TicketsManagerPDO
     */
    protected $ticket;
    /**
     * @var CommentsManagerPDO
     */
    protected $comment;
    /**
     * @var
     */
    protected $params;
    /**
     * @var PagingManagerPDO
     */
    protected $paging;
    /**
     * @var array
     */
    protected $data = [];

    /**
     * Controller constructor.
     */
    function __construct()
    {
        $this->ticket = new TicketsManagerPDO();
        $this->comment = new CommentsManagerPDO();
        $this->paging = new PagingManagerPDO();
        $this->params = App::getRouter()->getParams();
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

}
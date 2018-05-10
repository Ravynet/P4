<?php

abstract class Controller
{

    protected $ticket;
    protected $comment;
    protected $params;
    protected $paging;
    protected $data = [];

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
<?php

namespace app\index\controller;

use app\common\controller\Frontend;

class Index extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function index()
    {
        return $this->view->fetch();
    }


    public function Support()
    {
        return $this->view->fetch();
    }

    public function Partner()
    {
        return $this->view->fetch();
    }

    public function support_detail1()
    {
        return $this->view->fetch();
    }

    public function support_detail2()
    {
        return $this->view->fetch();
    }

    
    public function abouts_us()
    {
        return $this->view->fetch();
    }

    
    public function explanation()
    {
        return $this->view->fetch();
    }

}

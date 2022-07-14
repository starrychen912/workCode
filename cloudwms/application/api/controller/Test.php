<?php

namespace app\api\controller;

use app\common\controller\FinderApi;
use think\Db;


/**
 * 类
 */
class Test extends FinderApi
{

    protected $noNeedLogin = ['*'];
    protected $noNeedRight = [];


    public function index()
    {
        echo 1;
    }


}
<?php
namespace app\index\controller;
use app\index\controller\Base;
class Index extends Base
{
    public function index()
    {
        // return view('ce');
        // return view();
        // var_dump(USER_ID == NULL);
        // die;
        $this->isLogin();
        return $this->view->fetch();
    }
}

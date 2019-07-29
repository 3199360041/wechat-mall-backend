<?php


namespace app\admin\controller;


class Goods extends BaseController
{
    public function index()
    {
        return $this->fetch();
    }
}
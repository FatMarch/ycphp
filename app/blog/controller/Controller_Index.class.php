<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/5
 * Time: 22:30
 */


class Controller_Index extends YcController
{
    public function index()
    {
        dump("Hello world");

        dump($_SERVER);
    }
}
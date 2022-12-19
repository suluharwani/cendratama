<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['content']=view('home/content/homepage');
        return view('home/index', $data);
    }
}

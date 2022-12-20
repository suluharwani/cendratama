<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data['content']=view('home/content/page');
        return view('home/index', $data);
    }

}

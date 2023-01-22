<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['content']=view('home/content/homepage');
        return view('home/index', $data);
    }
  function menu(){
      $model = new \App\Models\MdlPages();
      return json_encode($model->get()->getResult());
    }
  function menu_cat(){
      $model = new \App\Models\MdlCategory();
      $page_id = $_POST['page_id'];
      return json_encode($model->select('id, category')->where('page_id',$page_id)->get()->getResult());
    }
  function menu_sub_cat(){
      $model = new \App\Models\MdlSubCategory();
      $category_id = $_POST['category_id'];
      return json_encode($model->select('sub_category')->where('category_id',$category_id)->get()->getResult());
    }
}

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
      $where = ['id !=' => 0, 'deleted_at'=>NULL];
      return json_encode($model->where($where)->get()->getResult());
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
  function page($page=null, $slug1=null, $slug2=null, $slug3=null, $slug4=null){
    
      if ($page == null) {
        //list menu
       $data['content']=view('home/content/page_default');
      }else{
        //content
       $data['content']=view('home/content/single_page');
      }
        return view('home/index', $data);
    }
  function get_menu_array(){
      $pages = new \App\Models\MdlPages();
      $pages->select('page.id as page_id, page.page as page, page.slug as page_slug, category.id as category_id, category.slug as category_slug');
      $pages->join('category', 'category.id = page.id');
       return json_encode($pages->get()->getResultArray());
  }
}

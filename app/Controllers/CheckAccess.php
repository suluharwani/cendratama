<?php

namespace App\Controllers;

class CheckAccess extends BaseController
{
    public function index()
    {
    }
    public function access($id,$page)
    {
        if (isset($_SESSION['logged'])){
           if (isset($_SESSION['auth'])) {
            
            $mdlAccess = new \App\Models\MdlAccess();
            if ($mdlAccess->getAccess($id,$page) == 1) {

            }else{
                if ($_SESSION['auth']['level']==1) {
                    // code...
                }else{
                echo view('errors/html/403');
                exit();
                } 
            }
        }else{
            header('HTTP/1.1 403 Access denied');
            header('Content-Type: application/json; charset=UTF-8');
            echo view('errors/html/403');
            exit(); 
        }
    }
    else
    {
        
        header('Location: '.base_url('/admin/login'));
        exit(); 
    }  
    }
    function logged(){
              if (isset($_SESSION['logged']))
        {
         
        }
        else
        {
            header('Location: '.base_url('/admin/login'));
            exit(); 

        }  
    }
}

<?php
namespace App\Controllers;
use AllowDynamicProperties; 
use CodeIgniter\Controller;
use Bcrypt\Bcrypt;
use google\apiclient;
class Pages extends BaseController
{
    protected $bcrypt;
    protected $userValidation;
    protected $bcrypt_version;
    protected $session;
    protected $db;
    protected $uri;
    protected $form_validation;
    public function __construct()
    {
    //   parent::__construct();
      $this->db      = \Config\Database::connect();
      $this->session = session();
      $this->bcrypt = new Bcrypt();
      $this->bcrypt_version = '2a';
      $this->uri = service('uri');
      helper('form');
      $this->form_validation = \Config\Services::validation();
      $this->userValidation = new \App\Controllers\LoginValidation();
      //if sesion habis

      if (isset($_SESSION['logged']))
        {
         
        }
        else
        {
            header('Location: '.base_url('/admin'));
            exit(); 

        }   
    }
    public function index()
    {
        if ($this->userValidation->validate_user()) {
            echo "ok";
        }else{
            echo "not ok";
        }
        // $data['content']=view('admin/content/page');
        // return view('admin/index', $data);
    }
    public function manage(){
        if ($this->userValidation->validate_user()) {
            print_r($this->userValidation->validate_user());
        }else{
            echo "not ok";
        }
    }
    function logoutAdmin(){
        return "adad";
    }
}

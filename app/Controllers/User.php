<?php
namespace App\Controllers;
use AllowDynamicProperties; 
use CodeIgniter\Controller;
use Bcrypt\Bcrypt;

class User extends BaseController
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
            header('Location: '.base_url('/admin/login'));
            exit(); 

        }   
    }
    public function index()
    {


    }
    public function user($jenis=null){
        if ($jenis == "administrator") {
            $data['content']=view('admin/content/administrator');

        }else if($jenis == "client"){
            $data['content']=view('admin/content/user');

        }else{
            $data['content']="";

        }
        return view('admin/index', $data);
    }
    public function listdata_user(){
          $serverside_model = new \App\Models\Mdl_datatables();
          $request = \Config\Services::request();
          $list_data = $serverside_model;
          // $level = $_POST['level'];
          // if ($level == "all") {
            $where = ['id !=' => 0, 'deleted_at'=>NULL];
          // }else{
          //   $where = ['level' => $level,];
          // } 
          //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
          //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
          $column_order = array(NULL,'user.nama_depan','user.profile_picture','user.level','user.status','user.id');
          $column_search = array('user.nama_depan','user.nama_belakang','user.email','user.id');
          $order = array('user.id' => 'desc');
          $list = $list_data->get_datatables('user', $column_order, $column_search, $order, $where);
          $data = array();
          $no = $request->getPost("start");
          foreach ($list as $lists) {
            $no++;
            $row    = array();
            $row[] = $no;
            $row[] = $lists->nama_depan;
            $row[] = $lists->nama_belakang;
            $row[] = $lists->email;
            $row[] = $lists->id;
            $row[] = $lists->level;
            $row[] = $lists->status;
            $row[] = $lists->profile_picture;
            $data[] = $row;
          }
          $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $list_data->count_all('user', $where),
            "recordsFiltered" => $list_data->count_filtered('user', $column_order, $column_search, $order, $where),
            "data" => $data,
          );
    
          return json_encode($output);
      }
}

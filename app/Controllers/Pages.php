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
    protected $changelog;
    
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
      $this->changelog = new \App\Controllers\Changelog();

      //if sesion habis

      $check = new \App\Controllers\CheckAccess();
      $check->logged();  
    }
    public function index()
    {
        echo"ok";
        // $data['content']=view('admin/content/page');
        // return view('admin/index', $data);
    }
    public function manage(){
    $this->access('operator');
   $data['content']=view('admin/content/page');
        return view('admin/index', $data);
    }
    // function logoutAdmin(){
    //     return "adad";
    // }
    function access($page){
$check = new \App\Controllers\CheckAccess();
$check->access($_SESSION['auth']['id'],$page);
}
public function listdata_pages(){
  $this->access('operator');
  $serverside_model = new \App\Models\Mdl_datatables();
  $request = \Config\Services::request();
  $list_data = $serverside_model;
  $where = ['id !=' => 0, 'deleted_at'=>NULL];
          //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
          //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
  $column_order = array(NULL,'page.page','page.id');
  $column_search = array('page.page','page.id');
  $order = array('page.id' => 'desc');
  $list = $list_data->get_datatables('page', $column_order, $column_search, $order, $where);
  $data = array();
  $no = $request->getPost("start");
  foreach ($list as $lists) {
    $no++;
    $row    = array();
    $row[] = $no;
    $row[] = $lists->id;
    $row[] = $lists->page;
    $data[] = $row;
}
$output = array(
    "draw" => $request->getPost("draw"),
    "recordsTotal" => $list_data->count_all('page', $where),
    "recordsFiltered" => $list_data->count_filtered('page', $column_order, $column_search, $order, $where),
    "data" => $data,
);

return json_encode($output);
}
  function tambah_page(){
      $this->access('operator');
      $userInfo = $_SESSION['auth'];
      $model = new \App\Models\MdlPages();
      $userdata = [
        "page" =>  $_POST["page"]
      ];
      if ($model->insert($userdata)) {
        $riwayat = "User ".$userInfo['nama_depan']." ".$userInfo['nama_depan']." menambahkan halaman: ".$_POST['page']."";
        header('HTTP/1.1 200 OK');
      }else{
        $riwayat = "User ".$userInfo['name']." gagal menambahkan halaman: ".$_POST['page'];
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'User exist, gagal menambahkan data.', 'code' => 3)));
      }
      $this->changelog->riwayat($riwayat);
    
  }
}

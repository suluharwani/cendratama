<?php
namespace App\Controllers;
use AllowDynamicProperties; 
use CodeIgniter\Controller;
use Bcrypt\Bcrypt;
use google\apiclient;
class StaticPages extends BaseController
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
        // echo"ok";
        // $data['content']=view('admin/content/page');
        // return view('admin/index', $data);
    }
    public function manage(){
    $this->access('operator');
   $data['content']=view('admin/content/static_page');
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
function crud($action = null){
  $this->access('operator');
  if ($action != null) {
    
  $page = $_POST['page'];
  $data = $_POST['data'];
  $param = $_POST['param'];
  if ($page == 'contactUs') {
    $mdl = new \App\Models\MdlContactUs();
  }else  if ($page == 'slider') {
    $mdl = new \App\Models\MdlSlider();
  }else  if ($page == 'service') {
    $mdl = new \App\Models\MdlService();
  }else  if ($page == 'portfolio') {
    $mdl = new \App\Models\MdlPortfolio();
  }else  if ($page == 'testimonial') {
    $mdl = new \App\Models\MdlTestimonial();
  }else  if ($page == 'partner') {
    $mdl = new \App\Models\MdlPartner();
  }else  if ($page == 'contactUs') {
    $mdl = new \App\Models\MdlOffer();
  }else{
      header('HTTP/1.1 500 Internal Server Error');
      header('Content-Type: application/json; charset=UTF-8');
      die(json_encode(array('message' => 'page not found', 'code' => 3)));
  }
  if ($action == 'create') {
      $mdl->insert($data);
      if ($mdl->affectedRows()>0) {
        $riwayat = "insert halaman statis {$page}";
        $this->changelog->riwayat($riwayat);
        header('HTTP/1.1 200 OK');
      }else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
      }
  }else  if ($action == 'read') {
         $mdl->where('deleted_at', null);
      if ($param != '') {
         $mdl->where($param);
       } 
      if ($output = $mdl->get()->getResultArray()) {
      return json_encode($output);
      }else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Gagal mendapatkan data', 'code' => 1)));
      }
  }else  if ($action == 'update') {
      $mdl->set($data);
      $mdl->where($param);
      $mdl->update();
      if ($mdl->affectedRows()>0) {
        $riwayat = "Mengubah halaman statis {$page}";
        $this->changelog->riwayat($riwayat);
        header('HTTP/1.1 200 OK');
      }else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
      }
  }else  if ($action == 'delete') {
      $mdl->where($param);
      $mdl->delete();
      if ($mdl->affectedRows()>0) {
        $riwayat = "Menghapus halaman statis {$page}";
        $this->changelog->riwayat($riwayat);
        header('HTTP/1.1 200 OK');
      }else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
      }
  }else{
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => "Tidak ada aksi", 'code' => 1)));
    }
  }else{
        $list_param ='';
        $list_table = array('contact_us','slider','service','portfolio','testimonial','partner','contact_us' );
        foreach ($list_table as  $value) {
           $list_param  .=$this->list_param($value);
        }
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => "{$list_param}", 'code' => 1)));
    }
  }
    function list_param($table){

    $query = $this->db->query("SELECT * FROM $table");
    $param = '';
    echo($table.' = ');
    foreach ($query->getFieldNames() as $field) {
      $param .= '"'.$field.'",';
    }
    echo($param."\r\n");
  }

}

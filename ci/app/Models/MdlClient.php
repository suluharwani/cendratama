<?php

namespace App\Models;

use CodeIgniter\Model;

class MdlClient extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'client';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    =["id","nama_depan","nama_belakang","password","email","profile_picture","status","updated_at","deleted_at","created_at"];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

     function get_cipherpass($email){
    return $this->where('email',$email)->first('id','password','email','nama_depan','nama_belakang');
  }
  function check_client_active($email){
    $db = \Config\Database::connect();
    $builder = $db->table('client');
    $builder->where(array('email' => $email , 'status' => 1 ) );
    $total = $builder->countAllResults();
    if ($total > 0) {
      return true;
    }else{
      return false;
    }
  }

function createNewUser($userdata){
  if ($this->where('email',$userdata['email'])->countAllResults() == 0) {
    $this->set($userdata);
    $this->insert();
    return true;
  }else{
    return false;
  }
}

}

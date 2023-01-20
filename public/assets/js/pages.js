var loc = window.location;
var base_url = loc.protocol + "//" + loc.hostname + (loc.port? ":"+loc.port : "") + "/";

tabel();
function tabel(){
  var dataTable = $('#tabel_serverside').DataTable( {
    "processing" : true,
    "oLanguage": {
      "sLengthMenu": "Tampilkan _MENU_ data per halaman",
      "sSearch": "Pencarian: ",
      "sZeroRecords": "Maaf, tidak ada data yang ditemukan",
      "sInfo": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
      "sInfoEmpty": "Menampilkan 0 s/d 0 dari 0 data",
      "sInfoFiltered": "(di filter dari _MAX_ total data)",
      "oPaginate": {
        "sFirst": "<<",
        "sLast": ">>",
        "sPrevious": "<",
        "sNext": ">"
      }
    },
    "dom": 'Bfrtip',
    "buttons": [
    'csv'
    ],
    "order": [],
    "ordering": true,
    "info": true,
    "serverSide": true,
    "stateSave" : true,
    "scrollX": true,
    "ajax":{
      "url" :base_url+"pages/listdata_pages" , // json datasource 
      "type": "post",  // method  , by default get
      "data":{},
    },
    columns: [
    {},
    {mRender: function (data, type, row) {
      return  row[2];
    }},
    {mRender: function (data, type, row) {
      return  row[1];
    }},
   

    {mRender: function (data, type, row) {
    return   '<a href="javascript:void(0);" class="btn btn-info btn-sm resetPassword"  id="'+row[1]+'" >Reset Password</a> <a href="javascript:void(0);" class="btn btn-warning btn-sm nonaktifkanstatus"  id="'+row[4]+'" >Nonaktifkan</a> <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_hapus_user" id="'+row[1]+'" nama = "'+row[1]+' '+row[2]+'">Hapus</a>';

    }
  }
  ],
  "columnDefs": [{
    "targets": [0],
    "orderable": false
  }],

  error: function(){  // error handling
    $(".tabel_serverside-error").html("");
    $("#tabel_serverside").append('<tbody class="tabel_serverside-error"><tr><th colspan="3">Data Tidak Ditemukan di Server</th></tr></tbody>');
    $("#tabel_serverside_processing").css("display","none");

  }

});
};

$('#tabel_serverside').on('click','.resetPassword',function(){
  let id = $(this).attr('id');

  Swal.fire({
    title: `Set Password `,
    html: `<input type="text" id="password" class="swal2-input" placeholder="Password baru">`,
    confirmButtonText: 'Confirm',
    focusConfirm: false,
    preConfirm: () => {
      const password = Swal.getPopup().querySelector('#password').value
      if (!password) {
        Swal.showValidationMessage('Silakan lengkapi data')
      }
      return {password: password }
    }
  }).then((result) => {
    $.ajax({
      type : "POST",
      url  : base_url+'/admin/user/reset_password',
      async : false,
      // dataType : "JSON",
      data : {id:id,password:result.value.password},
      success: function(data){
        $('#tabel_serverside').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: `Password berhasil diubah menjadi ${result.value.password}.`,
          showConfirmButton: false,
          timer: 1500
        })
      },
      error: function(xhr){
        let d = JSON.parse(xhr.responseText);
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `${d.message}`,
          footer: '<a href="">Why do I have this issue?</a>'
        })
      }
    });

  })
});

$('#tabel_serverside').on('click','.aktifkanstatus',function(){
  let id = $(this).attr('id');
  let status = 1;
  $.ajax({
    type : "POST",
    url  : base_url+"admin/user/ubah_status_user",
    async : false,
    data:{id:id,status:status},
    success: function(data){
      $('#tabel_serverside').DataTable().ajax.reload();
    },
    error: function(xhr){
      let d = JSON.parse(xhr.responseText);
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: `${d.message}`,
        footer: '<a href="">Why do I have this issue?</a>'
      })
    }
  });
});
$('#tabel_serverside').on('click','.nonaktifkanstatus',function(){
  let id = $(this).attr('id');
  let status = 0;
  $.ajax({
    type : "POST",
    url  : base_url+"admin/user/ubah_status_user",
    async : false,
    data:{id:id,status:status},
    success: function(data){
      $('#tabel_serverside').DataTable().ajax.reload();
    },
    error: function(xhr){
      let d = JSON.parse(xhr.responseText);
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: `${d.message}`,
        footer: '<a href="">Why do I have this issue?</a>'
      })
    }
  });
});
function valueChecked(a){
  if (a == 1) {
    $('#valueChecked').html("Administrator");
  }else if (a == 2) {
    $('#valueChecked').html("Operator");
  }else{
    $('#valueChecked').html("");
  }

}
$('#tabel_serverside').on('click','.ubah_level_user',function(){
  let id = $(this).attr('id');
  let nama = $(this).attr('nama');

  Swal.fire({
    title: `Ubah level ${nama}`,
    // html: `<input type="text" id="password" class="swal2-input" placeholder="Password baru">`,
    html:`<div class="btn-group btn-group-toggle" data-toggle="buttons">
    <label class="btn btn-success active">
    <input type="radio" name="options" onclick="valueChecked(1)" value = "1" class = "level_user" autocomplete="off"> Administrator
    </label>
    &nbsp;
    <label class="btn btn-primary">
    <input type="radio" name="options" onclick="valueChecked(2)"  value = "2" class = "level_user" autocomplete="off"> Operator
    </label>
    </div>
    <div>
    <span id = "valueChecked">
    </div>`,
    confirmButtonText: 'Confirm',
    focusConfirm: false,
    preConfirm: () => {
      const level = Swal.getPopup().querySelector('input[name="options"]:checked').value

      return {level:level}
    }
  }).then((result) => {
    $.ajax({
      type : "POST",
      url  : base_url+'/admin/user/ubah_level_user',
      async : false,
      // dataType : "JSON",
      data : {level:result.value.level,id:id},
      success: function(data){
        $('#tabel_serverside').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: `Level ${nama} berhasil diubah.`,
          showConfirmButton: false,
          timer: 1500
        })
      },
      error: function(xhr){
        let d = JSON.parse(xhr.responseText);
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `${d.message}`,
          footer: '<a href="">Why do I have this issue?</a>'
        })
      }
    });

  })
})
$('#tabel_serverside').on('click','.btn_hapus_user',function(){
  id = $(this).attr('id');
  nama = $(this).attr('nama');
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: "User "+nama+" akan dihapus!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus user!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type  : 'post',
        url   : base_url+'/admin/user/hapus_user',
        async : false,
        // dataType : 'json',
        data:{id:id, nama:nama},
        success : function(data){
          //reload table
          $('#tabel_serverside').DataTable().ajax.reload();
          Swal.fire(
            'Deleted!',
            'User '+nama+' telah dihapus.',
            'success'
            )
        },
        error: function(xhr){
          let d = JSON.parse(xhr.responseText);
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: `${d.message}`,
            footer: '<a href="">Why do I have this issue?</a>'
          })
        }
      });
    }
  })
})
$('.tambah_data').on('click',function(){

  Swal.fire({
    title: `Tambah Page `,
    // html: `<input type="text" id="password" class="swal2-input" placeholder="Password baru">`,
    html:`<form id="form_add_data">
    <div class="form-group">
    <label for="email">Nama</label>
    <input type="email" class="form-control" id="page" aria-describedby="emailHelp" placeholder="Enter Nama Halaman">
    </div>
    </form>`,
    confirmButtonText: 'Confirm',
    focusConfirm: false,
    preConfirm: () => {
      const page = Swal.getPopup().querySelector('#page').value
      if (!page) {
        Swal.showValidationMessage('Silakan lengkapi data')
      }
      return {page:page}
    }
  }).then((result) => {
    $.ajax({
      type : "POST",
      url  : base_url+'/admin/page/tambah_page',
      async : false,
      // dataType : "JSON",
      data : {page:result.value.page},
      success: function(data){
        $('#tabel_serverside').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: `Halaman berhasil ditambahkan.`,
          showConfirmButton: false,
          timer: 1500
        })
      },
      error: function(xhr){
        let d = JSON.parse(xhr.responseText);
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `${d.message}`,
          footer: '<a href="">Why do I have this issue?</a>'
        })
      }
    });

  })
})

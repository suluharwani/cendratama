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
    return   '<a href="javascript:void(0);" class="btn btn-info btn-sm view_data_menu"  id="'+row[1]+'" >View Data</a> <a href="javascript:void(0);" class="btn btn-warning btn-sm editPage"  id="'+row[1]+'"  nama = "'+row[2]+'" >Edit</a> <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_hapus_menu" id="'+row[1]+'"  nama = "'+row[2]+'" >Hapus</a>';

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

$('#tabel_serverside').on('click','.view_data_menu',function(){
  let id = $(this).attr('id');

    $.ajax({
      type : "POST",
      url  : base_url+'/admin/page/detail',
      async : false,
      dataType : "JSON",
      data : {id:id},
      success: function(data){
        // $('#tabel_serverside').DataTable().ajax.reload();

        Swal.fire({
  title: `<strong>${data[0].page}</strong>`,
  icon: 'info',
  html:
    `<table class="table">
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Link</td>
      <td><a href = "${base_url+'page/'+data[0].slug}" target="_blank">${base_url+'page/'+data[0].slug}</a></td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Dibuat</td>
      <td>${data[0].created_at}</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>status</td>
      <td>status</td>
    </tr>
  </tbody>
</table>`,
  showCloseButton: true,
  showCancelButton: true,
  focusConfirm: false,
  confirmButtonText:
    '<i class="fa fa-thumbs-up"></i> Great!',
  confirmButtonAriaLabel: 'Thumbs up, great!',
  cancelButtonText:
    '<i class="fa fa-thumbs-down"></i>',
  cancelButtonAriaLabel: 'Thumbs down'
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
$('#tabel_serverside').on('click','.editPage',function(){
  let id = $(this).attr('id');
  let nama = $(this).attr('nama');

  Swal.fire({
    title: `Set Nama Halaman `,
    html: `<input type="text" id="page" class="swal2-input" placeholder="nama halaman baru" value= "${nama}">`,
    confirmButtonText: 'Confirm',
    focusConfirm: false,
    preConfirm: () => {
      const page = Swal.getPopup().querySelector('#page').value
      if (!page) {
        Swal.showValidationMessage('Silakan lengkapi data')
      }
      return {page: page }
    }
  }).then((result) => {
    $.ajax({
      type : "POST",
      url  : base_url+'/admin/page/update_page',
      async : false,
      // dataType : "JSON",
      data : {nama:nama,id:id,page:result.value.page},
      success: function(data){
        $('#tabel_serverside').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: `Halaman ${nama} berhasil diubah menjadi ${result.value.page}.`,
          showConfirmButton: false,
          timer: 2500
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
$('#tabel_serverside').on('click','.btn_hapus_menu',function(){
  id = $(this).attr('id');
  nama = $(this).attr('nama');
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: "Halaman "+nama+" akan dihapus!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus halaman!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type  : 'post',
        url   : base_url+'/admin/page/hapus_page',
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
    <label for="page">Nama</label>
    <input type="text" class="form-control" id="page" placeholder="Enter Nama Halaman">
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
$('.restore_data').on('click',function(){
tableRestoreData()
$('.modal_restore').modal('show')


})

function tableRestoreData(){
$('#tabelRestore').trigger("reset");
let isi = '' 
$.ajax({
    type : "POST",
    url  : base_url+"admin/page/deleted_page",
    async : false,
    dataType : 'json',
    data:{},
    success: function(data){
      let no = 1;
      isi+='<thead>'+
      '<tr>'+
      '<th scope="col" align="center" width="5%">#</th>'+
      '<th scope="col" align="center">Halaman</th>'+
      '<th scope="col" align="center">Action</th>'+
      '</tr>'+
      '</thead>'+
      '<tbody>';
      $.each(data, function(k, v)
      {
        console.log(data[k].page)
        isi +=  '<tr>'+
        '<td scope="row" align="center">'+ no++ +'</td>'+
        '<td align="left">'+data[k].page+'</td>'+
        '<td align="left"><a href="javascript:void(0);" class="btn btn-info btn-sm restore_page"  id="'+data[k].id+'" nama = "'+data[k].page+'"  >Restore</a></td>'+
        '</tr>';

      });
      isi+='</tbody>'

    }
  })
$('#tabelRestore').html(isi)
}
$('#tabelRestore').on('click','.restore_page',function(){
  id = $(this).attr('id');
  nama = $(this).attr('nama');
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: "Halaman "+nama+" akan dikembalikan!",
    icon: 'info',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, restore halaman!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type  : 'post',
        url   : base_url+'/admin/page/restore_page',
        async : false,
        // dataType : 'json',
        data:{id:id, nama:nama},
        success : function(data){
          //reload table
          tableRestoreData()
          $('#tabel_serverside').DataTable().ajax.reload();
          Swal.fire(
            'Restored!',
            'Halaman '+nama+' telah dikembalikan.',
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
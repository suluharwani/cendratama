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
      return   '<a href="javascript:void(0);" class="btn btn-success btn-sm view_data_category" nama_page = "'+row[2]+'" id="'+row[1]+'" >Category</a>  ';

    }},
   

    {mRender: function (data, type, row) {
    return   ' <a href="javascript:void(0);" class="btn btn-warning btn-sm editPage"  id="'+row[1]+'"  nama = "'+row[2]+'" >Edit</a> <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_hapus_menu" id="'+row[1]+'"  nama = "'+row[2]+'" >Hapus</a>';

    }
  }
  ],
  "columnDefs": [{
    "targets": [0,2,3],
    "orderable": false
  }],

  error: function(){  // error handling
    $(".tabel_serverside-error").html("");
    $("#tabel_serverside").append('<tbody class="tabel_serverside-error"><tr><th colspan="3">Data Tidak Ditemukan di Server</th></tr></tbody>');
    $("#tabel_serverside_processing").css("display","none");

  }

});
};
data()
function data(){
  let page = 'partner'
  let data = ''
  let param = ''
  $.ajax({
    type : "POST",
    url  : base_url+"admin/static_page/read",
    async : false,
    data:{page:page, data:data, param:param},
    success: function(data){

     tableCat(data);
  
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
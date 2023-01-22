let loc = window.location;
let base_url = loc.protocol + "//" + loc.hostname + (loc.port? ":"+loc.port : "") + "/";

list_menu()
function list_menu(){
    $.ajax({
    type : "POST",
    url  : base_url+`home/menu`,
    async : false,
    dataType : 'json',
    data:{},
    success: function(data){
    	let menu =  `<li class="order-1 dropdown dropdown-mega">
                        <a class="dropdown-item dropdown-toggle active" href="${base_url}">
                            Welcome
                        </a>           
                    </li>` ;
        no = 2;
    	 $.each(data, function(k, v)
        {

            menu += `<li class="order-${no++} dropdown dropdown-mega dropdown-mega-style-2" >`
        	menu += `<a class="dropdown-item dropdown-toggle" href="#">
					${data[k].page}
					</a>
                        <ul class="dropdown-menu">
            <li>
                <div class="dropdown-mega-content container">
                    <div class="row">`;
            
                menu += dropdown_cat(data[k].id);
            
			
            menu += `</div>
                </div>
            </li>
        </ul>
`;
        })
    	menu += `</li>`
      $("#mainNav").html(menu);

    }
  });
}
$('.btn_menu').on('click',function(){
    cat_id = $(this).attr('id');
    dropdown_cat(id)
})
function dropdown_cat(id=null){
if (id != null) {
let category = ``;
 
$.ajax({
    type : "POST",
    url  : base_url+`home/menu_cat`,
    async : false,
    dataType : 'json',
    data:{page_id : id},
    success: function(data){

        if (Object.keys(data).length<=6) {
        panjang = Object.keys(data).length
    }else{
        panjang = 6
    }
    	 $.each(data, function(k, v)
        {
        	category += `<div class="col-lg-${parseInt(12/panjang)}">
							<span class="dropdown-mega-sub-title"   >${data[k].category}</span>
							<ul class="dropdown-mega-sub-nav">`;

                category += dropdown_sub_cat(data[k].id)


							
		  category += `</ul>
						</div>`;
        })
    	

    }
  })
category += ``;
return category

  };

	
}

function dropdown_sub_cat(id=null){
	if (id != null) {
		let subCategory = "";

	$.ajax({
    type : "POST",
    url  : base_url+`home/menu_sub_cat`,
    async : false,
    dataType : 'json',
    data:{category_id : id},
    success: function(data){
    	 $.each(data, function(k, v)
        {
        	subCategory += `
					<li><a class="dropdown-item" href="">${data[k].sub_category}</a></li>
				`;
        })
         $(`.list_sub_cat_${id}`).html(subCategory);

     }
  });
		
	}
    

}
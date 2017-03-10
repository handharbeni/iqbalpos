<!-- Page Content -->
<div class="container">
<div class="row" style='min-height:80px;'>
  <div id='notif-top' style="margin-top:50px;display:none;" class="col-md-4 alert alert-success pull-right">
    <strong>Sukses!</strong> Data berhasil disimpan
  </div>
</div>
   <div class="row" style="margin-top:10px;">
      <table id="TableMain" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
              <tr>
                  <th class="text-center">Nama Supplier Bahan</th>
                  <th class="text-center">Alamat</th>
                  <th class="text-center">No. Telp</th>
                  <th class="text-center" class="hidden-xs">Email</th>
                  <th class="text-center" class="hidden-xs">Tanggal Buat</th>
                  <th class="text-center">Aksi</th>
              </tr>
          </thead>

          <tbody id='bodytable'>
            
          </tbody>
      </table>
   </div>
   <!-- Button trigger modal -->
   <button type="button" class="btn btn-add btn-lg"  onclick="showAdd()">
     Tambah Supplier Bahan
   </button>
</div>
<!-- /.container -->

<!-- Modal Add -->
<div class="modal fade" id="modalform" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tambah Supplier Bahan</h4>
      </div>
      <form action="" method="POST" id="myform">      
        <div class="modal-body">
           <div class="row">
             <div class="col-sm-12">
                <div class="form-group">
                 <label for="nama">Nama Supplier Bahan</label>
                 <input type="text" name="nama" maxlength="50" Required class="form-control" id="nama" placeholder="Nama Supplier Bahan">
                 <input type="hidden" name="id" maxlength="50" Required class="form-control" id="id" placeholder="ID Supplier Bahan">
               </div>
             </div>
             <div class="col-sm-12">
               <div class="form-group">
                 <label for="alamat">Alamat Supplier Bahan</label>
                 <input type="text" name="alamat" maxlength="30" class="form-control" id="alamat" placeholder="Alamat Supplier Bahan" required="">
               </div>
             </div>
             <div class="col-sm-6">
               <div class="form-group">
                 <label for="no_telp">No Telp Supplier Bahan</label>
                 <input type="text" maxlength="50" name="no_telp" class="form-control" id="no_telp" placeholder="No Telp Supplier Bahan" required="">
               </div>
             </div>
             <div class="col-sm-6">
               <div class="form-group">
                 <label for="email">Email Supplier Bahan</label>
                 <input type="email" maxlength="50" name="email" class="form-control" id="email" placeholder="Email Supplier Bahan" required="">
               </div>
             </div>
             <div class="col-sm-6">
               <div class="form-group">
                 <label for="id_provinsi">Provinsi</label>
                 <select  onchange='get_kota()' name="id_provinsi" class="form-control" id="id_provinsi" required="">
                 </select>
               </div>
             </div>
             <div class="col-sm-6">
               <div class="form-group">
                 <label for="id_kota">Kota</label>
                 <select name="id_kota" class="form-control" id="id_kota" required="">
                 </select>
                
               </div>
             </div>
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-add" id="aSimpan">Simpan</button>
        </div>
      </form>
    </div>
 </div>
</div>
<!-- /.Modal Add-->


<script type="text/javascript">
// initialize datatable
  var table    = $("#TableMain").DataTable();
  var jsonList = <?php echo $list; ?>;
  var jsonProv = <?php echo $list_prov; ?>;
  var jsonKota = <?php echo $list_kota; ?>;
 
  var awalLoad = true;
  
  loadData(jsonList);
  load_prov(jsonProv);
  
  function load_prov(json){
  	var html = "<option value='' selected disabled>Pilih Provinsi</option>";
  	for (var i=0;i<json.length;i++){
  	     html = html+ "<option value='"+json[i].id+"'>"+json[i].nama+"</option>";
  	}
  	$("#id_provinsi").html(html);
  }
  function load_kota(json){
    console.log(json);
    var html = "<option value='' selected disabled>Pilih Kota</option>";
    for (var i=0;i<json.length;i++){
         html = html+ "<option value='"+json[i].id+"'>"+json[i].nama+"</option>";
    }
    $("#id_kota").html(html);
  }
  
  function get_kota(){
  	if ($("#id_provinsi").val() == "" || $("#id_provinsi").val()==null){
  	   return false;
  	}
  	$("#id_kota").prop("disabled",true);
  	
  	$.ajax({
  	   url :"<?php echo base_url('Supplier_bahan/Master/get_kota')?>/",
  	   type : "GET",
  	   data :"id_prov="+$("#id_provinsi").val(),
  	   dataType : "json",
  	   success : function(data){
  	      $("#id_kota").prop("disabled",false);
  	      load_kota(data);
  	   }
  	});
  }
  function sync_kota(provinsi){
    $.ajax({
       url :"<?php echo base_url('Supplier_bahan/Master/get_kota')?>/",
       type : "GET",
       data :"id_prov="+provinsi,
       dataType : "json",
       success : function(data){
          $("#id_kota").prop("disabled",false);
          load_kota(data);
       }
    });
  }
  
  function loadData(json){
    //clear table
	  table.clear().draw();
	  for(var i=0;i<json.length;i++){
        table.row.add( [
            json[i].nama,
            json[i].alamat,
            json[i].no_telp,
            json[i].email,
            DateFormat.format.date(json[i].date_add, "dd-MM-yyyy HH:mm"),
            '<td class="text-center"><div class="btn-group" >'+
                '<a id="group'+i+'" class="divpopover btn btn-sm btn-default" href="javascript:void(0)" data-toggle="popover" data-placement="top" onclick="confirmDelete(this)" data-html="true" title="Hapus Data?" ><i class="fa fa-times"></i></a>'+
                '<a class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Ubah Data" onclick="showUpdate('+i+')"><i class="fa fa-pencil"></i></a>'+
               '</div>'+
            '</td>'
        ] ).draw( false );
	  }
	  if (!awalLoad){
		  $('.divpopover').attr("data-content","ok");
		  $('.divpopover').popover();
	  }
	  awalLoad = false;	 
  }
  
  
  function showAdd(){
    $("#myModalLabel").text("Tambah Supplier Bahan");
    $("#id").val("");
    $("#nama").val("");
    $("#alamat").val("");
    $("#no_telp").val("");
    $("#email").val("");
    load_prov(jsonProv);
    $("#modalform").modal("show");    
  }
  
  function showUpdate(i){
    load_prov(jsonProv);
    load_kota(jsonKota);

    $("#myModalLabel").text("Ubah Supplier Bahan");
    $("#id").val(jsonList[i].id);
    $("#nama").val(jsonList[i].nama);
    $("#alamat").val(jsonList[i].alamat);
    $("#no_telp").val(jsonList[i].no_telp);
    $("#email").val(jsonList[i].email);
  	$("#id_provinsi").val(jsonList[i].id_provinsi);
  	$("#id_kota").val(jsonList[i].id_kota);
	  $("#modalform").modal("show");
  }
  
  $("#myform").on('submit', function(e){
    e.preventDefault();
	  var action = "<?php echo base_url('Supplier_bahan/Master/add')?>/";
	  if ($("#id").val() != ""){
		  action = "<?php echo base_url('Supplier_bahan/Master/edit')?>/";
	  }
	  var param = $('#myform').serialize();
	  if ($("#id").val() != ""){
		 param = $('#myform').serialize()+"&id="+$('#id').val();
	  }
	  
    $.ajax({
      type: 'post',
      url: action,
      data: param,
	    dataType: 'json',
      beforeSend: function() { 
        // tambahkan loading
        $('#aSimpan').html('Sedang Menyimpan...');
      },
      success: function (data) {
  			if (data.status == '3'){
  				console.log("ojueojueokl"+data.status);
  				jsonList = data.list;
  				loadData(jsonList);
          $('#aSimpan').html('Simpan');
  				$("#modalform").modal('hide');
  				$("#notif-top").fadeIn(500);
  				$("#notif-top").fadeOut(2500);
  			}
      }
    });
  });
	
	function deleteData(element){
		var el = $(element).attr("id");
		console.log(el);
		var id  = el.replace("aConfirm","");
		var i = parseInt(id);
		//console.log(jsonList[i]);
		$.ajax({
          type: 'post',
          url: '<?php echo base_url('Supplier_bahan/Master/delete'); ?>/',
          data: {"id":jsonList[i].id},
		      dataType: 'json',
          beforeSend: function() { 
            // kasi loading
            $("#aConfirm"+i).html("Sedang Menghapus...");
          },
          success: function (data) {
      			if (data.status == '3'){
  				$("#notif-top").fadeIn(500);
  				$("#notif-top").fadeOut(2500);
      				jsonList = data.list;
      				loadData(jsonList);
      			}
          }    
        });
	}
	
	function confirmDelete(el){
		var element = $(el).attr("id");
		console.log(element);
		var id  = element.replace("group","");
		var i = parseInt(id);
    $(el).attr("data-content","<button class=\'btn btn-danger myconfirm\'  href=\'#\' onclick=\'deleteData(this)\' id=\'aConfirm"+i+"\' style=\'min-width:85px\'><i class=\'fa fa-trash\'></i> Ya</button>");
		$(el).popover();

	}
  

  
</script>

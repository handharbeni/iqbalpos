<!-- Page Content -->
<div class="container">
<div class="row" style='min-height:80px;'>
  <div id='notif-top' style="margin-top:50px;display:none;" class="col-md-4 alert alert-success pull-right">
    <strong>Sukses!</strong> Data berhasil disimpan
  </div>
</div>
  <div class="row">
    <h3><strong>Master</strong> - Supplier Produk</h3>
  </div>
   <div class="row" style="margin-top:10px;">
      <table id="TableMain" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
              <tr>
                  <th class="text-center no-sort">#</th>
                  <th class="text-center">Nama Supplier Produk</th>
                  <th class="text-center">Alamat</th>
                  <th class="text-center">No. Telp</th>
                  <th class="text-center">Email</th>
                  <th class="text-center">NPWP</th>
                  <th class="text-center">Bank</th>
                  <th class="text-center">Tanggal Buat</th>
                  <th class="text-center no-sort">Aksi</th>
              </tr>
          </thead>

          <tbody id='bodytable'>
            
          </tbody>
      </table>
   </div>
   <!-- Button trigger modal -->
   <button type="button" class="btn btn-add btn-lg"  onclick="showAdd()">
     Tambah Supplier Produk
   </button>
</div>
<!-- /.container -->

<!-- Modal Add -->
<div class="modal fade" id="modalform" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tambah Supplier Produk</h4>
      </div>
      <form action="" method="POST" id="myform">      
        <div class="modal-body">
           <div class="row">
             <div class="col-sm-12">
                <div class="form-group">
                 <label for="nama">Nama Supplier Produk</label>
                 <input type="text" name="nama" maxlength="50" Required class="form-control" id="nama" placeholder="Nama Supplier Produk">
                 <input type="hidden" name="id" maxlength="50" Required class="form-control" id="id" placeholder="ID Supplier Produk">
               </div>
             </div>
             <div class="col-sm-12">
               <div class="form-group">
                 <label for="alamat">Alamat Supplier Produk</label>
                 <input type="text" name="alamat" maxlength="30" class="form-control" id="alamat" placeholder="Alamat Supplier Produk" required="">
               </div>
             </div>
             <div class="col-sm-6">
               <div class="form-group">
                 <label for="no_telp">No Telp Supplier Produk</label>
                 <input type="number" min="0" maxlength="50" name="no_telp" class="form-control" id="no_telp" placeholder="No Telp Supplier Produk" required="">
               </div>
             </div>
             <div class="col-sm-6">
               <div class="form-group">
                 <label for="email">Email Supplier Produk</label>
                 <input type="email" maxlength="50" name="email" class="form-control" id="email" placeholder="Email Supplier Produk" required="">
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
             <div class="col-sm-6">
               <div class="form-group">
                 <label for="npwp">NPWP</label>
                 <input type="text" name="npwp" class="form-control" id="npwp" placeholder="NPWP">
               </div>
             </div>
             <div class="col-sm-6">
               <div class="form-group">
                 <label for="nama_bank">Nama Bank</label>
                 <input type="text" name="nama_bank" class="form-control" id="nama_bank" placeholder="Nama Bank">
               </div>
             </div>
             <div class="col-sm-6">
               <div class="form-group">
                 <label for="no_rekening">No. Rekening</label>
                 <input type="text" name="no_rekening" class="form-control" id="no_rekening" placeholder="Nomor Rekening">
               </div>
             </div>
             <div class="col-sm-6">
               <div class="form-group">
                 <label for="rekening_an">Rekening Atas Nama</label>
                 <input type="text" name="rekening_an" class="form-control" id="rekening_an" placeholder="Rekening Atas Nama">
               </div>
             </div>
             <div class="col-sm-12">
               <div class="form-group">
                 <label for="keterangan">Keterangan</label>
                 <textarea name="keterangan" class="form-control" id="keterangan" placeholder="Keterangan"></textarea>
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
  var table = $("#TableMain").DataTable({
    "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": "no-sort"
        } ],
        // "order": [[ 1, 'asc' ]]    
  });
  table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = "<span style='display:block' class='text-center'>"+(i+1)+"</span>";
        } );
  } ).draw();

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
  function load_kota(json, idProv=0){
    // console.log(json);
    var html = "<option value='' selected disabled>Pilih Kota</option>";
    for (var i=0;i<json.length;i++){
         if(json[i].id_provinsi == idProv){
          html = html+ "<option value='"+json[i].id+"'>"+json[i].nama+"</option>";
         }
    }
    $("#id_kota").html(html);
  }
  
  function get_kota(){
  	if ($("#id_provinsi").val() == "" || $("#id_provinsi").val()==null){
  	   return false;
  	}
  	$("#id_kota").prop("disabled",true);
  	
  	$.ajax({
  	   url :"<?php echo base_url('Master_supplier_produk/Master/get_kota')?>/",
  	   type : "GET",
  	   data :"id_prov="+$("#id_provinsi").val(),
  	   dataType : "json",
  	   success : function(data){
  	      $("#id_kota").prop("disabled",false);
  	      load_kota(data, $("#id_provinsi").val());
  	   }
  	});
  }
  function sync_kota(provinsi){
    $.ajax({
       url :"<?php echo base_url('Master_supplier_produk/Master/get_kota')?>/",
       type : "GET",
       data :"id_prov="+provinsi,
       dataType : "json",
       success : function(data){
          $("#id_kota").prop("disabled",false);
          load_kota(data, provinsi);
       }
    });
  }
  
  function loadData(json){
    //clear table
	  table.clear().draw();
	  for(var i=0;i<json.length;i++){
        table.row.add( [
            "",
            json[i].nama,
            json[i].alamat,
            json[i].no_telp,
            json[i].email,
            json[i].npwp,
            json[i].nama_bank,
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
    load_kota(jsonKota, 0);

    $("#myModalLabel").text("Tambah Supplier Produk");
    $("#id").val("");
    $("#nama").val("");
    $("#alamat").val("");
    $("#no_telp").val("");
    $("#email").val("");
    $("#npwp").val("");
    $("#nama_bank").val("");
    $("#no_rekening").val("");
    $("#rekening_an").val("");
    $("#keterangan").val("");
    load_prov(jsonProv);
    $("#modalform").modal("show");    
  }
  
  function showUpdate(i){
    load_prov(jsonProv);
    load_kota(jsonKota, jsonList[i].id_provinsi);

    $("#myModalLabel").text("Ubah Supplier Produk");
    $("#id").val(jsonList[i].id);
    $("#nama").val(jsonList[i].nama);
    $("#alamat").val(jsonList[i].alamat);
    $("#no_telp").val(jsonList[i].no_telp);
    $("#email").val(jsonList[i].email);
  	$("#id_provinsi").val(jsonList[i].id_provinsi);
  	$("#id_kota").val(jsonList[i].id_kota);
    $("#npwp").val(jsonList[i].npwp);
    $("#nama_bank").val(jsonList[i].nama_bank);
    $("#no_rekening").val(jsonList[i].no_rekening);
    $("#rekening_an").val(jsonList[i].rekening_an);
    $("#keterangan").val(jsonList[i].keterangan);
	  $("#modalform").modal("show");
  }
  
  $("#myform").on('submit', function(e){
    e.preventDefault();
    var notifText = 'Data berhasil ditambahkan!';
    var action = "<?php echo base_url('Master_supplier_produk/Master/add')?>/";
    if ($("#id").val() != ""){
      action = "<?php echo base_url('Master_supplier_produk/Master/edit')?>/";
      notifText = 'Data berhasil diubah!';
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
        $("#aSimpan").prop("disabled", true);
        $('#aSimpan').html('Sedang Menyimpan...');
      },
      success: function (data) {
        if (data.status == '3'){
          console.log("ojueojueokl"+data.status);
          jsonList = data.list;
          loadData(jsonList);
          $('#aSimpan').html('Simpan');
          $("#aSimpan").prop("disabled", false);
  				$("#modalform").modal('hide');
  				// $("#notif-top").fadeIn(500);
  				// $("#notif-top").fadeOut(2500);
          new PNotify({
                              title: 'Sukses',
                              text: notifText,
                              type: 'success',
                              hide: true,
                              delay: 5000,
                              styling: 'bootstrap3'
                            });
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
          url: '<?php echo base_url('Master_supplier_produk/Master/delete'); ?>/',
          data: {"id":jsonList[i].id},
		      dataType: 'json',
          beforeSend: function() { 
            // kasi loading
            $("#aConfirm"+i).html("Sedang Menghapus...");
            $("#aConfirm"+i).prop("disabled", true);
          },
          success: function (data) {
      			if (data.status == '3'){
            $("#aConfirm"+i).prop("disabled", false);
  				// $("#notif-top").fadeIn(500);
  				// $("#notif-top").fadeOut(2500);
              new PNotify({
                              title: 'Sukses',
                              text: 'Data berhasil dihapus!',
                              type: 'success',
                              hide: true,
                              delay: 5000,
                              styling: 'bootstrap3'
                            });
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

  //Hack untuk bootstrap popover (popover hilang jika diklik di luar)
  $(document).on('click', function (e) {
    $('[data-toggle="popover"],[data-original-title]').each(function () {
        //the 'is' for buttons that trigger popups
        //the 'has' for icons within a button that triggers a popup
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {                
            (($(this).popover('hide').data('bs.popover')||{}).inState||{}).click = false  // fix for BS 3.3.6
        }
    });
  });  
</script>

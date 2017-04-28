<style type="text/css">
  .product-details input[type="text"]{
    width: 5em !important;
  }
</style>
<div class="container-fluid">
   <div class="row">
    <div class="col-sm-12">
      <h3><strong>Transaksi</strong> - Penjualan</h3>
    </div>
   </div>
   <div class="row">
    <div class="col-md-5 left-side">
      <form action="<?php echo base_url('Transaksi_penjualan/Transaksi/doSubmit'); ?>" method="post" id="pembelian">          
         <div class="col-xs-8"> &nbsp; </div>         
         <div class="col-lg-7">
          <div class="form-group">
            <label class="label-control">Customer</label>
            <select class="js-select-options form-control" id="customerSelect" name="customer" required="required">
              <option value="0">Pilih Customer</option>
            </select>
          </div>
         </div>
         <div class="col-lg-5">
          <div class="form-group">
             <label for="paymentMethod" class="label-control">Metode Pembayaran</label>
             <select class="form-control" id="paymentMethod" name="paymentMethod" required="required"> </select>
           </div>
         </div>
         <div class="col-sm-12">
           <div class="form-group">
             <label for="catatan">Catatan</label>
             <textarea name="catatan" class="form-control" placeholder="Catatan" id="catatan"></textarea>
           </div>
         </div>
         <div class="col-sm-12">
         &nbsp;
         </div>
         <div class="col-xs-3 table-header text-center">
            <label>PRODUK</label>
         </div>
         <div class="col-xs-3 table-header nopadding text-center">
            <label>OPSI</label>
         </div>
         <div class="col-xs-3 table-header nopadding text-center">
            <label class="text-left">QTY</label>
         </div>
         <div class="col-xs-3 table-header nopadding text-left">
            <label class="text-left">SUBTOTAL (IDR)</label>
         </div>
         <div id="productList">
            <!-- product List goes here  -->
         </div>
         <div class="footer-section">
            <div class="table-responsive col-sm-12 totalTab">
               <table class="table">
                  <tr>
                     <td class="active" width="40%">Total Qty</td>
                     <td class="whiteBg" width="60%"><span id="Subtot"></span>
                        <span class="float-right"><b><span id="eTotalItem"></span> Item</b></span>
                     </td>
                  </tr>
                  <tr>
                     <td class="active">Total Harga (IDR)</td>
                     <td class="whiteBg light-blue text-bold text-right"><span id="eTotal" class="money"></span></td>
                  </tr>
               </table>
            </div>
            <button type="button" onclick="cancelOrder()" class="btn btn-red col-md-6 flat-box-btn"><h5 class="text-bold">Cancel</h5></button>
            <button type="button" class="btn btn-green col-md-6 flat-box-btn" onclick="payment()" id="btnDoOrder"><h5 class="text-bold">Proses Transaksi</h5></button>
         </div>
        </form>

      </div>
      <div class="col-md-7 right-side nopadding">
        <div class="row row-horizon" id="kategoriGat">
            <span class="categories selectedGat" id="gat-0">
              <i class="fa fa-home" onclick="filterProdukByKategori(0)"></i>
            </span>
        </div>
        <div class="col-sm-12">
           <div id="searchContaner">
               <div class="input-group stylish-input-group">
                   <input type="text" id="searchProd" class="form-control"  placeholder="Search" oninput="search()">
                   <span class="input-group-addon">
                       <button type="submit">
                           <span class="glyphicon glyphicon-search"></span>
                       </button>
                   </span>
               </div>
          </div>
        </div>
       <div id="productList2">
       </div>
      </div>
   </div>
</div>
<!-- /.container -->
  <!-- Modal -->
  <div class="modal fade" id="modalpayment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="Addpayament">Proses Pembayaran</h4>
        </div>
        <form method="POST" action="<?php echo base_url('Transaksi_penjualan/Transaksi/payment'); ?>" id="formpayment">
        <div class="modal-body">
             <div class="form-group">
               <h2 id="TotalModal"></h2>
            </div>
             <!-- <div class="form-group">
               <label for="paymentMethod" class="label-control">Metode Pembayaran</label>
               <select class="form-control" id="paymentMethod" name="paymentMethod">
                 <option value="0">Cash</option>
                 <option value="1">BNI</option>
                 <option value="2">Mandiri</option>
                 <option value="3">BNI</option>
                 <option value="4">TRANSFER</option>
              </select>
             </div> -->
             <div class="form-group hidden" style="visibility: hidden;">
               <label for="jenisOrder">Jenis Order</label>
               <input type="hidden" name="id_customer" id="idCustomer">
               <select class="form-control" id="jenisOrder" name="jenisOrder">
                 <option value="1">Take Away</option>
                 <option value="2">Dropship</option>
              </select>
             </div>
             <!-- <div class="form-group">
               <label for="catatan">Catatan</label>
               <textarea name="catatan" class="form-control" placeholder="Catatan" id="catatan"></textarea>
             </div> -->
             <div class="form-group Paid">
               <label for="Paid">Nominal (IDR)</label>
               <div class="input-group">
                <span class="input-group-addon">Rp</span> 
                <input type="text" value="0" name="paid" class="form-control money" id="Paid" placeholder="Nominal">
               </div>
             </div>
             <div class="form-group CreditCardNum">
               <i class="fa fa-cc-visa fa-2x" id="visa" aria-hidden="true"></i>
               <i class="fa fa-cc-mastercard fa-2x" id="mastercard" aria-hidden="true"></i>
               <i class="fa fa-cc-amex fa-2x" id="amex" aria-hidden="true"></i>
               <i class="fa fa-cc-discover fa-2x" id="discover" aria-hidden="true"></i>
               <label for="CreditCardNum">Nomor Kartu Kredit</label>
               <input type="text" class="form-control cc-num" id="CreditCardNum" placeholder="Nomor Kartu Kredit">
             </div>
             <div class="clearfix"></div>
             <div class="form-group CreditCardHold col-md-4 padding-s">
               <input type="text" class="form-control" id="CreditCardHold" placeholder="CVV">
             </div>
             <div class="form-group CreditCardHold col-md-2 padding-s">
               <input type="text" class="form-control" id="CreditCardMonth" placeholder="Bulan">
             </div>
             <div class="form-group CreditCardHold col-md-2 padding-s">
               <input type="text" class="form-control" id="CreditCardYear" placeholder="TAHUN">
             </div>
             <div class="form-group CreditCardHold col-md-4 padding-s">
               <input type="text" class="form-control" id="CreditCardCODECV" placeholder="VCC">
             </div>
             <div class="form-group ChequeNum">
               <label for="ChequeNum">Nomor Referensi</label>
               <input type="text" name="chequenum" class="form-control" id="ChequeNum" placeholder="Nomor Referensi" value="0">
             </div>
            <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>          
          <button type="submit" class="btn btn-add" id="btnBayar">Bayar</button>
        </div>
        </form>
      </div>
   </div>
  </div>
  <!-- /.Modal -->

<script type="text/javascript">
  function maskInputMoney(){
    $('.money').mask('#.##0', {reverse: true});
  }
  function unmaskInputMoney(){
    $('.money').unmask();
  }

      $('.Paid').show();
      $('.ReturnChange').show();
      $('.CreditCardNum').hide();
      $('.CreditCardHold').hide();
      $('.ChequeNum').hide();
      $('.stripe-btn').hide();

      $("#paymentMethod").change(function(){
         var p_met = $(this).find('option:selected').val();
         if (p_met === '0') {
            $('.Paid').show();
            $('.ReturnChange').show();
            $('.CreditCardNum').hide();
            $('.CreditCardHold').hide();
            $('.CreditCardMonth').hide();
            $('.CreditCardYear').hide();
            $('.CreditCardCODECV').hide();
            $('#CreditCardNum').val('');
            $('#CreditCardHold').val('');
            $('#CreditCardYear').val('');
            $('#CreditCardMonth').val('');
            $('#CreditCardCODECV').val('');
            $('.stripe-btn').hide();
            $('.ChequeNum').hide();
         } else {
            $('.Paid').show();
            $('.ReturnChange').hide();
            $('.CreditCardNum').hide();
            $('.CreditCardHold').hide();
            $('.CreditCardMonth').hide();
            $('.CreditCardYear').hide();
            $('.CreditCardCODECV').hide();
            $('#CreditCardNum').val('');
            $('#CreditCardHold').val('');
            $('#CreditCardYear').val('');
            $('#CreditCardMonth').val('');
            $('#CreditCardCODECV').val('');
            $('.stripe-btn').hide();
            $('.ChequeNum').show();
         }
      });

  var currentCustomerId = 0;
  var listProduct = <?php echo $list_produk; ?>;
  var listOrder = <?php echo $list_order; ?>;
  var listCustomer = <?php echo $list_customer; ?>;
  var listKategori = <?php echo $list_kategori; ?>;
  var listMetodePembayaran = <?php echo $list_metode_pembayaran; ?>;
  var listWarna = "";
  var listUkuran = "";
  var tax = '<?php echo $tax; ?>';
  var discount = '<?php echo $discount; ?>';
  var total = '<?php echo $total; ?>';
  var totalItems = '<?php echo $total_items; ?>';
  maskInputMoney();
  inits(tax, discount, total, totalItems);
  load_customer(listCustomer);
  load_order(listOrder);
  load_metode_pembayaran(listMetodePembayaran);

  function load_customer(json){
    var html = "";
    $("#customerSelect").html('');
    html = "<option value='0' selected disabled>Pilih Customer</option>";
    $("#customerSelect").append(html);
    for (var i=0;i<json.length;i++){
      html = "<option value=\'"+json[i].id+"\'>"+json[i].nama+"</option>";
      $("#customerSelect").append(html);
    }
  }
  function load_product(json){
    var html = "";
    $("#productList2").html('');
    var color = 2;
    for (var i=0;i<json.length;i++){
      if(color == 7) { color = 1; }
      var colorClass = 'color0' + color; color++;
      html = "<div class='col-sm-2 col-xs-3' style='display: block;'>"+
              "<a href='javascript:void(0)' class='addPct' id=\'product-"+json[i].id+"\' onclick=\'addToCart("+json[i].id+")\'>"+
                "<div class='product "+colorClass+" flat-box waves-effect waves-block'>"+
                  "<h3 id='proname'>"+json[i].nama+"</h3>"+
                  "<div class='mask'>"+
                    "<h3>Rp <span class='money'>"+json[i].harga_beli+"</span></h3>"+
                    "<p>"+json[i].deskripsi+"</p>"+
                  "</div>"+
                  // "<img src='#' alt=\'"+json[i].id_kategori+"\'>"+
                  "<img src='<?php echo base_url('upload/produk')?>/"+json[i].foto+"'>"+
                "</div>"+
              "</a>"+
             "</div>";
      $("#productList2").append(html);
    }
  }
  function load_order(json){
    var html = "";
    var option = "";
    var select = "";
    $("#productList").html("");
      for (var i=0;i<json.length;i++){
        html = "<div class='col-xs-12'>"+
                  "<div class='panel panel-default product-details'>"+
                      "<div class='panel-body' style=''>"+
                          "<div class='col-xs-3 nopadding'>"+
                              "<div class='col-xs-4 nopadding'>"+
                                  "<a href='javascript:void(0)' onclick=delete_order(\'"+json[i].rowid+"\')>"+
                                  "<span class='fa-stack fa-sm productD'>"+
                                    "<i class='fa fa-circle fa-stack-2x delete-product'></i>"+
                                    "<i class='fa fa-times fa-stack-1x fa-fw fa-inverse'></i>"+
                                  "</span>"+
                                  "</a>"+
                              "</div>"+
                              "<div class='col-xs-8 nopadding'>"+
                                "<span class='textPD'>"+json[i].produk+"</span>"+
                              "</div>"+
                          "</div>"+
                          "<div class='col-xs-3'>"+
                            "<span class='textPD'>"+
                              "<select name=ukuran id=\'uk-"+json[i].rowid+"\' class=\'form-control\' onchange=updateOption(\'"+json[i].rowid+"\') title='Pilih Ukuran'>"+
                                "<option value=0 select disabled>Pilih Ukuran</option>"+
                              "</select>"+
                            "</span>"+
                            "<span class='textPD'>"+
                              "<select name=warna id=\'wr-"+json[i].rowid+"\' class=\'form-control\' onchange=updateOption(\'"+json[i].rowid+"\') title='Pilih Warna'>"+
                                "<option value=0 select disabled>Pilih Warna</option>"+
                              "</select>"+
                            "</span>"+
                          "</div>"+
                          "<div class='col-xs-3 productNum'>"+
                            "<span class='textPD'>"+
                            "<input id=\'qt-"+json[i].rowid+"\' class='form-control' value='"+json[i].qty+"' placeholder='0' maxlength='4' type='text' onchange=updateQty(\'"+json[i].rowid+"\')>"+
                            "</span>"+
                          "</div>"+
                          "<div class='col-xs-3 nopadding productNum'>"+
                            "<span class='textPD pull-right'>"+json[i].subtotal+"</span>"+
                          "</div>"+
                      "</div>"+
                  "</div>"+
              "</div>";
        $("#productList").append(html);
        loadUkuran(json[i].id, json[i].rowid, listUkuran, json[i].ukuran);
        loadWarna(json[i].id, json[i].rowid, listWarna, json[i].warna);
      }
  }
  function loadUkuran(rid, id, json, pilih){
    $.ajax({
      url :"<?php echo base_url('Transaksi_purchaseorder/Transaksi/getUkuran')?>/"+rid,
      type : "GET",
      data :"",
      dataType : "json",
      success : function(data){
        var html = "";
        $("#uk-"+id).html('');
        html = "<option value='0' selected>Tidak Ada Ukuran</option>";
        $("#uk-"+id).append(html);
        for (var i=0;i<data.length;i++){
          var pilihs = "";
          if(data[i].id == pilih){
            pilihs = "selected";
          }
          html = "<option value=\'"+data[i].id+"\' "+pilihs+">"+data[i].nama+"</option>";
          $("#uk-"+id).append(html);
        }
      }
    });     
  }
  function updateOption(id){
    var ukuran = $("#uk-"+id).val();
    var warna = $("#wr-"+id).val();
    var totalBerat = $("#tb-"+id).val();
    $.ajax({
      url :"<?php echo base_url('Transaksi_penjualan/Transaksi/updateOption')?>/"+id+"/"+warna+"/"+ukuran+"/"+totalBerat,
      type : "GET",
      data :"",
      dataType : "json",
      success : function(data){
        load_order(data);
        fillInformation();
      }
    });    
  }
  function updateHargaBeli(id){
    var hb = $('#hb-'+id).val();
    $.ajax({
      url :"<?php echo base_url('Transaksi_penjualan/Transaksi/updateHargaBeli')?>/"+id+"/"+hb,
      type : "GET",
      data :"",
      dataType : "json",
      success : function(data){
        load_order(data);
        fillInformation();
      }
    });    
  }
  function updateQty(id){
    var qty = $("#qt-"+id).val() || 0;
    $.ajax({
      url :"<?php echo base_url('Transaksi_penjualan/Transaksi/updateQty')?>/"+id+"/"+qty,
      type : "GET",
      data :"",
      dataType : "json",
      success : function(data){
        if(data.status == 2){        
          load_order(data.list);
          fillInformation();
        }else if(data.status == 1){
          var list = data.list;
          var elem = $("#qt-"+data.id);
          var getRow = list.filter(function (index) { return index.rowid == data.id }) || 0;

          $.confirm({
              title: 'Stok',
              content: 'Stok Tidak Mencukupi <br>Max Qty: <b>' + getRow[0].qty + "</b>",
              buttons: {
                  ok: function () {
                    $(elem).val(parseInt(getRow[0].qty)); 
                    // $(elem).trigger('change'); 
                  }
                }
          }); 
        }
      }
    });
  }
  function loadWarna(rid, id, json, pilih){
    $.ajax({
      url :"<?php echo base_url('Transaksi_purchaseorder/Transaksi/getWarna')?>/"+rid,
      type : "GET",
      data :"",
      dataType : "json",
      success : function(data){
        var html = "";
        $("#wr-"+id).html('');
        html = "<option value='0' selected>Tidak Ada Warna</option>";
        $("#wr-"+id).append(html);
        for (var i=0;i<data.length;i++){
          var pilihs = "";
          if(data[i].id == pilih){
            pilihs = "selected";
          }      
          html = "<option value=\'"+data[i].id+"\' "+pilihs+">"+data[i].nama+"</option>";
          $("#wr-"+id).append(html);
        }
      }
    });    
  }
  function payment(){
    $("#modalpayment").modal("show");
  }
  function filterProduk(){
    // alert($("#customerSelect").find(":selected").text());
    $("#idCustomer").val($("#customerSelect").val());
    load_product(listProduct);
    load_kategori(listKategori);
  }
  function load_kategori(json){
    var html = "";
    $("#kategoriGat").html('');
    html = "<span class='categories selectedGat' onclick=filterProdukByKategori(0) id=\'gat-0\'><i class='fa fa-home'></i></span>";
    $("#kategoriGat").append(html);
    for (var i=0;i<json.length;i++){
      html = "<span class='categories' onclick=filterProdukByKategori(\'"+json[i].id+"\') id=\'gat-"+json[i].id+"\'>"+json[i].nama+"</span>";
      $("#kategoriGat").append(html);
    }
  }
  function load_metode_pembayaran(json){
    var html = "";
    $("#paymentMethod").html('');
    html = "<option value='' disabled selected>Pilih Metode Pembayaran</option>"
          +"<option value='0'>Cash</option>";
    $("#paymentMethod").append(html);
    for (var i=0;i<json.length;i++){
      html = "<option value=\'"+json[i].id+"\'>"+json[i].nama+"</option>";
      $("#paymentMethod").append(html);
    }
  }
  function filterProdukByKategori(id){
    var keyword = $("#searchProd").val();
    var supplier = $("#supplierSelect").val();
    $( ".categories" ).removeClass('selectedGat');
    $( "#gat-"+id ).addClass( "selectedGat" );    
    if(supplier != 0){    
      $.ajax({
        url :"<?php echo base_url('Transaksi_penjualan/Transaksi/filterProdukByKategori')?>/"+id+"/"+keyword,
        type : "GET",
        data :"",
        dataType : "json",
        success : function(data){
          load_product(data);
        }
      });
    }
  }
  function search(){
    var keyword = $("#searchProd").val();
    var kategori = $(".selectedGat").attr('id');
    var realkategori = "";
    if(kategori != null || kategori != undefined){    
      realkategori = kategori;
    }
    $.ajax({
      url :"<?php echo base_url('Transaksi_penjualan/Transaksi/filterProdukByName')?>",
      type : "POST",
      data : "keyword="+keyword+"&kategori="+realkategori,
      dataType : "json",
      success : function(data){
        load_product(data);
      }
    });
  }
  function addToCart(id){
    $.ajax({
      url :"<?php echo base_url('Transaksi_penjualan/Transaksi/tambahCart')?>/"+id,
      type : "POST",
      data :"idCustomer="+$("#customerSelect").val(),
      dataType : "json",
      success : function(data){
        if(data.status==2){
          load_order(data.list);
          fillInformation();
        }else if(data.status==1){
          $.confirm({
              title: 'Stok',
              content: 'Stok Tidak Mencukupi',
              buttons: {
                  ok: function () {
                  }
                }
          }); 
        }else if(data.status == 0){
          $.confirm({
              title: 'Harga',
              content: 'Harga Customer Belum Diset, Hubungi Admin!!',
              buttons: {
                  ok: function () {                    
                  }
                }
          }); 
        }
      }
    });
  }
  function delete_order(id){
    $.ajax({
      url :"<?php echo base_url('Transaksi_penjualan/Transaksi/deleteCart')?>/"+id,
      type : "GET",
      data :"",
      dataType : "json",
      success : function(data){
        load_order(data);
        fillInformation();
      }
    });    
  }
  function changeOption(id){
    var qty = $("#qt-"+id).val();
    var option = $("#stok-"+id).val();
    $.ajax({
      url :"<?php echo base_url('Transaksi_penjualan/Transaksi/updateOption')?>/"+id+"/"+option,
      type : "GET",
      data :"",
      dataType : "json",
      success : function(data){
        load_order(data);
        fillInformation();
      }
    });
  }

  $("#customerSelect").on("select2:open", function (e) { 
    saveCurrentCustomer();
  });
  $("#customerSelect").on("select2:select", function (e) { 
    changeCustomer();
  });
  function saveCurrentCustomer() {
    currentCustomerId = $("#customerSelect :selected").val();
  }
  function changeCustomer(){
    var productList = $("#productList");
    var customerId = currentCustomerId;
    if(productList.html().length > 0) {
      $.confirm({
            title: 'Konfirmasi',
            content: 'Anda yakin ingin mengganti customer?',
            buttons: {
                ok: function () {
                  //clear server cart first
                  doClear(false); 
                  //change customer  
                  filterProduk();
                },
                cancel: function () {
                  //returning to previous selected value
                  $("#customerSelect").val(customerId);
                  $("#customerSelect").trigger('change.select2'); // Notify only Select2 of changes
                  saveCurrentCustomer();
                }
              }
        }); 
    }
    else {
      filterProduk();
    }
  }
  function add_qty(id){
    var lastValue = $("#qt-"+id).val();
    lastValue = parseInt(lastValue) + 1;
    $("#qt-"+id).val(lastValue);
    change_total(id, 'tambah');
  }
  function reduce_qty(id){
    var lastValue = $("#qt-"+id).val();
    if(parseInt(lastValue) > 1){    
      lastValue = parseInt(lastValue) - 1;
      $("#qt-"+id).val(lastValue);
    }else{
      delete_order(id);
    }
    change_total(id, 'kurang');
  }
  function change_total(id, state){
    var qty = $("#qt-"+id).val();
    $.ajax({
      url :"<?php echo base_url('Transaksi_penjualan/Transaksi/updateCart')?>/"+id+"/"+qty+"/"+state,
      type : "GET",
      data :"",
      dataType : "json",
      success : function(data){
        if(data.status == 2){        
          load_order(data.list);
          fillInformation();
        }else if(data.status == 1){
          $.confirm({
              title: 'Stok',
              content: 'Stok Tidak Mencukupi',
              buttons: {
                  ok: function () {                      
                  }
                }
          });           
        }
      }
    });
  }
  function inits(etax, ediscount, etotal, etotal_items){
    unmaskInputMoney(); 
    $("#eTax").val(etax);
    $("#eDiscount").val(ediscount);
    $("#eTotal").html(etotal);    
    $("#eTotalItem").html(etotal_items);   
    maskInputMoney(); 
  }
  function fillInformation(){
    $.ajax({
      url :"<?php echo base_url('Transaksi_penjualan/Transaksi/getTotal')?>",
      type : "GET",
      data :"",
      success : function(data){        
        var jsonObjectParse = JSON.parse(data);
        var jsonObjectStringify = JSON.stringify(jsonObjectParse);
        var jsonObjectFinal = JSON.parse(jsonObjectStringify);
        var etx = jsonObjectFinal.tax;
        var edc = jsonObjectFinal.discount;
        var etl = jsonObjectFinal.total;
        var eti = jsonObjectFinal.total_items; 
        inits(etx, edc, etl, eti);
        totalItems = eti;
      }
    });    
  }
  function cancelOrder(){
      var defaultHtml = $('#btnDoOrder').html();
      $.confirm({
          title: 'Batal',
          content: 'Batalkan Transaksi ?',
          buttons: {
              confirm: function () {
                  doClear();
              },
              cancel: function () {
                  // $.alert('Canceled!');
                  $('#btnDoOrder').html(defaultHtml);
                  $("#btnDoOrder").prop("disabled", false);  
              }
          }
      });    
  }
  function doClear(reload){
    if(reload != false) {
      reload = true;
    }
    // var productList = $("#productList");
    $('#btnDoOrder').html("<h5 class=\'text-bold\'>Clearing...</h5>");
    $("#btnDoOrder").prop("disabled", true);    
    $.ajax({
      url :'<?php echo base_url("Transaksi_penjualan/Transaksi/destroyCart"); ?>',
      type : $('#pembelian').attr('method'),
      data : $('#pembelian').serialize(),
      dataType : "json",
      success : function(data){
        // console.log(data);        
        load_order(data);
        fillInformation();        
        $('#btnDoOrder').html("<h5 class=\'text-bold\'>Proses Transaksi</h5>");
        $("#btnDoOrder").prop("disabled", false);
        // window.close();
        if (reload == true) {
          window.location.reload(false);
        }
      }
    });    
  }
  function doSubmit(){
    $.ajax({
      url :$('#pembelian').attr('action'),
      type : $('#pembelian').attr('method'),
      data : $('#pembelian').serialize(),
      dataType : "json",
      success : function(data){        
        load_order(data);
        fillInformation();        
        $('#btnDoOrder').html("<h5 class=\'text-bold\'>Proses Transaksi</h5>");
        $("#btnDoOrder").prop("disabled", false);
        // window.close();
        window.location.reload(false);
      }
    });    
  }
  $(document).ready(function(){
    $("#formpayment").on('submit', function(e){
      e.preventDefault();      
      var defaultHtml = $('#btnBayar').html();
      var paymentMethod = $("#paymentMethod").val();
      var catatan = $("#catatan").val();
      $('#btnBayar').text("Saving...");
      $("#btnBayar").prop("disabled", true);      
      $.ajax({
        url :$('#formpayment').attr('action'),
        type : $('#formpayment').attr('method'),
        data : $('#formpayment').serialize() 
                + "&paymentMethod=" +paymentMethod
                + "&catatan=" +catatan,
        dataType : "json",
        success : function(data){
          $("#modalpayment").modal('hide');
          $('#btnBayar').html(defaultHtml);
          $("#btnBayar").prop("disabled", false);
          // window.location.reload(false);
          
          var datas = <?php echo json_encode(array()); ?>;
          load_order(datas);
          fillInformation();
          window.open("<?php echo base_url('Transaksi_penjualan/Transaksi/invoices'); ?>/"+data.idOrder, "_blank");
        }
      });
      maskInputMoney();
    });
    $("#pembelian").on('submit', function(e){
      $('#btnDoOrder').html("<h5 class=\'text-bold\'>Saving...</h5>");
      $("#btnDoOrder").prop("disabled", true);
      e.preventDefault();
      $.confirm({
          title: 'Confirm!',
          content: 'Simple confirm!',
          buttons: {
              confirm: function () {
                  doSubmit();
              },
              cancel: function () {                  
              }
          }
      });      
    });
  });
</script>
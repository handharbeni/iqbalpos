<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Transaksi extends MX_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model('Transaksipenjualanmodel');
    }
    function index(){
    	$this->load->view('Transaksi_penjualan/view');
    }
    function detail($id = 0){
    	$data['id'] = $id;
    	$this->load->view('Transaksi_penjualan/detail', $data);
    }
    function data(){
		$requestData= $_REQUEST;
		$columns = array( 
			0 	=>	'id', 
			1 	=>	'id_customer', 
			2 	=> 	'catatan',
			3	=> 	'total_berat',
			4	=> 	'total_qty',
			5	=> 	'biaya_kirim',
			6	=> 	'grand_total',
			7	=> 	'jenis_order',
			8	=> 	'status',
			9	=> 	'date_add',
			10	=> 	'aksi'
		);
		$sql = " SELECT t_order.* , m_customer.nama as namacus, m_metode_pembayaran.nama as namamet";
		$sql.= " FROM t_order ";
		$sql.= " LEFT JOIN m_customer ON t_order.id_customer = m_customer.id ";
		$sql.= " LEFT JOIN m_metode_pembayaran ON t_order.id_metode_pembayaran = m_metode_pembayaran.id ";
		$query=$this->Transaksipenjualanmodel->rawQuery($sql);
		$totalData = $query->num_rows();
		$totalFiltered = $totalData;
		$sql.=" WHERE t_order.deleted=1 ";
		if( !empty($requestData['search']['value']) ) {
			$sql.=" AND ( id_customer LIKE '".$requestData['search']['value']."%' ";    
			$sql.=" OR catatan LIKE '".$requestData['search']['value']."%' ";
			$sql.=" OR total_berat LIKE '".$requestData['search']['value']."%' ";
			$sql.=" OR total_qty LIKE '".$requestData['search']['value']."%' ";
			$sql.=" OR biaya_kirim LIKE '".$requestData['search']['value']."%' ";
			$sql.=" OR total_harga_barang LIKE '".$requestData['search']['value']."%' )";
		}
		$query=$this->Transaksipenjualanmodel->rawQuery($sql);
		$totalFiltered = $query->num_rows();
		$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; 
		$query=$this->Transaksipenjualanmodel->rawQuery($sql);
		$data = array();
		foreach ($query->result_array() as $row) {
			$nestedData		=	array(); 

			$nestedData[] 	= 	$row["id"];
			$nestedData[] 	= 	$row["namacus"];
			$nestedData[] 	= 	$row["catatan"];
			$nestedData[] 	= 	$row["total_berat"];
			$nestedData[] 	= 	$row["total_qty"];
			$nestedData[] 	= 	$row["biaya_kirim"];
			$nestedData[] 	= 	$row["total_harga_barang"];
			$nestedData[] 	= 	$row["jenis_order"];
			$nestedData[] 	= 	$row["status"];
			$nestedData[] 	= 	$row["date_add"];
			$nestedData[] 	= 	"<button class='btn btn-success' onclick=detail('".$row["id"]."')>DETAIL</button>";			
			$data[] = $nestedData;
		}
		$json_data = array(
					"draw"            => intval( $requestData['draw'] ),
					"recordsTotal"    => intval( $totalData ),
					"recordsFiltered" => intval( $totalFiltered ),
					"data"            => $data
					);
		echo json_encode($json_data);
    }
    function data_detail($id_po){
		$requestData= $_REQUEST;
		$columns = array( 
			0 	=>	'podid', 
			1 	=> 	'produk',
			2	=> 	'ukuran',
			3	=> 	'warna',
			4	=> 	'jumlah',
			5	=> 	'total_berat',
			6	=> 	'harga_beli',
			7	=> 	'harga_jual',
			8	=> 	'total_harga',
			9	=> 	'profit'
		);
		$sql = "SELECT 
					t_order.id as poid,
					t_order_detail.id as podid, 
					t_order_detail.jumlah as podjm,
					t_order_detail.total_berat as podtb, 
					t_order_detail.harga_beli as podhb, 
					t_order_detail.harga_jual as podhj, 
					t_order_detail.total_harga as podth, 
					t_order_detail.profit as podp, 
					m_produk_ukuran.nama as ukuran,
					m_produk_warna.nama as warna,
					m_produk.nama as nama,
					m_produk.sku as sku";
		$sql.=" FROM t_order";
		$sql.=" LEFT JOIN t_order_detail ON t_order.id = t_order_detail.id_order";
		$sql.=" LEFT JOIN m_produk on t_order_detail.id_produk = m_produk.id";
		$sql.=" LEFT JOIN m_produk_ukuran on t_order_detail.id_ukuran = m_produk_ukuran.id";
		$sql.=" LEFT JOIN m_produk_warna on t_order_detail.id_warna = m_produk_warna.id";
		$sql.=" WHERE t_order.deleted=1 ";
		$sql.=" AND t_order_detail.id_order=".$id_po;
		if( !empty($requestData['search']['value']) ) {
			$sql.=" AND ( m_produk.nama LIKE '".$requestData['search']['value']."%' ";
			$sql.=" OR m_produk.sku LIKE '".$requestData['search']['value']."%' ";
			$sql.=" OR m_produk.kode_barang LIKE '".$requestData['search']['value']."%' ";
			$sql.=" OR m_produk.deskripsi LIKE '".$requestData['search']['value']."%' )";
		}
		$query=$this->Transaksipenjualanmodel->rawQuery($sql);
		$totalData = $query->num_rows();
		$totalFiltered = $totalData;		
		$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; 
		$query=$this->Transaksipenjualanmodel->rawQuery($sql);
		$totalFiltered = $query->num_rows();
		$data = array();
		$i=1;
		foreach ($query->result_array() as $row) {
			$nestedData		=	array(); 
			$nestedData[] 	= 	$i;
			$nestedData[] 	= 	$row['nama'];
			$nestedData[] 	= 	$row['ukuran'];
			$nestedData[] 	= 	$row['warna'];
			$nestedData[] 	= 	$row['podjm'];
			$nestedData[] 	= 	$row['podtb'];
			$nestedData[] 	= 	$row['podhb'];
			$nestedData[] 	= 	$row['podhj'];
			$nestedData[] 	= 	$row['podth'];
			$nestedData[] 	= 	$row['podp'];
			$data[] = $nestedData;
			$i++;
		}
		$json_data = array(
					"draw"            => intval( $requestData['draw'] ),
					"recordsTotal"    => intval( $totalData ),
					"recordsFiltered" => intval( $totalFiltered ),
					"data"            => $data
					);
		echo json_encode($json_data);
    }
    function getCustomer(){
    	$dataSelect['deleted'] = 1;
    	$selectData = $this->Transaksipenjualanmodel->select($dataSelect, 'm_customer');
    	return json_encode($selectData->result_array());
    }
    function getKategori(){
    	$dataSelect['deleted'] = 1;
    	$selectData = $this->Transaksipenjualanmodel->select($dataSelect, 'm_produk_kategori');
    	return json_encode($selectData->result_array());
    }
    function getOrder(){
    	$data = array();
    	foreach ($this->cart->contents() as $items){
    		$idProduks = explode("_", $items['id']);
    		if(count($idProduks) > 1){
    			if($idProduks[1] == "PENJUALAN"){    				
		    		$nestedData = array();
		    		$nestedData['rowid'] = $items['rowid'];
		    		$nestedData['id'] = $items['id'];
		    		$nestedData['qty'] = $items['qty'];
		    		$nestedData['harga_beli'] = $items['price'];
		    		$nestedData['produk'] = $items['name'];
		    		$nestedData['rowid'] = $items['rowid'];
		    		$nestedData['subtotal'] = $items['price']*$items['qty'];

		    		$nestedData['ukuran'] = $items['options']['ukuran']!=null?$items['options']['ukuran']:0;
		    		$nestedData['warna'] = $items['options']['warna']!=null?$items['options']['warna']:0;
		    		$nestedData['total_berat'] = $items['options']['total_berat']!=null?$items['options']['total_berat']:0;
		    		array_push($data, $nestedData);
    			}
    		}
    	}
    	return json_encode($data);
    }
    function getProduk($supplier = null){
    	$list = null;
    	$dataSelect['deleted'] = 1;
    	if($supplier != null){
    		$dataSelect['id_supplier'] = $supplier;
    	}
    	$list = $this->Transaksipenjualanmodel->select($dataSelect, 'm_produk');
    	return json_encode($list->result_array());
    }
    function getProdukByName($keyword = null, $supplier = null){
    	$list = null;
    	$dataSelect['deleted'] = 1;
    	if($keyword != null && $supplier != null){
    		$dataLike['nama'] = $keyword;
    		$dataCondition['id_supplier'] = $supplier;
    	}
    	$list = $this->Transaksipenjualanmodel->like($dataCondition, $dataLike, 'm_produk');
    	return json_encode($list->result_array());
    }   
    function getProdukByKategori($kategori = null, $keyword = null){
    	$list = null;
    	$dataSelect['deleted'] = 1;
    	$dataLike = array();
    	if($kategori != null){
    		$dataCondition['id_kategori'] = $kategori;
    	}
    	if($keyword != null){
    		$dataLike['nama'] = $keyword;
    	}
    	$list = $this->Transaksipenjualanmodel->like($dataCondition, $dataLike, 'm_produk');
    	return json_encode($list->result_array());
    }    
    function getSupplier(){
    	$dataSelect['deleted'] = 1;
    	return json_encode($this->Transaksipenjualanmodel->select($dataSelect, 'm_supplier_produk')->result_array());
    }
    function filterProduk($supplier){
    	echo $this->getProduk($supplier);
    }
    function filterProdukByName(){
    	$params  = $this->input->post();
    	$keyword = $params['keyword'];
    	$supplier = $params['supplier'];
    	echo $this->getProdukByName($keyword, $supplier);
    }
    function filterProdukByKategori($kategori, $keyword = null){
    	echo $this->getProdukByKategori($kategori, $keyword);
    }
    function getWarna(){
    	$dataSelect['deleted'] = 1;
    	$selectData = $this->Transaksipenjualanmodel->select($dataSelect, 'm_produk_warna');
    	return json_encode($selectData->result_array());
    }
    function getUkuran(){
    	$dataSelect['deleted'] = 1;
    	$selectData = $this->Transaksipenjualanmodel->select($dataSelect, 'm_produk_ukuran');
    	return json_encode($selectData->result_array());
    }
    function transaksi(){
    	$dataSelect['deleted'] = 1;
    	$data['list_produk'] = $this->getProduk();
        $data['list_order'] = $this->getOrder();
        $data['list_customer'] = $this->getCustomer();
        $data['list_kategori'] = $this->getKategori();
        
        $data['list_warna'] = $this->getWarna();
        $data['list_ukuran'] = $this->getUkuran();
        
        $data['total'] = $this->cart->total();
        $data['total_items'] = $this->cart->total_items();
        $data['tax'] = 0;
        $data['discount'] = 0;
    	$this->load->view('Transaksi_penjualan/transaksi', $data);
    }
    function getTotal(){
    	$total = 0;
    	$total_item = 0;
    	foreach ($this->cart->contents() as $items) {    		
    		$idProduks = explode("_", $items['id']);
    		if(count($idProduks) > 1){
    			if($idProduks[1] == "PENJUALAN"){
    				$total = $total + ($items['price'] * $items['qty']);
    				$total_item += $items['qty'];
    			}
    		}
    	}    	
    	echo json_encode(array("tax"=>0, "discount"=> 0, "total"=> $total, "total_items"=>$total_item));
    }
    function updateCart($id, $qty, $state = 'tambah'){
    	$getid = $this->in_cart($id, 'id', 'rowid');
    	$dataSelect['deleted'] = 1;
    	$dataSelect['id'] = $getid;
    	$selectData = $this->Transaksipenjualanmodel->select($dataSelect, 'm_produk');
    	$lastQty = $this->in_cart($id, 'qty', 'rowid');
    	if($state == 'tambah'){		
			$data = array(
			        'rowid'  => $id,
			        'qty'    => $lastQty+1
			);
			$this->cart->update($data);
			echo $this->getOrder();   	
    	}else{
			$data = array(
			        'rowid'  => $id,
			        'qty'    => $qty
			);
			$this->cart->update($data);
			echo $this->getOrder();   	    		
    	}
    }
    function updateOption($id, $warna, $ukuran, $total_berat){
		$data = array(
		        'rowid'  => $id,
		        'options'=> array('warna'=>$warna,'ukuran'=>$ukuran,'total_berat'=>$total_berat)
		);
		$this->cart->update($data);
		echo $this->getOrder();  
    }
    function updateUkuran($id,  $warna, $ukuran, $total_berat){
		$data = array(
		        'rowid'  => $id,
		        'options'=> array('warna'=>$warna,'ukuran'=>$ukuran,'total_berat'=>$total_berat)
		);
		$this->cart->update($data);
		echo $this->getOrder();      	
    }
    function updateQty($id, $qty){
		$data = array(
		        'rowid'  => $id,
		        'qty'=> $qty
		);
		$this->cart->update($data);
		echo $this->getOrder();      	
    }
    function updateTotalBerat($id,  $warna, $ukuran, $total_berat){
		$data = array(
		        'rowid'  => $id,
		        'options'=> array('warna'=>$warna,'ukuran'=>$ukuran,'total_berat'=>$total_berat)
		);
		$this->cart->update($data);
		echo $this->getOrder();      	
    }
    function updateHargaBeli($id, $hargaBeli){
		$data = array(
		        'rowid'  => $id,
		        'price'	 => $hargaBeli
		);
		$this->cart->update($data);
		echo $this->getOrder();      	
    }
    function checkCart(){
    	echo json_encode($this->cart->contents());
    }
    function testLastQty($id){
    	$lastQty = $this->in_cart($id, 'qty', 'rowid');
    	echo $lastQty;    	
    }
    function deleteCart($id){
    	$this->cart->remove($id);
    	echo $this->getOrder();
    }
    function destroyCart(){
    	foreach ($this->cart->contents() as $items) {
    		$idProduks = explode("_", $items['id']);
    		if(count($idProduks) > 1){
    			if($idProduks[1] == "PENJUALAN"){
    				$this->cart->remove($items['rowid']);
    			}
    		}
    	}
    	echo $this->getOrder();	
    }
	function tambahCart($id){
		$inCart = $this->in_cart($id."_PENJUALAN");
		// echo $inCart;
		$params	= $this->input->post();
		$idCustomer = $params['idCustomer'];
		if($inCart == 'false'){
			$dataSelect['deleted']=1;
			$dataSelect['id']=$id;
			$selectData = $this->Transaksipenjualanmodel->select($dataSelect, 'm_produk');
			$hargaCustomer = $this->getHargaCustomer($selectData->row()->id, $idCustomer);
			// echo $hargaCustomer;
			if($hargaCustomer != 0){
				$datas = array(
			                'id'      => $selectData->row()->id."_PENJUALAN",
			                'qty'     => 1,
			                'price'   => $this->getHargaCustomer($selectData->row()->id, $idCustomer),
			                'name'    => $selectData->row()->nama,
					        'options' => array(
					        				'ukuran'=>0,
					        				'warna'=>0,
					        				'total_berat'=>$selectData->row()->berat*1
					        				)
				);
				$this->cart->insert($datas);
			}
			echo $this->getOrder();
		}else{
			$qty = $this->in_cart($id."_PENJUALAN", 'qty') + 1;
			$this->updateCart($inCart, $qty);
		}
	}
	function getHargaCustomer($idProduk = null, $idCustomer = null){
		$getData = $this->Transaksipenjualanmodel->rawQuery("SELECT m_produk_det_harga.harga as harga FROM m_produk
									INNER JOIN m_produk_det_harga ON m_produk_det_harga.id_produk = m_produk.id
									INNER JOIN m_customer ON m_produk_det_harga.id_customer_level = m_customer.id_customer_level
									WHERE m_produk.id = ".$idProduk." AND m_customer.id = ".$idCustomer);
		return $getData->num_rows()>0?$getData->row()->harga:0;
	}
	function in_cart($product_id = null, $type = 'rowid', $filter = 'id') {
	    if($this->cart->total_items() > 0){
	        $in_cart = array();
	        foreach ($this->cart->contents() AS $item){
	            $in_cart[$item[$filter]] = $item[$type];
	        }
	        if($product_id){
	            if (array_key_exists($product_id, $in_cart)){
	                return $in_cart[$product_id];
	            }else{            	
		            return "false";
	            }
	        }else{
	            return $in_cart;
	        }
	    }else{    	
		    return "false";
	    }
	}	
    function _getTotal(){
    	$total = 0;
    	$total_item = 0;
    	foreach ($this->cart->contents() as $items) {    		
    		$idProduks = explode("_", $items['id']);
    		if(count($idProduks) > 1){
    			if($idProduks[1] == "PENJUALAN"){
    				$total += ($items['price']*$items['qty']);
    				$total_item += $items['qty'];
    			}
    		}
    	}
    	return json_encode(array("tax"=>0, "discount"=> 0, "total"=> $total, "total_items"=>$total_item));
    }    
    function doSubmit(){
    	$params = $this->input->post();
    	if($params != null){
    		$getTotal = json_decode($this->_getTotal(), true);
            $dataInsert['id_purchase_order'] = $params['idpo'];
    		$dataInsert['id_supplier'] 	= $params['supplier'];
    		$dataInsert['catatan']		= $params['catatan'];
    		$dataInsert['total_berat'] = $this->getOption('total_berat');
    		$dataInsert['total_qty'] = $getTotal['total_items'];
    		$dataInsert['total_harga_beli'] = $getTotal['total'];
    		$dataInsert['add_by'] = 0;
    		$dataInsert['edited_by'] = 0;
    		$dataInsert['deleted'] = 1;
    		$insertDataMaster = $this->Transaksipenjualanmodel->insert($dataInsert, 't_beli');
    		if($insertDataMaster){    		
	    		$getDataID = $this->Transaksipenjualanmodel->select($dataInsert, 't_beli');
	    		foreach ($this->cart->contents() as $items){
	    			$idProduks = explode("_", $items['id']);
	    			if(count($idProduks) > 1){
	    				if($idProduks[1]=="PENJUALAN"){					
				    		$dataInsertDetail['id_beli']		        =	$getDataID->row()->id;
				    		$dataInsertDetail['id_produk']				=	$idProduks[0];	
				    		$dataInsertDetail['id_ukuran']				=	$items['options']['ukuran'];
				    		$dataInsertDetail['id_warna']				=	$items['options']['warna'];
				    		$dataInsertDetail['jumlah']					=	$items['qty'];
				    		$dataInsertDetail['total_berat']			=	$items['options']['total_berat'];
				    		$dataInsertDetail['harga_beli']				=	$items['price'];
				    		$dataInsertDetail['total_harga']			=	$items['price'] * $items['qty'];
				    		$insertDetail = $this->Transaksipenjualanmodel->insert($dataInsertDetail, 't_beli_detail');
	    				}
	    			}
	    		}
    		}
    	}
    	$this->destroyCart();
    }
    function testtCart(){
    	echo json_encode($this->cart->contents());
    }
    function payment(){
    	$params = $this->input->post();
    	if($params != null){
    		$idOrder = 0;
    		$realIDORDER = 0;
    		$dateNow = date('Y-m-d H:i:s');
    		$getTotal = json_decode($this->_getTotal(), true);
    		$dataInsertTorder['id_customer'] 					= 	$params['id_customer'];
    		$dataInsertTorder['catatan']						=	$params['catatan'];
    		$dataInsertTorder['total_berat']					=	$this->getOption('total_berat');
    		$dataInsertTorder['total_qty']						=	$getTotal['total_items'];
    		$dataInsertTorder['total_harga_barang']				=	$getTotal['total'];
    		$dataInsertTorder['grand_total']					=	$getTotal['total'] + 0;
    		$dataInsertTorder['profit']							=	0;
    		$dataInsertTorder['jenis_order']					=	$params['jenisOrder'];
    		$dataInsertTorder['status']							=	1;
    		$dataInsertTorder['date_add']						=	$dateNow;
    		$dataInsertTorder['add_by']							=	0;
    		$dataInsertTorder['deleted']						=	1;
    		$dataInsertTorder['id_metode_pembayaran']			=	$params['paymentMethod'];
    		$insertTorder = $this->Transaksipenjualanmodel->insert($dataInsertTorder, 't_order');
    		if($insertTorder){
    			// insert ke h_transaksi
    			$dataHtransaksi['jenis_transaksi'] 	= 4;
    			$dataHtransaksi['id_referensi']		= $params['chequenum'];
    			$dataHtransaksi['keterangan']		= $params['catatan'];
    			$dataHtransaksi['date_add']			= $dateNow;
    			$dataHtransaksi['add_by']			= 0;
    			$dataHtransaksi['deleted']			= 1;
    			$insertHtransaksi = $this->Transaksipenjualanmodel->insert($dataHtransaksi, 'h_transaksi');
    			if($insertHtransaksi){
    				// insert ke t_order_detail
		    		$getDataID = $this->Transaksipenjualanmodel->select($dataInsertTorder, 't_order');
		    		$realIDORDER = $getDataID->row()->id;
		    		$insertDetail = false;
		    		foreach ($this->cart->contents() as $items){
		    			$idProduks = explode("_", $items['id']);
		    			if(count($idProduks) > 1){
		    				if($idProduks[1]=="PENJUALAN"){
		    					$dataDetail['id'] = $idProduks[0];
		    					$getHargaBeli = $this->Transaksipenjualanmodel->select($dataDetail, 'm_produk');
		    					$idOrder = $getHargaBeli->row()->id;
					    		$dataInsertDetail['id_order']		        =	$getDataID->row()->id;
					    		$dataInsertDetail['id_produk']				=	$idProduks[0];	
					    		$dataInsertDetail['id_ukuran']				=	$items['options']['ukuran'];
					    		$dataInsertDetail['id_warna']				=	$items['options']['warna'];
					    		$dataInsertDetail['jumlah']					=	$items['qty'];
					    		$dataInsertDetail['total_berat']			=	$items['options']['total_berat'];
					    		$dataInsertDetail['harga_beli']				=	$getHargaBeli->row()->harga_beli;
					    		$dataInsertDetail['harga_jual']				=	$items['price'];
					    		$dataInsertDetail['total_harga']			=	$items['price'] * $items['qty'];
					    		$dataInsertDetail['profit']					=	$items['price'] - $getHargaBeli->row()->harga_beli;
					    		$insertDetail = $this->Transaksipenjualanmodel->insert($dataInsertDetail, 't_order_detail');
								if($insertDetail){
									//update stok
									$getIdDetail = $this->Transaksipenjualanmodel->select($dataInsertDetail, 't_order_detail');
									$dataConditionStok['id'] 					= $idProduks[0];
									$dataUpdateStok['stok']	 					= $getHargaBeli->row()->stok - $items['qty'];
									$dataUpdateStok['last_edited']	 			= $dateNow;
									$dataUpdateStok['edited_by']	 			= 0;
									$dataUpdateStok['tanggal_kurang_stok']	 	= $dateNow;
									$updateStokProduk = $this->Transaksipenjualanmodel->update($dataConditionStok, $dataUpdateStok, 'm_produk');
									if($updateStokProduk){
										// insert ke h_stok_produk
										$dataHstok['id_produk'] 		= $idProduks[0];
										$dataHstok['id_order_detail']	= $getIdDetail->row()->id;
										$dataHstok['id_service']		= 0;
										$dataHstok['jumlah']	 		= $items['qty'];
										$dataHstok['stok_akhir'] 		= $getHargaBeli->row()->stok - $items['qty'];
										$dataHstok['keterangan'] 		= $params['catatan'];
										$dataHstok['status']			= 1;
										$dataHstok['date_add']			= $dateNow;
										$dataHstok['add_by']			= 0;
										$dataHstok['deleted']			= 1;
										$insertHstok = $this->Transaksipenjualanmodel->insert($dataHstok, 'h_stok_produk');
									}
								}
		    				}
		    			}
		    		}
		    		if($insertHstok){
				    	foreach ($this->cart->contents() as $items) {
				    		$idProduks = explode("_", $items['id']);
				    		if(count($idProduks) > 1){
				    			if($idProduks[1] == "PENJUALAN"){
				    				$this->cart->remove($items['rowid']);
				    			}
				    		}
				    	}

		    			echo json_encode(array('idOrder'=>$realIDORDER));
		    		}else{
		    			echo json_encode(array('status'=>0));
		    		}
    			}else{
    				echo json_encode(array('status'=>0));
    			}
    		}else{
    			echo json_encode(array('status'=>0));
    		}
    	}else{
    		echo json_encode(array('status'=>0));
    	}
    }
    function getOption($option){
    	$total = 0;
    	foreach ($this->cart->contents() as $items){
    		$idProduks = explode("_", $items['id']);
    		if (count($idProduks) > 1) {
    			if ($idProduks[1] == "PENJUALAN") {
		    		$total += $items['options'][$option];
    			}
    		}
    	}
    	return $total;
    }
    function invoices($idORder){
    	$sql = " SELECT 
					m_customer.nama as namacus,
					m_customer.alamat as alamatcus,
					m_customer.no_telp as notelpcus,
					t_order.id as orderinvoice,
					t_order.date_add as orderdate,
					t_order.grand_total as ordertotal,
					m_produk.nama as namaprod,
					m_produk.deskripsi as deskprod,
					t_order_detail.harga_jual as detailjual,
					t_order_detail.jumlah as jumlahjual,
					t_order_detail.total_harga as totaljual";
		$sql.= " FROM t_order";
		$sql.= " LEFT JOIN t_order_detail ON t_order.id = t_order_detail.id_order";
		$sql.= " LEFT JOIN m_produk on t_order_detail.id_produk = m_produk.id";
		$sql.= " LEFT JOIN m_customer ON t_order.id_customer = m_customer.id";
		$sql.= " LEFT JOIN m_produk_ukuran on t_order_detail.id_ukuran = m_produk_ukuran.id";
		$sql.= " LEFT JOIN m_produk_warna on t_order_detail.id_warna = m_produk_warna.id";
		$sql.= " WHERE t_order.id=".$idORder;
		$exeQuery = $this->Transaksipenjualanmodel->rawQuery($sql);
		$data['data'] = $exeQuery;
		$this->load->view('Transaksi_penjualan/invoice', $data);
    }
    function testInvoices(){
    	$this->load->view('Transaksi_penjualan/invoice');
    }
}
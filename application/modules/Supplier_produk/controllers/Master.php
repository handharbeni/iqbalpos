<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master extends MX_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model('Supplierprodukmodel');
    }
    function index(){
    	$dataSelect['deleted'] = 1;
        $data['list_prov'] = json_encode($this->Supplierprodukmodel->select($dataSelect, 'm_provinsi')->result());
        $data['list_kota'] = json_encode($this->Supplierprodukmodel->select($dataSelect, 'm_kota')->result());
    	$data['list'] = json_encode($this->Supplierprodukmodel->select($dataSelect, 'm_supplier_produk')->result());
		//echo $data;
		//print_r($data);
    	$this->load->view('Supplier_produk/view', $data);
    }
	
	function test(){
		header('Content-Type: application/json; charset=utf-8');
		$dataSelect['deleted'] = 1;
		$list = $this->Supplierprodukmodel->select($dataSelect, 'm_supplier_produk')->result();
		echo json_encode(array('status' => '3','list' => $list));
	}
	
    function add(){
		$params = $this->input->post();
		$dataInsert['nama'] 			= $params['nama'];
		$dataInsert['alamat'] 			= $params['alamat'];
		$dataInsert['no_telp'] 			= $params['no_telp'];
		$dataInsert['email'] 			= $params['email'];
		$dataInsert['id_provinsi'] 		= $params['id_provinsi'];
		$dataInsert['id_kota'] 			= $params['id_kota'];
		$dataInsert['deleted'] 			= 1;
		$checkData = $this->Supplierprodukmodel->select($dataInsert, 'm_supplier_produk');
		if($checkData->num_rows() < 1){
			$insert = $this->Supplierprodukmodel->insert($dataInsert, 'm_supplier_produk');
			if($insert){
				$dataSelect['deleted'] = 1;
				$list = $this->Supplierprodukmodel->select($dataSelect, 'm_supplier_produk')->result();
				echo json_encode(array('status' => 3,'list' => $list));
			}else{
				echo json_encode(array('status' => 1));
			}
			
		}else{			
    		echo json_encode(array( 'status'=>1 ));
		}
    }
   
	
	function get($id = null){   	
    	if($id != null){
    		$dataSelect['id'] = $id;
    		$selectData = $this->Supplierprodukmodel->select($dataSelect, 'm_supplier_produk');
    		if($selectData->num_rows() > 0){
    			echo json_encode(
    				array(
    					'status'			=> 2,
    					'id'				=> $selectData->row()->id,
    					'nama'				=> $selectData->row()->nama,
    					'alamat'			=> $selectData->row()->alamat,
    					'no_telp'			=> $selectData->row()->no_telp,
    					'email'				=> $selectData->row()->email,
    					'id_provinsi'		=> $selectData->row()->id_provinsi,
    					'id_kota'			=> $selectData->row()->id_kota,
    				));
    		}else{
    			echo json_encode(array('status' => 1));
    		}
    	}else{
    		echo json_encode(array('status' => 0));
    	}
    }
	
    function edit(){
		$params = $this->input->post();
		$dataCondition['id']			= $params['id'];
		$dataUpdate['nama'] 			= $params['nama'];
		$dataUpdate['alamat'] 			= $params['alamat'];
		$dataUpdate['no_telp'] 			= $params['no_telp'];
		$dataUpdate['email'] 			= $params['email'];
		$dataUpdate['id_provinsi'] 		= $params['id_provinsi'];
		$dataUpdate['id_kota'] 			= $params['id_kota'];
		$checkData = $this->Supplierprodukmodel->select($dataCondition, 'm_supplier_produk');
		if($checkData->num_rows() > 0){
			$update = $this->Supplierprodukmodel->update($dataCondition, $dataUpdate, 'm_supplier_produk');
			if($update){
				$dataSelect['deleted'] = 1;
				$list = $this->Supplierprodukmodel->select($dataSelect, 'm_supplier_produk')->result();
				echo json_encode(array('status' => '3','list' => $list));
			}else{
				echo json_encode(array( 'status'=>'2' ));
			}
		}else{			
    		echo json_encode(array( 'status'=>'1' ));
		}
    }
    function delete(){
		$id = $this->input->post("id");
    	if($id != null){
    		$dataCondition['id'] = $id;
    		$dataUpdate['deleted'] = 0;
    		$update = $this->Supplierprodukmodel->update($dataCondition, $dataUpdate, 'm_supplier_produk');
    		if($update){
    			$dataSelect['deleted'] = 1;
				$list = $this->Supplierprodukmodel->select($dataSelect, 'm_supplier_produk')->result();
				echo json_encode(array('status' => '3','list' => $list));
    		}else{
    			echo "1";
    		}
    	}else{
    		echo "0";
    	}
    }
    function buttonDelete($id=null){
    	if($id!=null){
    		echo "<button class='btn btn-danger' onclick='delRow(".$id.")'>YA</button>";
    	}else{
    		echo "NOT FOUND";
    	}
    }
    
   
    function get_kota(){
        $dataSelect['id_provinsi'] = $this->input->get("id_prov");
    	$dataSelect['deleted'] = 1;
    	echo json_encode($this->Supplierprodukmodel->select($dataSelect, 'm_kota')->result());
    }
    
}
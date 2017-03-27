<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master extends MX_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model('Customermodel');
    }
    function index(){
    	$dataSelect['deleted'] = 1;
        $data['list_prov'] = json_encode($this->Customermodel->select($dataSelect, 'm_provinsi', 'nama')->result());
        $data['list_kota'] = json_encode($this->Customermodel->select($dataSelect, 'm_kota', 'nama')->result());
        $data['list_level'] = json_encode($this->Customermodel->select($dataSelect, 'm_customer_level', 'nama')->result());
    	$data['list'] = json_encode($this->Customermodel->select($dataSelect, 'm_customer', 'date_add', 'DESC')->result());
		//echo $data;
		//print_r($data);
    	$this->load->view('Master_customer/view', $data);
    }
	
	function test(){
		header('Content-Type: application/json; charset=utf-8');
		$dataSelect['deleted'] = 1;
		$list = $this->Customermodel->select($dataSelect, 'm_customer', 'date_add', 'DESC')->result();
		echo json_encode(array('status' => '3','list' => $list));
	}
	
    function add(){
		$params = $this->input->post();
		$dataInsert['nama'] 			= $params['nama'];
		$dataInsert['alamat'] 			= $params['alamat'];
		$dataInsert['no_telp'] 			= $params['no_telp'];
		$dataInsert['email'] 			= $params['email'];
		$dataInsert['kode_pos'] 		= $params['kodepos'];
		$dataInsert['id_provinsi'] 		= $params['id_provinsi'];
		$dataInsert['id_kota'] 			= $params['id_kota'];
		$dataInsert['id_customer_level'] = $params['id_customer_level'];
        $dataInsert['last_edited']      = date("Y-m-d H:i:s");
        $dataInsert['add_by']        = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : 0;
        $dataInsert['edited_by']        = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : 0;
		$dataInsert['deleted'] 			= 1;

		$checkData = $this->Customermodel->select($dataInsert, 'm_customer');
		if($checkData->num_rows() < 1){
			$insert = $this->Customermodel->insert($dataInsert, 'm_customer');
			if($insert){
				$dataSelect['deleted'] = 1;
				$list = $this->Customermodel->select($dataSelect, 'm_customer', 'date_add', 'DESC')->result();
				echo json_encode(array('status' => 3,'list' => $list));
			}else{
				echo json_encode(array('status' => 2));
			}
			
		}else{			
    		echo json_encode(array( 'status'=>1 ));
		}
    }
   
	
	function get($id = null){   	
    	if($id != null){
    		$dataSelect['id'] = $id;
    		$selectData = $this->Customermodel->select($dataSelect, 'm_customer');
    		if($selectData->num_rows() > 0){
    			echo json_encode(
    				array(
    					'status'			=> 2,
    					'id'				=> $selectData->row()->id,
    					'nama'				=> $selectData->row()->nama,
    					'alamat'			=> $selectData->row()->alamat,
    					'no_telp'			=> $selectData->row()->no_telp,
    					'email'				=> $selectData->row()->email,
    					'kode_pos'			=> $selectData->row()->kode_pos,
    					'id_provinsi'		=> $selectData->row()->id_provinsi,
    					'id_kota'			=> $selectData->row()->id_kota,
    					'id_customer_level'	=> $selectData->row()->id_customer_level
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
		$dataUpdate['kode_pos'] 		= $params['kodepos'];
		$dataUpdate['id_provinsi'] 		= $params['id_provinsi'];
		$dataUpdate['id_kota'] 			= $params['id_kota'];
		$dataUpdate['id_customer_level'] = $params['id_customer_level'];
        $dataUpdate['last_edited']      = date("Y-m-d H:i:s");
        $dataUpdate['edited_by']        = isset($_SESSION['id_user']) ?$_SESSION['id_user'] : 0;
        
		$checkData = $this->Customermodel->select($dataCondition, 'm_customer');
		if($checkData->num_rows() > 0){
			$update = $this->Customermodel->update($dataCondition, $dataUpdate, 'm_customer');
			if($update){
				$dataSelect['deleted'] = 1;
				$list = $this->Customermodel->select($dataSelect, 'm_customer', 'date_add', 'DESC')->result();
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
    		$update = $this->Customermodel->update($dataCondition, $dataUpdate, 'm_customer');
    		if($update){
    			$dataSelect['deleted'] = 1;
				$list = $this->Customermodel->select($dataSelect, 'm_customer', 'date_add', 'DESC')->result();
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
    	echo json_encode($this->Customermodel->select($dataSelect, 'm_kota', 'nama')->result());
    }
    
}
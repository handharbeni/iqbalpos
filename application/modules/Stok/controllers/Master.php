<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master extends MX_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model('Stokmodel');
    }
    function index(){
    	$dataSelect['deleted'] = 1;
        $sql = "SELECT A.*, B.nama, B.sku, C.id_order, C.nama_warna, C.nama_ukuran FROM h_stok_produk A LEFT JOIN m_produk B ON A.id_produk = B.id LEFT JOIN t_order_detail C ON A.id_order_detail = C.id ORDER BY A.date_add DESC";
        $data['list'] = json_encode($this->Stokmodel->rawQuery($sql)->result());
    	$this->load->view('Stok/view', $data);
    }

    function data(){
        $requestData= $_REQUEST;
        $columns = array( 
            0   =>  '#', 
            1   =>  'date_add', 
            2   =>  'nama',
            3   =>  'sku',
            4   =>  'jumlah',
            5   =>  'stok_akhir',
            6   =>  'nama_warna',
            7   =>  'nama_ukuran',
            8   =>  'id_order',
            9   =>  'status',
            // 6   =>  'aksi'
        );
        $sql = "SELECT A.*, B.nama, B.sku, C.id_order, C.nama_warna, C.nama_ukuran FROM h_stok_produk A LEFT JOIN m_produk B ON A.id_produk = B.id LEFT JOIN t_order_detail C ON A.id_order_detail = C.id";
        $query=$this->Stokmodel->rawQuery($sql);
        $totalData = $query->num_rows();
        $totalFiltered = $totalData;
        
        if( !empty($requestData['search']['value']) ) {
            $sql.=" WHERE (B.nama LIKE '%".$requestData['search']['value']."%' "; 
            $sql.=" OR B.sku LIKE '%".$requestData['search']['value']."%' ";
            $sql.=" OR A.jumlah LIKE '%".$requestData['search']['value']."%' ";
            $sql.=" OR A.stok_akhir LIKE '%".$requestData['search']['value']."%' ";
            $sql.=" OR C.nama_warna LIKE '%".$requestData['search']['value']."%' ";
            $sql.=" OR C.nama_ukuran LIKE '%".$requestData['search']['value']."%' ";
            $sql.=" OR C.id_order LIKE '%".$requestData['search']['value']."%' ";
            $sql.=" OR A.status LIKE '%".$requestData['search']['value']."%' )";
        }

        //Stok filtering
        // if(!empty($requestData['operator']) AND !empty($requestData['stok'])) {
        //     $operator = ($requestData['operator']=="kurang_dari") ? "<=" : ">=";
        //     $sql.=" AND (A.stok ".$operator." '".$requestData['stok']."')";
        // }
        // echo $sql;
        // die();

        $query=$this->Stokmodel->rawQuery($sql);
        $totalFiltered = $query->num_rows();

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; 
        $query=$this->Stokmodel->rawQuery($sql);
        
        $data = array(); $i=0;
        foreach ($query->result_array() as $row) {
            $nestedData     =   array(); 
            $nestedData[]   =   "<span style='display:block' class='text-center'>".($i+1)."</span>";
            $nestedData[]   =   date("d-m-Y", strtotime($row["date_add"]));
            $nestedData[]   =   $row["nama"];
            $nestedData[]   =   $row["sku"];
            $nestedData[]   =   "<span style='display:block' class='text-center'>".$row["jumlah"]."</span>";
            $nestedData[]   =   "<span style='display:block' class='text-center'>".$row["stok_akhir"]."</span>";
            $nestedData[]   =   $row['nama_warna'];
            $nestedData[]   =   $row['nama_ukuran'];
            $nestedData[]   =   "<span style='display:block' class='text-center'>".$row["id_order"]."</span>";
            $nestedData[]   =   "<span style='display:block' class='text-center'>".$row["status"]."</span>";
            // $nestedData[]   .=   '<td class="text-center"><div class="btn-group" >'
            //     .'<a id="group'.$row["id"].'" class="divpopover btn btn-sm btn-default" href="javascript:void(0)" data-toggle="popover" data-placement="top" onclick="confirmDelete(this)" data-html="true" title="Hapus Data?" ><i class="fa fa-times"></i></a>'
            //     .'<a class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Ubah Data" onclick="showUpdate('.$row["id"].')"><i class="fa fa-pencil"></i></a>'
            //    .'</div>'
            // .'</td>';
            
            $data[] = $nestedData; $i++;
        }
        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),
                    "recordsTotal"    => intval( $totalData ),
                    "recordsFiltered" => intval( $totalFiltered ),
                    "data"            => $data
                    );
        echo json_encode($json_data);
    }
	
	function test(){
		header('Content-Type: application/json; charset=utf-8');
		$dataSelect['deleted'] = 1;
		$list = $this->Stokmodel->select($dataSelect, 'fin_transfer_harian')->result();
		echo json_encode(array('status' => '3','list' => $list));
	}
	
	function get($id = null){   	
    	if($id != null){
    		$dataSelect['id'] = $id;
    		$selectData = $this->Stokmodel->select($dataSelect, 'fin_transfer_harian');
    		if($selectData->num_rows() > 0){
    			echo json_encode(
    				array(
    					'status'			=> 2,
    					'id'				=> $selectData->row()->id,
    					'nama'				=> $selectData->row()->nama,
    				));
    		}else{
    			echo json_encode(array('status' => 1));
    		}
    	}else{
    		echo json_encode(array('status' => 0));
    	}
    }
	
   
    
}
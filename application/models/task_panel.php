<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Task_panel extends CI_Model {

    function __construct() {

    	    parent::__construct();
	
    	    $this->load->database();

	    }
		
 
		function getalltask(){
					$userid=$this->session->userdata('user_id');
					$sql="SELECT * FROM task_panel where user_id=$userid";
					$query = $this->db->query($sql);
					return $query->result_array();	
			}
		
		function addtaskpanel(){
						$cdate=$this->input->post('completed',true);
						
						$data['user_id']		=$this->session->userdata('user_id');
						$data['task_name']		=$this->input->post('task_name',true);
						$data['task_date']		=$this->input->post('task_date',true);
						//$data['task_completed']	=$this->input->post('completed',true);
						//$data['is_active']		= 1;
						$this->db->insert('task_panel', $data);
					}
			
		function updatetaskstatus($id='',$status=''){
				
				if($id){
					if($status=='Y'){$status='N';}else{$status='Y';}
					$data['task_completed']		= $status;
					$this->db->where('id', $id);
					$this->db->update('task_panel', $data);
				}
				  
			}
			
			
		function deltask($id=''){
				$sql="DELETE FROM task_panel WHERE id=".$id;
				$query = $this->db->query($sql);
				return true;
			}			
		function getstorebyid($id=''){
				$this->db->select('*');
				$query = $this->db->get_where('wed_store', array('id' =>$id));
				$rows = $query->row();
				if(empty($rows))
				{
					redirect('/home', 'location');
				}
				return $rows;
			}
		
		function getaddstoreimg($id=''){
				$this->db->select('*');
				$query = $this->db->get_where('additional_store_img', array('store_id' =>$id));
				$rows = $query->result_array();
				return $rows;
			}
		
		function getcountrybycityid($id=''){
				$this->db->select('*');
				$this->db->from('cities');
				$this->db->join('states', 'cities.stateID = states.stateID');
				$this->db->join('countries', 'cities.countryID = countries.countryID');
				
				$this->db->where('cities.cityID', $id, 'left outer');
				$query = $this->db->get();
				$rows = $query->row();
				return $rows;
			}
			
		function getallcountry($id=''){
				
				if($id){
					$this->db->select('*');
					$query = $this->db->get_where('countries', array('countryID' =>$id));
					$rows  = $query->row();
				}else{
					$query = $this->db->select('*')->from('countries')->get();
					$rows  = $query->result_array();
				}
				return $rows;
			}
		
		function getallstates($id=''){
				
				if($id){
					$this->db->select('*');
					$query = $this->db->get_where('states', array('countryID' =>$id));
					return $query->result_array();
				}
				  
			}
		
		function getallcities($id=''){
				
				if($id){
					$this->db->select('*');
					$query = $this->db->get_where('cities', array('stateID' =>$id));
					return  $query->result_array();
				}
				  
			}
			
		function searchstore($name=''){
				
				if($name){
					$this->db->select('*');
					$this->db->from('wed_store');
					$this->db->like('s_store_name', $name); 
					/*if($this->session->userdata('user_id')){
						$this->db->where('i_user_id' ,$this->session->userdata('user_id'));  
					}*/
					$this->db->where('i_is_active' ,'1');
					return  $this->db->get()->result_array();
				}
				  
			}
			
			function getalladds(){
				
				 	return	$this->db->select('*')->from('web_adds')->where('active' ,'Y')->order_by("add_order", "asc")->get()->result_array();
						   
				}
			
			public function findexts($filename) 
		 		{ 
					 $filename = strtolower($filename) ; 
					 $exts = explode("[/\\.]", $filename) ; 
					 $n = count($exts)-1; 
					 $exts = $exts[$n]; 
					 return $exts; 
				 } 
			
		function addstore(){
				
				$data['i_user_id']			=$this->session->userdata('user_id');
				$data['s_store_name']		=$this->input->post('storename',true);
				$data['s_storet_desc']		=$this->input->post('store_des',true);
				$data['i_category_id']		=$this->input->post('cat_id',true);
				$data['i_country']			=$this->input->post('countryID',true);
				$data['i_state']			=$this->input->post('stateID',true);
				$data['i_city']				=$this->input->post('cityID',true);
				$data['i_store_phone_no']	=$this->input->post('store_phone',true);
				$data['s_store_email']		=$this->input->post('store_email',true);
				$data['s_store_website']	=$this->input->post('store_website',true);
				$data['i_is_active']		= 1;
				$folder = "./img/upload/";
				move_uploaded_file($_FILES["store_logo"]["tmp_name"] , $folder.$_FILES["store_logo"]["name"]);
				$data['s_store_logo'] = $_FILES["store_logo"]["name"];
				$this->db->insert('wed_store', $data);
				$store_id = $this->db->insert_id();
				
				$num_img=count($_FILES["image"]["name"]);
					if($num_img > 0)
					{
						for($a=0; $a < $num_img; $a++)
						{
							if($_FILES["image"]["name"][$a]!='')
							{
								$folder = "./img/addimgupload/";
								move_uploaded_file($_FILES["image"]["tmp_name"][$a] , $folder.$_FILES["image"]["name"][$a]);
								$img['img_name'] 		= $_FILES["image"]["name"][$a];
								$img['store_id'] 		= $store_id;
								$this->db->insert('additional_store_img', $img);
							}
						}
					}
					return $store_id;
				 
			}
			
		function updatestore($id){
				if($this->session->userdata('user_id')){
				$data['i_user_id']			=$this->session->userdata('user_id');}
				$data['s_store_name']		=$this->input->post('storename',true);
				$data['s_storet_desc']		=$this->input->post('store_des',true);
				$data['i_category_id']		=$this->input->post('cat_id',true);
				$data['i_country']			=$this->input->post('countryID',true);
				$data['i_state']			=$this->input->post('stateID',true);
				$data['i_city']				=$this->input->post('cityID',true);
				$data['i_store_phone_no']	=$this->input->post('store_phone',true);
				$data['s_store_email']		=$this->input->post('store_email',true);
				$data['s_store_website']	=$this->input->post('store_website',true);
				$data['i_is_active']		= 1;
				$folder = "./img/upload/";
				if($_FILES["store_logo"]["name"]!=''){
				move_uploaded_file($_FILES["store_logo"]["tmp_name"] , $folder.$_FILES["store_logo"]["name"]);
					$data['s_store_logo'] = $_FILES["store_logo"]["name"];
				}
				$this->db->where('id', $id);
				$this->db->update('wed_store', $data);
				 
				
				$num_img=count($_FILES["image"]["name"]);
					if($num_img > 0)
					{
						for($a=0; $a < $num_img; $a++)
						{
							if($_FILES["image"]["name"][$a]!='')
							{
								$folder = "./img/addimgupload/";
								move_uploaded_file($_FILES["image"]["tmp_name"][$a] , $folder.$_FILES["image"]["name"][$a]);
								$img['img_name'] 		= $_FILES["image"]["name"][$a];
								$img['store_id'] 		= $id;
								$this->db->insert('additional_store_img', $img);
							}
						}
					}
					 
				 
			}
}

				


/* End of file  */
 
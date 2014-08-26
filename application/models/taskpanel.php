<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Taskpanel extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    
	 public function __construct() {

        parent::__construct();

        $this->load->helper('url');

        $this->load->helper('form');

      //  $this->load->library('session');

        $this->load->library('form_validation');
		$this->load->model('category');
		$this->load->model('crudoperations');
		$this->load->model('user');
		$this->load->model('task_panel');
        $this->load->model('adminer');
        $this->load->library('Auth');
		$this->status = $this->auth->checkStatus(FALSE);
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

    }

    public function index() {
		
				 if(!$this->session->userdata('user_id')) {
					redirect('/signup', 'location');
				 }
		  		$data['data']=array();
				$this->pagedata['all_cat']=$data['all_cat']=$this->category->getallcat();
				$data['alltasks']=$this->task_panel->getalltask();
				//echo "<pre>";print_r($this->session->userdata);die;
                $this->pagedata['pagetitle'] = "ZEFAF | Task Panel";
                $this->pagedata['content'] = $this->load->view('pages/task_panel', $data, TRUE);
                $this->load->view('main', $this->pagedata);
			}
	
	public function addpanel() {
				//echo "<pre>";print_r($_POST);die;
				
				$data['data']=array();
				if($this->session->userdata('user_id')){
					if($this->input->post('submit',true)){
						if($this->input->post('task_name',true) &&
							$this->input->post('task_name',true) &&
							$this->input->post('completed',true)){
								$response=$this->task_panel->addtaskpanel();
								$this->session->set_flashdata('result', 'Task Added successfully');
							redirect("/taskpanel", 'location');
						}else{
							$this->session->set_flashdata('result', 'All fields are required');
							redirect("/taskpanel/addpanel", 'location');
							}
					}
				 
		  		$data['data']=array();
				$this->pagedata['all_cat']=$data['all_cat']=$this->category->getallcat();
				$data['alltasks']=$this->task_panel->getalltask();
				//echo "<pre>";print_r($this->session->userdata);die;
                $this->pagedata['pagetitle'] = "ZEFAF | Add Task";
                $this->pagedata['content'] = $this->load->view('pages/add_tpanel', $data, TRUE);
                $this->load->view('main', $this->pagedata);
				} else{
					redirect('/signup', 'location');
					}
				
	}
	
	
	public function updatetaskstatus() {
				$id = $this->input->get('id',true);
				$status = $this->input->get('status',true);
				if(isset($id)){
					$data=$this->task_panel->updatetaskstatus($id,$status);
					echo json_encode($data);
				}
		
		}
	
	public function searchstore() {
				 
				if(!$this->input->post('storename',true)){
					redirect('/home', 'location');
					}
				$name=$this->input->post('storename');
		 		$data['data']=array();
				$data['headding']='Search Result';
				$data['cat_detail']=$this->category->searchstore($name);
				//echo "<pre>";print_r($data);die;
				$this->pagedata['all_cat']=$this->category->getallcat();
				$this->pagedata['pagetitle'] = "ZEFAF | Search Store";
				$this->pagedata['content'] = $this->load->view('pages/home', $data, TRUE);
				$this->load->view('main', $this->pagedata);
	}
	
	public function viewstore() {
				$id=$this->uri->segment(3);
				if(!$id){
					redirect('/home', 'location');
					}
		 		$data['data']=array();
				$data['cat_detail']=$this->category->getstorebyid($id);
				$citydetail=$data['citydetail']=$this->category->getcountrybycityid($data['cat_detail']->i_city);
				//echo "<pre>";print_r($citydetail);die;
				$data['cat_detail']->i_city=$citydetail->cityName.' ( '.$citydetail->countryName.' )';
				
				$data['add_imgs']=$this->category->getaddstoreimg($id);
				
				$this->pagedata['all_cat']=$this->category->getallcat();
				$this->pagedata['pagetitle'] = "ZEFAF | View Store";
				$this->pagedata['content'] = $this->load->view('pages/view_store', $data, TRUE);
				$this->load->view('main', $this->pagedata);
	}
	
	 public function addstore() {
				 
				if(!$this->session->userdata('user_id')) {
					redirect('/signup', 'location');
				 }
				 if($this->input->post('submit',true)){
					 if($this->input->post('storename',true) && 
					    $this->input->post('store_des',true) &&
						$this->input->post('cat_id',true) && 
						$this->input->post('countryID',true) && 
						$this->input->post('stateID',true) && 
						$this->input->post('cityID',true) && 
						$this->input->post('store_phone',true) && 
						$this->input->post('store_email',true) &&  
						$this->input->post('store_website',true)){
					 // echo "<pre>";print_r($this->input->post());print_r($_FILES);die;
					  $store_id=$this->category->addstore();
					  $this->user->sendstoreconfirmation_mail($store_id,$this->session->userdata('email'));
					  $this->user->sendstoreconfirmation_mailtoadmin($store_id,$this->category->getmail());
					  redirect("/store/viewstore/$store_id", 'location');
					 }else{
						 $this->session->set_flashdata('result', 'All fields are required');
						 redirect("/store/addstore", 'location');
						 }
					 }
		  		$data['data']=array();
				$data['allcountry']=$this->category->getallcountry();
				$this->pagedata['all_cat']=$data['all_cat']=$this->category->getallcat();
				 
                $this->pagedata['pagetitle'] = "ZEFAF | Add Store";
                $this->pagedata['content'] = $this->load->view('pages/add_store', $data, TRUE);
                $this->load->view('main', $this->pagedata);
	}
	
	 public function editstore() {
		 		if(!$this->session->userdata('user_id') && !$this->session->userdata('admin_id')) {
					redirect('/login', 'location');
				 }
				 
				$id=$this->uri->segment(3);
				if(!$id){
					redirect('/home', 'location');
					}
				if($this->session->userdata('user_id')!=0){
//					 redirect("/store/viewstore/$id", 'location');
				 }
				if($this->input->post('submit',true)){
					 if($this->input->post('storename',true) && 
					    $this->input->post('store_des',true) &&
						$this->input->post('cat_id',true) && 
						$this->input->post('countryID',true) && 
						$this->input->post('stateID',true) && 
						$this->input->post('cityID',true) && 
						$this->input->post('store_phone',true) && 
						$this->input->post('store_email',true) &&  
						$this->input->post('store_website',true)){
					 // echo "<pre>";print_r($this->input->post());print_r($_FILES);die;
					  $store_id=$this->category->updatestore($id);
					  if($this->session->userdata('admin_id')){
						redirect("/admin/manage_stores", 'location');  
						  }
					  redirect("/store/viewstore/$id", 'location');
					  }else{
						 $this->session->set_flashdata('result', 'All fields are required');
						 redirect("/store/editstore/$id", 'location');
						 }
					 }
		 		$data['data']=array();
				$data['store_detail']=(array)$this->category->getstorebyid($id);
				$data['allcountry']=$this->category->getallcountry();
				$data['states']    =$this->category->getallstates($data['store_detail']['i_country']);
				$data['cities']    =$this->category->getallcities($data['store_detail']['i_state']);
				$data['add_imgs']  =$this->category->getaddstoreimg($id);
				//echo "<pre>";print_r($data);die;
				$this->pagedata['all_cat']=$data['all_cat']=$this->category->getallcat();
				$this->pagedata['pagetitle'] = "ZEFAF | Edit Store";
				$this->pagedata['content'] = $this->load->view('pages/edit_store', $data, TRUE);
                $this->load->view('main', $this->pagedata);
	}
	
	public function getallstates(){
				$id = $this->input->get('id',true);
				if(isset($id)){
					$data=$this->category->getallstates($id);
					echo json_encode($data);
				}
				
			}
		
	public function getallcities($id=''){
			$id = $this->input->get('id',true);
			if(isset($id)){
				$data=$this->category->getallcities($id);
				echo json_encode($data);
			}
			
		}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
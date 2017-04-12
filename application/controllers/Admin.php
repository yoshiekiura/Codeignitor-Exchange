<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('grocery_CRUD');
		$this->load->model('admin_model');
		$this->load->model('mdl_user');
		$this->load->model('mdl_user_verification');

	}

	public function index()
	{
		auth(['admin','superadmin']);

		if (!$this->session->user_id > 0) {
			redirect('/');
		}

		$this->data['content'] = $this->load->view('admin/v_index',[], true);
		view($this->data, 'admin');
	}

	public function users()
	{
		
		auth(['admin','superadmin']);

		$crud = new grocery_CRUD();
		
		$crud->set_table('users');
		$crud->set_subject('Manage Users');
		$crud->columns('id','email','username','verfiyStatus','trade_verification','role');
		$crud->unset_fields('id','modified_date','dateofreg','activated_date','timeofreg','password');
		
		$crud->set_field_upload('profilepicture','uploads');

		// types
		$crud->change_field_type('password', 'password');

		// display as
		$crud->display_as('verfiyStatus','Verify Status');

		// callback
		$crud->callback_column('verfiyStatus',array($this,'callback_verify_status'));
		$crud->callback_delete(array($this,'callback_users_delete'));

		$this->load->model('mdl_user_verification');
		$crud->callback_column('trade_verification',array($this,'callback_trade_verification'));

		$output = $crud->render();

		
		$this->data['content'] = $this->load->view('admin/v_grocery_crud', (array) $output, true);
		view($this->data, 'admin');	
	}

	public function callback_users_delete($primary_key)
	{
		// get user
		$user = $this->mdl_user->get($primary_key);
		$user_verification = $this->mdl_user_verification->get($primary_key);
		if($user->verifyStatus != 'verified' && $user_verification->verification_status != 'verified' ){
			$this->mdl_user->delete($primary_key);
		}else{
			return false;
		}
	}

	public function user_verification($primary_key='')
	{
		auth(['admin','superadmin']);
		// init
		$crud = new grocery_CRUD();
		$crud->set_table('user_verification');
		$crud->set_subject('user_verification');
		$crud->set_field_upload('selfie','uploads');
		$crud->set_field_upload('backcard','uploads');
		$crud->field_type('created_date', 'readonly');
		$crud->set_relation('user_id','users','username');
		$crud->display_as('user_id','Client Name');

		// load user data - only on edit
		if($crud->getState() == 'edit'){
			$primary_key = $crud->getStateInfo()->primary_key;
			$this->data['user'] = $this->db->get_where('user_verification',['id' => $primary_key])->row();
		}else{
			$this->data['user'] = NULL;
		}

		// unset
		$crud->unset_add();
		$crud->unset_read();
		$crud->unset_back_to_list();
		$crud->unset_print();
		$crud->unset_export();

		if(! isset($this->data['user']->passport_refuse_reason)){
			$crud->unset_fields('passport_refuse_reason'); // just show if reason exist and can edit
		}

		// callback
		$crud->set_lang_string('update_success_message','Your data has been successfully stored into the database.<br/>Please wait while you are redirecting to the list page.
			<script type="text/javascript">window.location = "'.site_url('admin/users').'";</script>
			');

		// check 
		$crud->callback_field('passport',array($this,'callback_passport'));

		$output = $crud->render();

		// assets
		$this->l_asset->add('plugins/alertifyjs/css/alertify.min.css','css');
		$this->l_asset->add('plugins/alertifyjs/css/themes/default.min.css','css');
		$this->l_asset->add('plugins/alertifyjs/alertify.min.js','js');
		$this->l_asset->add('js/admin/user_verification.js','js');

		$this->data['content'] = $this->load->view('admin/v_grocery_crud', (array) $output, true);
		view($this->data, 'admin');		
	}

	public function clear_passport_data()
	{
		if($this->input->is_ajax_request()){
		   // update user_verification table
			$refuse_reason = $this->input->post('refuse_reason');
			$id = $this->input->post('id');
			$this->db->set('passport_refuse_reason',$refuse_reason);
			$this->db->set('passport_path','');
			$this->db->set('passport_mimetype','');
			$this->db->where('id', $id);
			$this->db->update('user_verification');
		}else{
			show_error('this action not allowed');
		}
	}

	public function callback_passport($value = "", $primary_key = null)
	{
		$row = $this->data['user'];
		if(isset($row->passport_path) and $row->passport_path != ''){
			$output  = img('tools/show_passport_upload/'.$value,false,'class="img-rounded" id="passportImg"');
			$output .= '<a href="javascript:void(0)" class="text-danger" data-csrf-gt="'.$this->security->get_csrf_hash().'" data-primary-key="'.$primary_key.'" id="deletePassportBTn">delete</a>';
		}else{
			$output = '<i class="fa fa-picture-o fa-5x text-success"></i>';
		}
		return $output;

	}

	public function callback_trade_verification($value,$row)
	{
    	// check user trade verification
		$user_verification = $this->mdl_user_verification->get($row->id);

		if($user_verification){
			return anchor('admin/user_verification/edit/'.$user_verification->id,$this->callback_verify_status($user_verification->verification_status).' <small class="fa fa-external-link"></small>');
		}else{
			return '<span class="label label-danger">unverified</span>';
		}
	}

	public function callback_verify_status($value='', $row='')
	{
		if($value == 'unverified'){
			$value = '<span class="label label-warning">'.$value.'</span>';
		}else{
			$value = '<span class="label label-success">'.$value.'</span>';
		}
		return $value;
	}

}

?>

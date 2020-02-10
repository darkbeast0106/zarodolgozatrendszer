<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
        parent::__construct();

		$this->load->library( 'template' ); 
		$this->load->helper( 'directory');
		$this->load->model('model_hataridok');
		
		$this->load->helper( 'form' );
		$this->load->helper( 'language' ); 
		$this->load->helper( 'url' );
        
        $this->load->model( 'model_auth' );

        $this->logged_in = $this->model_auth->check( FALSE );
        $this->template->assign( 'logged_in', $this->logged_in );

		$this->lang->load( 'db_fields', 'english' ); // This is the language file
	}


	public function index()
	{
		$this->model_hataridok->pagination( FALSE );
		$data_info = $this->model_hataridok->lister();
        $fields = $this->model_hataridok->fields( TRUE );
        

        $this->template->assign( 'pager', $this->model_hataridok->pager );
		$this->template->assign( 'hataridok_fields', $fields );
		$this->template->assign( 'hataridok_data', $data_info );
        $this->template->assign( 'table_name', 'home' );
		$this->template->assign( 'template', 'home_page' );
   		$this->template->display( 'frame_admin.tpl' );
	}
}

/* End of file dasdhboard.php */
/* Location: ./application/controllers/dasdhboard.php */
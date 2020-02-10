<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Osztalyok extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();

		$this->load->library( 'template' ); 
		$this->load->model( 'model_osztalyok' ); 
		
		$this->load->helper( 'form' );
		$this->load->helper( 'language' ); 
		$this->load->helper( 'url' );
        $this->load->model( 'model_auth' );

        /*
         * Betölti a munkamenetből a felhasználói adatokat és
         * ha nem talál bejelentkezett felhasználót akkor
         * visszairányít a főoldalra
         */
        $this->logged_in = $this->model_auth->check( TRUE );
        $this->template->assign( 'logged_in', $this->logged_in );

        /*
         * 4-es jogosultságtól felfele találhatóak az iskola vezetői
         * 8-tól a koordinátor
         */
        if ($this->logged_in['permission'] < 4) { 
        
            redirect( base_url() );
        }

		$this->lang->load( 'db_fields', 'english' ); // This is the language file
	}



    /**
     *  LISTS MODEL DATA INTO A TABLE
     */         
    function index( $page = 0 )
    {
        $this->model_osztalyok->pagination( TRUE );
		$data_info = $this->model_osztalyok->lister( $page );
        $fields = $this->model_osztalyok->fields( TRUE );
        

        $this->template->assign( 'pager', $this->model_osztalyok->pager );
		$this->template->assign( 'osztalyok_fields', $fields );
		$this->template->assign( 'osztalyok_data', $data_info );
        $this->template->assign( 'table_name', 'Osztalyok' );
        $this->template->assign( 'template', 'list_osztalyok' );
        
		$this->template->display( 'frame_admin.tpl' );
    }



    /**
     *  SHOWS A RECORD VIEW
     */
    function show( $id )
    {
		$data = $this->model_osztalyok->get( $id );
        $fields = $this->model_osztalyok->fields( TRUE );
        

        
        $this->template->assign( 'id', $id );
		$this->template->assign( 'osztalyok_fields', $fields );
		$this->template->assign( 'osztalyok_data', $data );
		$this->template->assign( 'table_name', 'Osztalyok' );
		$this->template->assign( 'template', 'show_osztalyok' );
		$this->template->display( 'frame_admin.tpl' );
    }



    /**
     *  SHOWS A FROM, AND HANDLES SAVING IT
     */         
    function create( $id = false )
    {
        if ($this->logged_in['permission'] < 8) {
            redirect( base_url() );
        }
        $this->load->library('form_validation');
        
		switch ( $_SERVER ['REQUEST_METHOD'] )
        {
            case 'GET':
                $fields = $this->model_osztalyok->fields();
                $tanarok_set = $this->model_osztalyok->related_tanarok();

                $this->template->assign( 'related_tanarok', $tanarok_set );

                
                $this->template->assign( 'action_mode', 'create' );
        		$this->template->assign( 'osztalyok_fields', $fields );
                $this->template->assign( 'metadata', $this->model_osztalyok->metadata() );
        		$this->template->assign( 'table_name', 'Osztalyok' );
        		$this->template->assign( 'template', 'form_osztalyok' );
        		$this->template->display( 'frame_admin.tpl' );
            break;

            /**
             *  Insert data TO osztalyok table
             */
            case 'POST':
                $fields = $this->model_osztalyok->fields();

                /* we set the rules */
                /* don't forget to edit these */
				$this->form_validation->set_rules( 'osztaly_nev', lang('osztaly_nev'), 'required|max_length[8]' );
				$this->form_validation->set_rules( 'osztalyfonok_id', lang('osztalyfonok_id'), 'required|max_length[11]|integer' );
				$this->form_validation->set_rules( 'vegzes_eve', lang('vegzes_eve'), 'required|max_length[4]' );

				$data_post['osztaly_nev'] = $this->input->post( 'osztaly_nev' );
				$data_post['osztalyfonok_id'] = $this->input->post( 'osztalyfonok_id' );
				$data_post['vegzes_eve'] = $this->input->post( 'vegzes_eve' );

                if ( $this->form_validation->run() == FALSE )
                {
                    $errors = validation_errors();
                    
                    $tanarok_set = $this->model_osztalyok->related_tanarok();

                    $this->template->assign( 'related_tanarok', $tanarok_set );

                    
              		$this->template->assign( 'errors', $errors );
              		$this->template->assign( 'action_mode', 'create' );
            		$this->template->assign( 'osztalyok_data', $data_post );
            		$this->template->assign( 'osztalyok_fields', $fields );
                    $this->template->assign( 'metadata', $this->model_osztalyok->metadata() );
            		$this->template->assign( 'table_name', 'Osztalyok' );
            		$this->template->assign( 'template', 'form_osztalyok' );
            		$this->template->display( 'frame_admin.tpl' );
                }
                elseif ( $this->form_validation->run() == TRUE )
                {
                    $insert_id = $this->model_osztalyok->insert( $data_post );
                    
					redirect( 'osztalyok' );
                }
            break;
        }
    }



    /**
     *  DISPLAYS THE POPULATED FORM OF THE RECORD
     *  This method uses the same template as the create method
     */
    function edit( $id = false )
    {
        if ($this->logged_in['permission'] < 8) {
            if ($id) {
                redirect( base_url().'osztalyok/show/'.$id );
            }else{
                redirect( base_url().'osztalyok' );
            }
            
        }
        $this->load->library('form_validation');

        switch ( $_SERVER ['REQUEST_METHOD'] )
        {
            case 'GET':
                $this->model_osztalyok->raw_data = TRUE;
        		$data = $this->model_osztalyok->get( $id );
                $fields = $this->model_osztalyok->fields();
                $tanarok_set = $this->model_osztalyok->related_tanarok();

                
                $this->template->assign( 'related_tanarok', $tanarok_set );

                
          		$this->template->assign( 'action_mode', 'edit' );
        		$this->template->assign( 'osztalyok_data', $data );
        		$this->template->assign( 'osztalyok_fields', $fields );
                $this->template->assign( 'metadata', $this->model_osztalyok->metadata() );
        		$this->template->assign( 'table_name', 'Osztalyok' );
        		$this->template->assign( 'template', 'form_osztalyok' );
        		$this->template->assign( 'record_id', $id );
        		$this->template->display( 'frame_admin.tpl' );
            break;
    
            case 'POST':
    
                $fields = $this->model_osztalyok->fields();
                /* we set the rules */
                /* don't forget to edit these */
				$this->form_validation->set_rules( 'osztaly_nev', lang('osztaly_nev'), 'required|max_length[8]' );
				$this->form_validation->set_rules( 'osztalyfonok_id', lang('osztalyfonok_id'), 'required|max_length[11]|integer' );
				$this->form_validation->set_rules( 'vegzes_eve', lang('vegzes_eve'), 'required|max_length[4]' );

				$data_post['osztaly_nev'] = $this->input->post( 'osztaly_nev' );
				$data_post['osztalyfonok_id'] = $this->input->post( 'osztalyfonok_id' );
				$data_post['vegzes_eve'] = $this->input->post( 'vegzes_eve' );

                if ( $this->form_validation->run() == FALSE )
                {
                    $errors = validation_errors();
                    
                    $tanarok_set = $this->model_osztalyok->related_tanarok();

                    $this->template->assign( 'related_tanarok', $tanarok_set );

                    
              		$this->template->assign( 'action_mode', 'edit' );
              		$this->template->assign( 'errors', $errors );
            		$this->template->assign( 'osztalyok_data', $data_post );
            		$this->template->assign( 'osztalyok_fields', $fields );
                    $this->template->assign( 'metadata', $this->model_osztalyok->metadata() );
            		$this->template->assign( 'table_name', 'Osztalyok' );
            		$this->template->assign( 'template', 'form_osztalyok' );
        		    $this->template->assign( 'record_id', $id );
            		$this->template->display( 'frame_admin.tpl' );
                }
                elseif ( $this->form_validation->run() == TRUE )
                {
				    $this->model_osztalyok->update( $id, $data_post );
				    
					redirect( 'osztalyok/show/' . $id );   
                }
            break;
        }
    }



    /**
     *  DELETE RECORD(S)
     *  The 'delete' method of the model accepts int and array  
     */
    function delete( $id = FALSE )
    {
        if ($this->logged_in['permission'] < 8) {
            redirect( base_url().'osztalyok' );
        }
        switch ( $_SERVER ['REQUEST_METHOD'] )
        {
            case 'GET':
                $this->model_osztalyok->delete( $id );
                redirect( $_SERVER['HTTP_REFERER'] );
            break;

            case 'POST':
                $this->model_osztalyok->delete( $this->input->post('delete_ids') );
                redirect( $_SERVER['HTTP_REFERER'] );
            break;
        }
    }
}

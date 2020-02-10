<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hataridok extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();

		$this->load->library( 'template' ); 
		$this->load->model( 'model_hataridok' ); 
		
		$this->load->helper( 'form' );
		$this->load->helper( 'language' ); 
		$this->load->helper( 'url' );
        $this->load->model( 'model_auth' );

        $this->logged_in = $this->model_auth->check( TRUE );
        $this->template->assign( 'logged_in', $this->logged_in );
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
        $this->model_hataridok->pagination( TRUE );
		$data_info = $this->model_hataridok->lister( $page );
        $fields = $this->model_hataridok->fields( TRUE );
        

        $this->template->assign( 'pager', $this->model_hataridok->pager );
		$this->template->assign( 'hataridok_fields', $fields );
		$this->template->assign( 'hataridok_data', $data_info );
        $this->template->assign( 'table_name', 'Hataridok' );
        $this->template->assign( 'template', 'list_hataridok' );
        
		$this->template->display( 'frame_admin.tpl' );
    }



    /**
     *  SHOWS A RECORD VIEW
     */
    function show( $id )
    {
		$data = $this->model_hataridok->get( $id );
        $fields = $this->model_hataridok->fields( TRUE );
        

        
        $this->template->assign( 'id', $id );
		$this->template->assign( 'hataridok_fields', $fields );
		$this->template->assign( 'hataridok_data', $data );
		$this->template->assign( 'table_name', 'Hataridok' );
		$this->template->assign( 'template', 'show_hataridok' );
		$this->template->display( 'frame_admin.tpl' );
    }



    /**
     *  SHOWS A FROM, AND HANDLES SAVING IT
     */         
    function create( $id = false )
    {
		$this->load->library('form_validation');
        
		switch ( $_SERVER ['REQUEST_METHOD'] )
        {
            case 'GET':
                $fields = $this->model_hataridok->fields();
                
                
                
                $this->template->assign( 'action_mode', 'create' );
        		$this->template->assign( 'hataridok_fields', $fields );
                $this->template->assign( 'metadata', $this->model_hataridok->metadata() );
        		$this->template->assign( 'table_name', 'Hataridok' );
        		$this->template->assign( 'template', 'form_hataridok' );
        		$this->template->display( 'frame_admin.tpl' );
            break;

            /**
             *  Insert data TO hataridok table
             */
            case 'POST':
                $fields = $this->model_hataridok->fields();

                /* we set the rules */
                /* don't forget to edit these */
				$this->form_validation->set_rules( 'hatarido_megnevezes', lang('hatarido_megnevezes'), 'required' );
				$this->form_validation->set_rules( 'hataridok_ertek', lang('hataridok_ertek'), 'required' );
                
				$data_post['hatarido_megnevezes'] = $this->input->post( 'hatarido_megnevezes' );
				$data_post['hataridok_ertek'] = $this->input->post( 'hataridok_ertek' );
                
                if ( $this->form_validation->run() == FALSE )
                {
                    $errors = validation_errors();
                    
                    
                    
                    
              		$this->template->assign( 'errors', $errors );
              		$this->template->assign( 'action_mode', 'create' );
            		$this->template->assign( 'hataridok_data', $data_post );
            		$this->template->assign( 'hataridok_fields', $fields );
                    $this->template->assign( 'metadata', $this->model_hataridok->metadata() );
            		$this->template->assign( 'table_name', 'Hataridok' );
            		$this->template->assign( 'template', 'form_hataridok' );
            		$this->template->display( 'frame_admin.tpl' );
                }
                elseif ( $this->form_validation->run() == TRUE )
                {
                    $insert_id = $this->model_hataridok->insert( $data_post );
                    
					redirect( 'hataridok' );
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
        $this->load->library('form_validation');

        switch ( $_SERVER ['REQUEST_METHOD'] )
        {
            case 'GET':
                $this->model_hataridok->raw_data = TRUE;
        		$data = $this->model_hataridok->get( $id );
                $fields = $this->model_hataridok->fields();
                
                
                
                
          		$this->template->assign( 'action_mode', 'edit' );
        		$this->template->assign( 'hataridok_data', $data );
        		$this->template->assign( 'hataridok_fields', $fields );
                $this->template->assign( 'metadata', $this->model_hataridok->metadata() );
        		$this->template->assign( 'table_name', 'Hataridok' );
        		$this->template->assign( 'template', 'form_hataridok' );
        		$this->template->assign( 'record_id', $id );
        		$this->template->display( 'frame_admin.tpl' );
            break;
    
            case 'POST':
    
                $fields = $this->model_hataridok->fields();
                /* we set the rules */
                /* don't forget to edit these */
				//$this->form_validation->set_rules( 'hatarido_megnevezes', lang('hatarido_megnevezes'), 'required' );
				$this->form_validation->set_rules( 'hataridok_ertek', lang('hataridok_ertek'), 'required' );

				//$data_post['hatarido_megnevezes'] = $this->input->post( 'hatarido_megnevezes' );
				$data_post['hataridok_ertek'] = $this->input->post( 'hataridok_ertek' );

                if ( $this->form_validation->run() == FALSE )
                {
                    $errors = validation_errors();
                    
                    
                    
                    
              		$this->template->assign( 'action_mode', 'edit' );
              		$this->template->assign( 'errors', $errors );
            		$this->template->assign( 'hataridok_data', $data_post );
            		$this->template->assign( 'hataridok_fields', $fields );
                    $this->template->assign( 'metadata', $this->model_hataridok->metadata() );
            		$this->template->assign( 'table_name', 'Hataridok' );
            		$this->template->assign( 'template', 'form_hataridok' );
        		    $this->template->assign( 'record_id', $id );
            		$this->template->display( 'frame_admin.tpl' );
                }
                elseif ( $this->form_validation->run() == TRUE )
                {
				    $this->model_hataridok->update( $id, $data_post );
				    
					redirect( 'hataridok' );   
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
        switch ( $_SERVER ['REQUEST_METHOD'] )
        {
            case 'GET':
                $this->model_hataridok->delete( $id );
                redirect( $_SERVER['HTTP_REFERER'] );
            break;

            case 'POST':
                $this->model_hataridok->delete( $this->input->post('delete_ids') );
                redirect( $_SERVER['HTTP_REFERER'] );
            break;
        }
    }
}

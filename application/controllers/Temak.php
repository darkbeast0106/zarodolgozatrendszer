<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Temak extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();

		$this->load->library( 'template' ); 
		$this->load->model( 'model_temak' ); 
		
		$this->load->helper( 'form' );
		$this->load->helper( 'language' ); 
		$this->load->helper( 'url' );
        $this->load->model( 'model_auth' );

        $this->logged_in = $this->model_auth->check( FALSE );
        $this->template->assign( 'logged_in', $this->logged_in );
        $this->lang->load( 'db_fields', 'english' ); // This is the language file
	}



    /**
     *  LISTS MODEL DATA INTO A TABLE
     */         
    function index( $page = 0 )
    {
        $this->model_temak->pagination( TRUE );
        //$this->model_temak->pagination_per_page = 20;
		$data_info = $this->model_temak->lister( $page );
        $fields = $this->model_temak->fields( TRUE );
        $this->template->assign( 'pager', $this->model_temak->pager );
		$this->template->assign( 'temak_fields', $fields );
        
		$this->template->assign( 'temak_data', $data_info );
        $this->template->assign( 'table_name', 'Temak' );
        $this->template->assign( 'template', 'list_temak' );
        
		$this->template->display( 'frame_admin.tpl' );
        //var_dump($data_info);
    }

    function own( $page = 0 )
    {
        if ($this->logged_in['permission'] < 1 || $this->logged_in['permission'] % 2 != 1) {
            redirect( base_url() . 'temak');
        } else {
            $this->model_temak->pagination( FALSE );
            $data_info = $this->model_temak->own( $page );
            $fields = $this->model_temak->fields( TRUE );
            $this->template->assign( 'pager', $this->model_temak->pager );
            $this->template->assign( 'temak_fields', $fields );
            $this->template->assign( 'temak_data', $data_info );
            $this->template->assign( 'action_mode', 'own' );
            $this->template->assign( 'table_name', 'Temak' );
            $this->template->assign( 'template', 'list_sajattemak' );
            
            $this->template->display( 'frame_admin.tpl' );
        }
    }

    /**
     *  SHOWS A RECORD VIEW
     */
    function show( $id )
    {
		$data = $this->model_temak->get( $id );
        $fields = $this->model_temak->fields( TRUE );
        
        $this->template->assign( 'id', $id );
		$this->template->assign( 'temak_fields', $fields );
		$this->template->assign( 'temak_data', $data );
		$this->template->assign( 'table_name', 'Temak' );
		$this->template->assign( 'template', 'show_temak' );
		$this->template->display( 'frame_admin.tpl' );
    }



    /**
     *  SHOWS A FROM, AND HANDLES SAVING IT
     */         
    function create( $id = false )
    {
        if ($this->logged_in['permission'] < 1 || $this->logged_in['permission'] % 2 != 1) {
            redirect(base_url().'temak');
        } else {
        	$this->load->library('form_validation');
            
    		switch ( $_SERVER ['REQUEST_METHOD'] )
            {
                case 'GET':
                    $fields = $this->model_temak->fields();
                    $tanarok_set = $this->model_temak->related_tanarok();

                    $this->template->assign( 'related_tanarok', $tanarok_set );

                    $this->template->assign( 'action_mode', 'create' );
            		$this->template->assign( 'temak_fields', $fields );
                    $this->template->assign( 'metadata', $this->model_temak->metadata() );
            		$this->template->assign( 'table_name', 'Temak' );
            		$this->template->assign( 'template', 'form_temak' );
            		$this->template->display( 'frame_admin.tpl' );
                break;

                /**
                 *  Insert data TO temak table
                 */
                case 'POST':
                    $fields = $this->model_temak->fields();

                    /* we set the rules */
                    /* don't forget to edit these */
    				$this->form_validation->set_rules( 'tema_cim', lang('tema_cim'), 'required|max_length[128]' );

    				$data_post['kiiro_id'] = $this->logged_in['uid'];
    				$data_post['tema_cim'] = $this->input->post( 'tema_cim' );
    				$data_post['tema_leiras'] = $this->input->post( 'tema_leiras' );
    				$data_post['tema_eszkozok'] = $this->input->post( 'tema_eszkozok' );
    				$data_post['tema_evszam'] = date("Y");

                    if ( $this->form_validation->run() == FALSE )
                    {
                        $errors = validation_errors();
                        
                        $tanarok_set = $this->model_temak->related_tanarok();

                        $this->template->assign( 'related_tanarok', $tanarok_set );

                        
                  		$this->template->assign( 'errors', $errors );
                  		$this->template->assign( 'action_mode', 'create' );
                		$this->template->assign( 'temak_data', $data_post );
                		$this->template->assign( 'temak_fields', $fields );
                        $this->template->assign( 'metadata', $this->model_temak->metadata() );
                		$this->template->assign( 'table_name', 'Temak' );
                		$this->template->assign( 'template', 'form_temak' );
                		$this->template->display( 'frame_admin.tpl' );
                    }
                    elseif ( $this->form_validation->run() == TRUE )
                    {
                        $insert_id = $this->model_temak->insert( $data_post );
                        
    					redirect( 'temak' );
                    }
                break;
            }
        }
    }



    /**
     *  DISPLAYS THE POPULATED FORM OF THE RECORD
     *  This method uses the same template as the create method
     */
    function edit( $id = false )
    {
        if (!$this->model_temak->checkifown($id)) {
            redirect( base_url() . 'temak');
        } else {
            $this->load->library('form_validation');

            switch ( $_SERVER ['REQUEST_METHOD'] )
            {
                case 'GET':
                    $this->model_temak->raw_data = TRUE;
            		$data = $this->model_temak->get( $id );
                    $fields = $this->model_temak->fields();
                    $tanarok_set = $this->model_temak->related_tanarok();

                    
                    $this->template->assign( 'related_tanarok', $tanarok_set );

                    
              		$this->template->assign( 'action_mode', 'edit' );
            		$this->template->assign( 'temak_data', $data );
            		$this->template->assign( 'temak_fields', $fields );
                    $this->template->assign( 'metadata', $this->model_temak->metadata() );
            		$this->template->assign( 'table_name', 'Temak' );
            		$this->template->assign( 'template', 'form_temak' );
            		$this->template->assign( 'record_id', $id );
            		$this->template->display( 'frame_admin.tpl' );
                break;
        
                case 'POST':
        
                    $fields = $this->model_temak->fields();
                    /* we set the rules */
                    /* don't forget to edit these */
    				$this->form_validation->set_rules( 'tema_cim', lang('tema_cim'), 'required|max_length[128]' );
    				
    				$data_post['tema_cim'] = $this->input->post( 'tema_cim' );
    				$data_post['tema_leiras'] = $this->input->post( 'tema_leiras' );
    				$data_post['tema_eszkozok'] = $this->input->post( 'tema_eszkozok' );
    				$data_post['tema_evszam'] = date("Y");

                    if ( $this->form_validation->run() == FALSE )
                    {
                        $errors = validation_errors();
                        
                        $tanarok_set = $this->model_temak->related_tanarok();

                        $this->template->assign( 'related_tanarok', $tanarok_set );

                        
                  		$this->template->assign( 'action_mode', 'edit' );
                  		$this->template->assign( 'errors', $errors );
                		$this->template->assign( 'temak_data', $data_post );
                		$this->template->assign( 'temak_fields', $fields );
                        $this->template->assign( 'metadata', $this->model_temak->metadata() );
                		$this->template->assign( 'table_name', 'Temak' );
                		$this->template->assign( 'template', 'form_temak' );
            		    $this->template->assign( 'record_id', $id );
                		$this->template->display( 'frame_admin.tpl' );
                    }
                    elseif ( $this->form_validation->run() == TRUE )
                    {
    				    $this->model_temak->update( $id, $data_post );
    				    
    					redirect( 'temak/show/' . $id );   
                    }
                break;
            }
        }
    }



    /**
     *  DELETE RECORD(S)
     *  The 'delete' method of the model accepts int and array  
     */
    function delete( $id = FALSE )
    {
        if ($this->logged_in['permission'] > 0) {
            if ($this->logged_in['permission'] >= 8) {
                // !!! Üzenet küldése, hogy törölve lett a téma
                switch ( $_SERVER ['REQUEST_METHOD'] )
                {
                    case 'GET':
                        $this->model_temak->delete( $id );
                        redirect( $_SERVER['HTTP_REFERER'] );
                    break;

                    case 'POST':
                        $this->model_temak->delete( $this->input->post('delete_ids') );
                        redirect( $_SERVER['HTTP_REFERER'] );
                    break;
                }
            } else {
                if($this->logged_in['permission'] % 2 == 1 && $this->model_temak->checkifown($id)){
                    switch ( $_SERVER ['REQUEST_METHOD'] )
                    {
                        case 'GET':
                            $this->model_temak->delete( $id );
                            redirect( $_SERVER['HTTP_REFERER'] );
                        break;

                        case 'POST':
                            $this->model_temak->delete( $this->input->post('delete_ids') );
                            redirect( $_SERVER['HTTP_REFERER'] );
                        break;
                    }
                }
                else {
                    redirect( base_url() . 'temak');
                }
            }
            

        } else {
            redirect( base_url() . 'temak');
        }
    }
}

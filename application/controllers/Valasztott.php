<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Valasztott extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();

		$this->load->library( 'template' ); 
		$this->load->model( 'model_valasztott' ); 
		
		$this->load->helper( 'form' );
		$this->load->helper( 'language' ); 
		$this->load->helper( 'url' );
        $this->load->model( 'model_auth' );

        $this->logged_in = $this->model_auth->check( TRUE );
        $this->template->assign( 'logged_in', $this->logged_in );

        if ($this->logged_in['permission'] != -1) {
            redirect( base_url() );
        }
		$this->lang->load( 'db_fields', 'english' ); // This is the language file
	}



    /**
     *  LISTS MODEL DATA INTO A TABLE
     */         
    function index( $page = 0 )
    {
        $tema = $this->model_valasztott->getDiakTema($this->logged_in['uid']);
        if (empty($tema)) {
            redirect(base_url().'valasztott/create');
        }else{
            redirect(base_url().'valasztott/show/'.$tema['valasztott_id']);
        }
    }



    /**
     *  SHOWS A RECORD VIEW
     */
    function show( $id )
    {
        $tema = $this->model_valasztott->getDiakTema($this->logged_in['uid']);
        if ($tema['valasztott_id'] != $id) {
            redirect(base_url().'valasztott');
        }
		$data = $this->model_valasztott->get( $id );

        if (empty($data)) {
            redirect(base_url());
        }

        $fields = $this->model_valasztott->fields( TRUE );
        
        $this->template->assign( 'id', $id );
		$this->template->assign( 'valasztott_fields', $fields );
		$this->template->assign( 'valasztott_data', $data );
		$this->template->assign( 'table_name', 'Valasztott' );
		$this->template->assign( 'template', 'show_valasztott' );
		$this->template->display( 'frame_admin.tpl' );
    }

   function szabadhely()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            redirect(base_url());
        }
        $id = $this->input->post('id');
        $data = $this->model_valasztott->szabadhely( $id );
        echo $data;
    }
    /**
     *  SHOWS A FROM, AND HANDLES SAVING IT
     */         
    function create( $id = false )
    {
        $tema = $this->model_valasztott->getDiakTema($this->logged_in['uid']);
        if (!empty($tema)) {
            redirect(base_url().'valasztott/show/'.$tema['valasztott_id']);
        }
        $this->load->library('form_validation');
		$this->load->library('javascript');
        
		switch ( $_SERVER ['REQUEST_METHOD'] )
        {
            case 'GET':
                $fields = $this->model_valasztott->fields();
                $diakok_set = $this->model_valasztott->related_diakok();
                $tanarok_set = $this->model_valasztott->related_tanarok();
                $temak_set = $this->model_valasztott->related_temak();

                $this->template->assign( 'related_diakok', $diakok_set );
                $this->template->assign( 'related_tanarok', $tanarok_set );
                $this->template->assign( 'related_temak', $temak_set );

                
                $this->template->assign( 'action_mode', 'create' );
        		$this->template->assign( 'valasztott_fields', $fields );
                $this->template->assign( 'metadata', $this->model_valasztott->metadata() );
        		$this->template->assign( 'table_name', 'Valasztott' );
        		$this->template->assign( 'template', 'form_valasztott' );
        		$this->template->display( 'frame_admin.tpl' );
            break;

            /**
             *  Insert data TO valasztott table
             */
            case 'POST':
                $fields = $this->model_valasztott->fields();

                /* we set the rules */
                /* don't forget to edit these */
				$this->form_validation->set_rules( 'konzulens_id', lang('konzulens_id'), 'required|max_length[11]|integer' );
				$this->form_validation->set_rules( 'valasztott_tema_id', lang('valasztott_tema_id'), 'max_length[11]' );
				$this->form_validation->set_rules( 'valasztott_cim', lang('valasztott_cim'), 'required|max_length[128]' );
				$this->form_validation->set_rules( 'valasztott_link', lang('valasztott_link'), 'required|max_length[256]' );

				$data_post['valaszto_diak_id'] = $this->logged_in['uid'];
				$data_post['konzulens_id'] = ($this->input->post( 'konzulens_id' ) == 0)? NULL : $this->input->post( 'konzulens_id' );
				$data_post['valasztott_tema_id'] = ($this->input->post( 'valasztott_tema_id' ) == 0)? NULL : $this->input->post( 'valasztott_tema_id' );
				$data_post['valasztott_cim'] = $this->input->post( 'valasztott_cim' );
				$data_post['valasztott_link'] = $this->input->post( 'valasztott_link' );

                if ( $this->form_validation->run() == FALSE )
                {
                    $errors = validation_errors();
                    
                    $diakok_set = $this->model_valasztott->related_diakok();
                    $tanarok_set = $this->model_valasztott->related_tanarok();
                    $temak_set = $this->model_valasztott->related_temak();

                    $this->template->assign( 'related_diakok', $diakok_set );
                    $this->template->assign( 'related_tanarok', $tanarok_set );
                    $this->template->assign( 'related_temak', $temak_set );

                    
              		$this->template->assign( 'errors', $errors );
              		$this->template->assign( 'action_mode', 'create' );
            		$this->template->assign( 'valasztott_data', $data_post );
            		$this->template->assign( 'valasztott_fields', $fields );
                    $this->template->assign( 'metadata', $this->model_valasztott->metadata() );
            		$this->template->assign( 'table_name', 'Valasztott' );
            		$this->template->assign( 'template', 'form_valasztott' );
            		$this->template->display( 'frame_admin.tpl' );
                }
                elseif ( $this->form_validation->run() == TRUE )
                {
                    $insert_id = $this->model_valasztott->insert( $data_post );
                    
					redirect( 'valasztott' );
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
        $this->load->library('javascript');
        $tema = $this->model_valasztott->getDiakTema($this->logged_in['uid']);
        if ($tema['valasztott_id'] != $id || $tema['valasztott_status'] == 'Teljesen elkészült') {
            redirect(base_url().'valasztott');
        }
        switch ( $_SERVER ['REQUEST_METHOD'] )
        {
            case 'GET':
                $this->model_valasztott->raw_data = TRUE;
        		$data = $this->model_valasztott->get( $id );
                if (empty($data)) {
                    redirect(base_url());
                }
                $fields = $this->model_valasztott->fields();
                $diakok_set = $this->model_valasztott->related_diakok();
                $tanarok_set = $this->model_valasztott->related_tanarok();
                $temak_set = $this->model_valasztott->related_temak();

                
                $this->template->assign( 'related_diakok', $diakok_set );
                $this->template->assign( 'related_tanarok', $tanarok_set );
                $this->template->assign( 'related_temak', $temak_set );

                
          		$this->template->assign( 'action_mode', 'edit' );
        		$this->template->assign( 'valasztott_data', $data );
        		$this->template->assign( 'valasztott_fields', $fields );
                $this->template->assign( 'metadata', $this->model_valasztott->metadata() );
        		$this->template->assign( 'table_name', 'Valasztott' );
        		$this->template->assign( 'template', 'form_valasztott' );
        		$this->template->assign( 'record_id', $id );
        		$this->template->display( 'frame_admin.tpl' );
            break;
    
            case 'POST':
    
                $fields = $this->model_valasztott->fields();
                /* we set the rules */
                /* don't forget to edit these */
                if ($tema['valasztott_status'] == 'Elfogadásra vár' ||$tema['valasztott_status'] == 'Elutsítva') {
                    $this->form_validation->set_rules( 'konzulens_id', lang('konzulens_id'), 'required|max_length[11]|integer' );
                }
                if ($tema['valasztott_status'] != '2. Bemutatás megtörtént' && $tema['valasztott_status'] != '3. Bemutatás megtörtént') {
                    $this->form_validation->set_rules( 'valasztott_tema_id', lang('valasztott_tema_id'), 'max_length[11]' );
                    $this->form_validation->set_rules( 'valasztott_cim', lang('valasztott_cim'), 'required|max_length[128]' );
                }
				$this->form_validation->set_rules( 'valasztott_link', lang('valasztott_link'), 'required|max_length[256]' );

                if ($tema['valasztott_status'] == 'Elfogadásra vár' ||$tema['valasztott_status'] == 'Elutsítva') {
				    $data_post['konzulens_id'] = $this->input->post( 'konzulens_id' );
                }
                if ($tema['valasztott_status'] != '2. Bemutatás megtörtént' && $tema['valasztott_status'] != '3. Bemutatás megtörtént') {
    				$data_post['valasztott_tema_id'] = ($this->input->post( 'valasztott_tema_id' ) == 0)? NULL : $this->input->post( 'valasztott_tema_id' );
    				$data_post['valasztott_cim'] = $this->input->post( 'valasztott_cim' );
                }
				$data_post['valasztott_link'] = $this->input->post( 'valasztott_link' );


                if ( $this->form_validation->run() == FALSE )
                {
                    $data_post['valasztott_status'] = $this->input->post( 'valasztott_status' );
                    $errors = validation_errors();
                    
                    $diakok_set = $this->model_valasztott->related_diakok();
                    $tanarok_set = $this->model_valasztott->related_tanarok();
                    $temak_set = $this->model_valasztott->related_temak();

                    $this->template->assign( 'related_diakok', $diakok_set );
                    $this->template->assign( 'related_tanarok', $tanarok_set );
                    $this->template->assign( 'related_temak', $temak_set );

                    
              		$this->template->assign( 'action_mode', 'edit' );
              		$this->template->assign( 'errors', $errors );
            		$this->template->assign( 'valasztott_data', $data_post );
            		$this->template->assign( 'valasztott_fields', $fields );
                    $this->template->assign( 'metadata', $this->model_valasztott->metadata() );
            		$this->template->assign( 'table_name', 'Valasztott' );
            		$this->template->assign( 'template', 'form_valasztott' );
        		    $this->template->assign( 'record_id', $id );
            		$this->template->display( 'frame_admin.tpl' );
                }
                elseif ( $this->form_validation->run() == TRUE )
                {
                     if ($this->input->post( 'valasztott_status' ) == 'Elutasítva') {
                         $data_post['valasztott_status'] = 'elfogadasra_var';
                     }
				    $this->model_valasztott->update( $id, $data_post );
				    
					redirect( 'valasztott/show/' . $id );   
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
            redirect( base_url() );
        }
        switch ( $_SERVER ['REQUEST_METHOD'] )
        {
            case 'GET':
                $this->model_valasztott->delete( $id );
                redirect( $_SERVER['HTTP_REFERER'] );
            break;

            case 'POST':
                $this->model_valasztott->delete( $this->input->post('delete_ids') );
                redirect( $_SERVER['HTTP_REFERER'] );
            break;
        }
    }
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tanarok extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();

		$this->load->library( 'template' ); 
		$this->load->model( 'model_tanarok' ); 
        $this->load->model( 'model_felhasznalok' ); 
		
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
        $this->model_tanarok->pagination( TRUE );
        $data_info = $this->model_tanarok->lister($page);
        
        $fields = $this->model_tanarok->fields( TRUE );
        $fields += $this->model_felhasznalok->fields( TRUE );

        $this->template->assign( 'pager', $this->model_tanarok->pager );
		$this->template->assign( 'tanarok_fields', $fields );
		$this->template->assign( 'tanarok_data', $data_info );
        $this->template->assign( 'table_name', 'Tanarok' );
        $this->template->assign( 'template', 'list_tanarok' );
        
		$this->template->display( 'frame_admin.tpl' );
    }



    /**
     *  SHOWS A RECORD VIEW
     */
    function show( $id = false )
    {
        if (!is_numeric($id)) {
            redirect( base_url().'tanarok' );
        }
        $data = $this->model_tanarok->get( $id );
        if (empty($data)) {
            redirect( base_url().'tanarok' );
        }
        $data += $this->model_felhasznalok->get( $id );
        $fields = $this->model_tanarok->fields( TRUE );
        $fields += $this->model_felhasznalok->fields( TRUE );

        $this->template->assign( 'id', $id );
		$this->template->assign( 'tanarok_fields', $fields );
        $this->template->assign( 'tanarok_data', $data );
        $this->template->assign( 'table_name', 'Tanarok' );
		$this->template->assign( 'template', 'show_tanarok' );
		$this->template->display( 'frame_admin.tpl' );
    }



    /**
     *  SHOWS A FROM, AND HANDLES SAVING IT
     */         
    function create( $id = false )
    {
        if ($this->logged_in['permission'] < 8) {
            redirect( base_url().'tanarok' );
        }
        $this->load->library('form_validation');

		switch ( $_SERVER ['REQUEST_METHOD'] )
        {
            case 'GET':
                $fields = $this->model_tanarok->fields();
                $fields += $this->model_felhasznalok->fields( TRUE );
                $jogosultsag_set = $this->model_tanarok->related_jogosultsag();

                $this->template->assign( 'related_jogosultsag', $jogosultsag_set );

                
                $this->template->assign( 'action_mode', 'create' );
        		$this->template->assign( 'tanarok_fields', $fields );
                $this->template->assign( 'metadata', $this->model_tanarok->metadata() );
        		$this->template->assign( 'table_name', 'Tanarok' );
        		$this->template->assign( 'template', 'form_tanarok' );
        		$this->template->display( 'frame_admin.tpl' );
            break;

            /**
             *  Insert data TO tanarok table
             */
            case 'POST':
                $fields = $this->model_felhasznalok->fields();
                $fields += $this->model_tanarok->fields();

                /* we set the rules */
                /* don't forget to edit these */
                $this->form_validation->set_rules( 'felhasznalo_id', lang('felhasznalo_id'), 'required|max_length[11]' );
                $this->form_validation->set_rules( 'felhasznalo_nev', lang('felhasznalo_nev'), 'required|max_length[45]' );
                $this->form_validation->set_rules( 'felhasznalo_jelszo', lang('felhasznalo_jelszo'), 'required|max_length[128]' );
                $this->form_validation->set_rules( 'felhasznalo_email', lang('felhasznalo_email'), 'max_length[256]' );
                $this->form_validation->set_rules( 'tanar_vnev', lang('tanar_vnev'), 'required|max_length[45]' );
                $this->form_validation->set_rules( 'tanar_knev', lang('tanar_knev'), 'required|max_length[45]' );
                $this->form_validation->set_rules( 'tanar_knev2', lang('tanar_knev2'), 'max_length[45]' );
                $this->form_validation->set_rules( 'tanar_ferohely', lang('tanar_ferohely'), 'min[0]|max[100]' );
                $this->form_validation->set_rules( 'tanar_jogosultsag_id', lang('tanar_jogosultsag_id'), 'required|max_length[11]|integer' );

                $data_post['felhasznalo_id'] = $this->input->post( 'felhasznalo_id' );
                $data_post['felhasznalo_nev'] = $this->input->post( 'felhasznalo_nev' );
                $data_post['felhasznalo_jelszo'] = md5($this->input->post( 'felhasznalo_jelszo' ));
                $data_post['felhasznalo_email'] = $this->input->post( 'felhasznalo_email' );

                $data_post['tanar_vnev'] = $this->input->post( 'tanar_vnev' );
                $data_post['tanar_knev'] = $this->input->post( 'tanar_knev' );
                $data_post['tanar_knev2'] = $this->input->post( 'tanar_knev2' );
                $data_post['tanar_ferohely'] = empty($this->input->post( 'tanar_ferohely' ))? NULL : $this->input->post( 'tanar_ferohely' );
                $data_post['tanar_jogosultsag_id'] = $this->input->post( 'tanar_jogosultsag_id' );

                if ( $this->form_validation->run() == FALSE )
                {
                    $errors = validation_errors();

                    $jogosultsag_set = $this->model_tanarok->related_jogosultsag();

                    $this->template->assign( 'related_jogosultsag', $jogosultsag_set );

                    
                    $this->template->assign( 'errors', $errors );
                    $this->template->assign( 'action_mode', 'create' );
                    $this->template->assign( 'tanarok_data', $data_post );
                    $this->template->assign( 'tanarok_fields', $fields );

                    $metadata = $this->model_felhasznalok->metadata();
                    $metadata = $this->model_tanarok->metadata();

                    $this->template->assign( 'metadata', $metadata );
                    $this->template->assign( 'table_name', 'Tanarok' );
                    $this->template->assign( 'template', 'form_tanarok' );
                    $this->template->display( 'frame_admin.tpl' );
                    
                }
                elseif ( $this->form_validation->run() == TRUE )
                {
                    if ($this->model_felhasznalok->checkIfIDExists($data_post['felhasznalo_id'])) {
                        $errors = "Az azonosító már létezik.\n";
                    }
                    if ($this->model_felhasznalok->checkIfUserExists($data_post['felhasznalo_nev'])) {
                        if (isset($errors)) {
                            $errors .= "A felhasználónév már létezik.\n";
                        }else{
                            $errors = "A felhasználónév már létezik.\n";
                        }
                    }
                    if (!isset($errors) || empty($errors)) {
                        $data_post_felhasznalo = array(
                            'felhasznalo_id' => $data_post['felhasznalo_id'] , 
                            'felhasznalo_nev' => $data_post['felhasznalo_nev'] , 
                            'felhasznalo_jelszo' => $data_post['felhasznalo_jelszo'] , 
                            'felhasznalo_email' => $data_post['felhasznalo_email']
                        );
                        $data_post_tanar = array(
                            'tanar_felh_id' => $data_post['felhasznalo_id'] , 
                            'tanar_vnev' => $data_post['tanar_vnev'] , 
                            'tanar_knev' => $data_post['tanar_knev'] , 
                            'tanar_knev2' => $data_post['tanar_knev2'] , 
                            'tanar_ferohely' => $data_post['tanar_ferohely'],
                            'tanar_jogosultsag_id' => $data_post['tanar_jogosultsag_id'],
                        );

                        $insert_id = $this->model_felhasznalok->insert( $data_post_felhasznalo );
                        $insert_id = $this->model_tanarok->insert( $data_post_tanar );

                        redirect( 'tanarok' );
                    }
                    else
                    {
                        $jogosultsag_set = $this->model_tanarok->related_jogosultsag();

                        $this->template->assign( 'related_jogosultsag', $jogosultsag_set );

                        
                        $this->template->assign( 'errors', $errors );
                        $this->template->assign( 'action_mode', 'create' );
                        $this->template->assign( 'tanarok_data', $data_post );
                        $this->template->assign( 'tanarok_fields', $fields );

                        $metadata = $this->model_felhasznalok->metadata();
                        $metadata = $this->model_tanarok->metadata();

                        $this->template->assign( 'metadata', $metadata );
                        $this->template->assign( 'table_name', 'Tanarok' );
                        $this->template->assign( 'template', 'form_tanarok' );
                        $this->template->display( 'frame_admin.tpl' );

                    }
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
            redirect( base_url().'tanarok' );
        }
        if (!is_numeric($id)) {
            redirect( base_url().'tanarok' );
        }
        $this->load->library('form_validation');

        switch ( $_SERVER ['REQUEST_METHOD'] )
        {
            case 'GET':
                $this->model_tanarok->raw_data = TRUE;
        		$data = $this->model_tanarok->get( $id );
                $fields = $this->model_tanarok->fields();

                $data += $this->model_felhasznalok->get( $id );
                $fields += $this->model_felhasznalok->fields( TRUE );


                $jogosultsag_set = $this->model_tanarok->related_jogosultsag();

                
                $this->template->assign( 'related_jogosultsag', $jogosultsag_set );

                
          		$this->template->assign( 'action_mode', 'edit' );
        		$this->template->assign( 'tanarok_data', $data );
        		$this->template->assign( 'tanarok_fields', $fields );
                $this->template->assign( 'metadata', $this->model_tanarok->metadata() );
        		$this->template->assign( 'table_name', 'Tanarok' );
        		$this->template->assign( 'template', 'form_tanarok' );
        		$this->template->assign( 'record_id', $id );
        		$this->template->display( 'frame_admin.tpl' );
            break;
    
            case 'POST':
                $fields = $this->model_felhasznalok->fields();
                $fields += $this->model_tanarok->fields();
                /* we set the rules */
                /* don't forget to edit these */
                $this->form_validation->set_rules( 'felhasznalo_id', lang('felhasznalo_id'), 'required|max_length[11]' );
                $this->form_validation->set_rules( 'felhasznalo_nev', lang('felhasznalo_nev'), 'required|max_length[45]' );
                $this->form_validation->set_rules( 'felhasznalo_jelszo', lang('felhasznalo_jelszo'), 'max_length[128]' );
                $this->form_validation->set_rules( 'felhasznalo_email', lang('felhasznalo_email'), 'max_length[256]' );

                $this->form_validation->set_rules( 'tanar_vnev', lang('tanar_vnev'), 'required|max_length[45]' );
                $this->form_validation->set_rules( 'tanar_knev', lang('tanar_knev'), 'required|max_length[45]' );
                $this->form_validation->set_rules( 'tanar_knev2', lang('tanar_knev2'), 'max_length[45]' );
                $this->form_validation->set_rules( 'tanar_ferohely', lang('tanar_ferohely'), 'min[0]|max[100]' );
                $this->form_validation->set_rules( 'tanar_jogosultsag_id', lang('tanar_jogosultsag_id'), 'required|max_length[11]|integer' );

                $data_post['felhasznalo_id'] = $this->input->post( 'felhasznalo_id' );
                $data_post['felhasznalo_nev'] = $this->input->post( 'felhasznalo_nev' );
                if (!empty($this->input->post( 'felhasznalo_jelszo' ))) {
                    $data_post['felhasznalo_jelszo'] = md5($this->input->post( 'felhasznalo_jelszo' ));
                }
                $data_post['felhasznalo_email'] = $this->input->post( 'felhasznalo_email' );

                $data_post['tanar_vnev'] = $this->input->post( 'tanar_vnev' );
                $data_post['tanar_knev'] = $this->input->post( 'tanar_knev' );
                $data_post['tanar_knev2'] = $this->input->post( 'tanar_knev2' );
                $data_post['tanar_ferohely'] = $this->input->post( 'tanar_ferohely' );
                $data_post['tanar_jogosultsag_id'] = $this->input->post( 'tanar_jogosultsag_id' );


                if ( $this->form_validation->run() == FALSE )
                {
                    $errors = validation_errors();
                    
                    $jogosultsag_set = $this->model_tanarok->related_jogosultsag();

                    $this->template->assign( 'related_jogosultsag', $jogosultsag_set );

                    $this->template->assign( 'action_mode', 'edit' );
                    $this->template->assign( 'errors', $errors );
                    $this->template->assign( 'tanarok_data', $data_post );
                    $this->template->assign( 'tanarok_fields', $fields );
                    
                    $metadata = $this->model_felhasznalok->metadata();
                    $metadata = $this->model_tanarok->metadata();

                    $this->template->assign( 'metadata', $metadata );

                    $this->template->assign( 'table_name', 'Tanarok' );
                    $this->template->assign( 'template', 'form_tanarok' );
                    $this->template->assign( 'record_id', $id );
                    $this->template->display( 'frame_admin.tpl' );
                }
                elseif ( $this->form_validation->run() == TRUE )
                {
                    if ($data_post['felhasznalo_id'] != $id) {
                        if ($this->model_felhasznalok->checkIfIDExists($data_post['felhasznalo_id'])) {
                            $errors = "Az azonosító már létezik.\n";
                        }
                    }
                    if ($data_post['felhasznalo_nev'] != $this->model_felhasznalok->get($id)['felhasznalo_nev']) {
                        if ($this->model_felhasznalok->checkIfUserExists($data_post['felhasznalo_nev'])) {
                            if (isset($errors)) {
                                $errors .= "A felhasználónév már létezik.\n";
                            }else{
                                $errors = "A felhasználónév már létezik.\n";
                            }
                        }
                    }
                    
                    if (!isset($errors) || empty($errors))
                    {
                        if (!empty($this->input->post( 'felhasznalo_jelszo' ))) {
                            $data_post_felhasznalo = array(
                                'felhasznalo_id' => $data_post['felhasznalo_id'] , 
                                'felhasznalo_nev' => $data_post['felhasznalo_nev'] , 
                                'felhasznalo_jelszo' => $data_post['felhasznalo_jelszo'] , 
                                'felhasznalo_email' => $data_post['felhasznalo_email']
                            );
                        } else {
                            $data_post_felhasznalo = array(
                                'felhasznalo_id' => $data_post['felhasznalo_id'] , 
                                'felhasznalo_nev' => $data_post['felhasznalo_nev'] ,
                                'felhasznalo_email' => $data_post['felhasznalo_email']
                            );
                        }
                        $data_post_tanar = array(
                            'tanar_vnev' => $data_post['tanar_vnev'] , 
                            'tanar_knev' => $data_post['tanar_knev'] , 
                            'tanar_knev2' => $data_post['tanar_knev2'] , 
                            'tanar_ferohely' => $data_post['tanar_ferohely'],
                            'tanar_jogosultsag_id' => $data_post['tanar_jogosultsag_id'],
                        );

                        $this->model_felhasznalok->update( $id, $data_post_felhasznalo );
                        $this->model_tanarok->update( $data_post['felhasznalo_id'], $data_post_tanar );
                        
                        redirect( 'tanarok/show/' . $data_post['felhasznalo_id'] );   
                    }
                    else
                    {
                        $jogosultsag_set = $this->model_tanarok->related_jogosultsag();

                        $this->template->assign( 'related_jogosultsag', $jogosultsag_set );

                        $this->template->assign( 'action_mode', 'edit' );
                        $this->template->assign( 'errors', $errors );
                        $this->template->assign( 'tanarok_data', $data_post );
                        $this->template->assign( 'tanarok_fields', $fields );
                        
                        $metadata = $this->model_felhasznalok->metadata();
                        $metadata = $this->model_tanarok->metadata();

                        $this->template->assign( 'metadata', $metadata );

                        $this->template->assign( 'table_name', 'Tanarok' );
                        $this->template->assign( 'template', 'form_tanarok' );
                        $this->template->assign( 'record_id', $id );
                        $this->template->display( 'frame_admin.tpl' );
                        }
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
            redirect( base_url().'tanarok' );
        }
        switch ( $_SERVER ['REQUEST_METHOD'] )
        {

            case 'GET':
                if (!is_numeric($id)) {
                    redirect( base_url().'tanarok' );
                }
                $this->model_tanarok->delete( $id );
                $this->model_felhasznalok->delete( $id );
            break;

            case 'POST':
                $this->model_tanarok->delete( $this->input->post('delete_ids') );
                $this->model_felhasznalok->delete( $this->input->post('delete_ids') );

            break;
        }
        
        redirect( $_SERVER['HTTP_REFERER'] );
    }
}

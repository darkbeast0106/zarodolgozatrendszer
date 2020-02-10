<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Diakok extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();

		$this->load->library( 'template' ); 
		$this->load->model( 'model_diakok' ); 
        $this->load->model( 'model_felhasznalok' ); 
        $this->load->model( 'model_valasztott' ); 
        $this->load->model( 'model_jogosultsag');
		
		$this->load->helper( 'form' );
		$this->load->helper( 'language' ); 
		$this->load->helper( 'url' );
        $this->load->model( 'model_auth' );

        $this->logged_in = $this->model_auth->check( TRUE );
        $this->template->assign( 'logged_in', $this->logged_in );
        if ($this->logged_in['permission'] < 1) {
            redirect( base_url() );
        }
        $this->osztalyfonok = $this->model_jogosultsag->isOsztF($this->logged_in['permission']);

        $this->template->assign( 'osztalyfonok', $this->osztalyfonok );
		$this->lang->load( 'db_fields', 'english' ); // This is the language file
	}



    /**
     *  LISTS MODEL DATA INTO A TABLE
     */         
    function index( $page = 0 )
    {
        if ($this->logged_in['permission'] < 4) {
            switch ($this->logged_in['permission']) {
                case '2':
                    redirect( base_url().'diakok/osztaly' );
                    break;
                
                default:
                    redirect( base_url().'diakok/konzulens' );
                    break;
            }
        }

        $this->model_diakok->pagination( TRUE );
		$data_info = $this->model_diakok->lister( $page );
        $fields = $this->model_diakok->fields( TRUE );
        $fields += $this->model_felhasznalok->fields( TRUE );

        $this->template->assign( 'pager', $this->model_diakok->pager );
		$this->template->assign( 'diakok_fields', $fields );
		$this->template->assign( 'diakok_data', $data_info );
        $this->template->assign( 'table_name', 'Diakok' );
        $this->template->assign( 'template', 'list_diakok' );
        
		$this->template->display( 'frame_admin.tpl' );
    }

    function konzulens( $page = 0 )
    {
        if ($this->logged_in['permission'] % 2 != 1) {
            redirect( base_url().'diakok' );
        }
        $this->model_diakok->pagination( TRUE );
        $data_info = $this->model_diakok->konzulens( $page );
        $fields = $this->model_diakok->fields( TRUE );
        $fields += $this->model_felhasznalok->fields( TRUE );

        $this->template->assign( 'pager', $this->model_diakok->pager );
        $this->template->assign( 'diakok_fields', $fields );
        $this->template->assign( 'diakok_data', $data_info );
        $this->template->assign( 'table_name', 'Diakok' );
        $this->template->assign( 'template', 'list_diakok_konzulens' );
        
        $this->template->display( 'frame_admin.tpl' );

    }
    function elfogad( $id = false)
    {
        if (!$id) {
            redirect(base_url().'diakok');
        }
        if (!$this->model_diakok->konzulense($id,$this->logged_in['uid'])) {
            redirect(base_url().'diakok');
        }
        $this->model_valasztott->elfogad($id);
        redirect($_SERVER['HTTP_REFERER']);
    }
    function elfogad2($id = false)
    {
        if (!$id) {
            redirect(base_url().'diakok');
        }
        if (!$this->model_diakok->konzulense($id,$this->logged_in['uid'])) {
            redirect(base_url().'diakok');
        }
        $this->model_valasztott->promote($id,0,0);
        redirect($_SERVER['HTTP_REFERER']);
    }
    function promote( $id = false)
    {
        if (!$id) {
            redirect(base_url().'diakok');
        }
        if (!$this->model_diakok->konzulense($id,$this->logged_in['uid'])) {
            redirect(base_url().'diakok');
        }
        $this->load->library('form_validation');
        $data = $this->model_valasztott->getDiakTema( $id );
        if ($data['valasztott_status'] == 'Teljesen elkészült') {
            redirect(base_url().'diakok/show/'.$id);
        }

        switch ( $_SERVER ['REQUEST_METHOD'] )
        {
            case 'GET':
                $this->model_diakok->raw_data = TRUE;
                $this->model_valasztott->raw_data = TRUE;

                $data += $this->model_diakok->get( $id );
                $fields = $this->model_diakok->fields( TRUE );
                $fields += $this->model_valasztott->fields();

                
                $this->template->assign( 'action_mode', 'promote' );
                $this->template->assign( 'diakok_data', $data );
                $this->template->assign( 'diakok_fields', $fields );
                $this->template->assign( 'table_name', 'Diakok' );
                $this->template->assign( 'template', 'form_promote' );
                $this->template->assign( 'record_id', $id );
                $this->template->display( 'frame_admin.tpl' );
            break;
    
            case 'POST':
                $fields = $this->model_valasztott->fields();
                $fields += $this->model_diakok->fields();
                
                /* we set the rules */
                /* don't forget to edit these */
                $this->form_validation->set_rules( 'program_allapot', lang('program_allapot'), 'required|min[0]|max[100]|integer' );
                $this->form_validation->set_rules( 'dokumentacio_allapot', lang('dokumentacio_allapot'), 'required|min[0]|max[100]|integer' );
                
                $progi = $this->input->post( 'program_allapot' );
                $doksi = $this->input->post( 'dokumentacio_allapot' );

                if ( $this->form_validation->run() == FALSE )
                {
                    $errors = validation_errors();

                    $data += $this->model_diakok->get( $id );
                    
                    $data['program_allapot'] = $progi;
                    $data['dokumentacio_allapot'] = $doksi;

                    $this->template->assign( 'action_mode', 'edit' );
                    $this->template->assign( 'errors', $errors );
                    $this->template->assign( 'diakok_data', $data );
                    $this->template->assign( 'diakok_fields', $fields );
                    $this->template->assign( 'table_name', 'Diakok' );
                    $this->template->assign( 'template', 'form_promote' );
                    $this->template->assign( 'record_id', $id );
                    $this->template->display( 'frame_admin.tpl' );

                }
                elseif ( $this->form_validation->run() == TRUE )
                {
                    $this->model_valasztott->promote($id,$progi,$doksi);
                    redirect( 'diakok/show/' . $id );   
                }
            break;
        }
    }
    
    function elutasit( $id = false)
    {
        if (!$id) {
            redirect(base_url().'diakok');
        }
        if (!$this->model_diakok->konzulense($id,$this->logged_in['uid'])) {
            redirect(base_url().'diakok');
        }
        $this->model_valasztott->elutasit($id);
        redirect($_SERVER['HTTP_REFERER']);
    }
    function osztaly( $page = 0 )
    {
        if (!$this->osztalyfonok) {
            redirect( base_url().'diakok' );
        }
        $this->model_diakok->pagination( TRUE );
        $data_info = $this->model_diakok->osztaly( $page );
        $fields = $this->model_diakok->fields( TRUE );
        $fields += $this->model_felhasznalok->fields( TRUE );

        $this->template->assign( 'pager', $this->model_diakok->pager );
        $this->template->assign( 'diakok_fields', $fields );
        $this->template->assign( 'diakok_data', $data_info );
        $this->template->assign( 'table_name', 'Diakok' );
        $this->template->assign( 'template', 'list_diakok_osztaly' );
        
        $this->template->display( 'frame_admin.tpl' );
        
    }

    /**
     *  SHOWS A RECORD VIEW
     */
    function show( $id = false )
    {
        if (!$id) {
            redirect(base_url().'diakok');
        }
        $data = $this->model_diakok->get( $id );
        if (empty($data)) {
            redirect(base_url().'diakok');
        }
        $fields = $this->model_diakok->fields( TRUE );
        $data += $this->model_felhasznalok->get( $id );
        $fields += $this->model_felhasznalok->fields( TRUE );

        $data += $this->model_valasztott->getDiakTema( $id );
        $fields += $this->model_valasztott->fields( TRUE );

        
        $this->template->assign( 'id', $id );
		$this->template->assign( 'diakok_fields', $fields );
		$this->template->assign( 'diakok_data', $data );
        $this->template->assign( 'konzulense', $this->model_diakok->konzulense($id,$this->logged_in['uid']) );
        $this->template->assign( 'osztalyfonoke', $this->model_diakok->isOsztalyFonoke($id,$this->logged_in['uid']) );
        $this->template->assign( 'table_name', 'Diakok' );
		$this->template->assign( 'template', 'show_diakok' );
		$this->template->display( 'frame_admin.tpl' );
    }



    /**
     *  SHOWS A FROM, AND HANDLES SAVING IT
     */         
    function create( $id = false )
    {
        if ($this->logged_in['permission'] < 8) {
            redirect( base_url().'diakok' );
        }
        $this->load->library('form_validation');
        
		switch ( $_SERVER ['REQUEST_METHOD'] )
        {
            case 'GET':
                $fields = $this->model_diakok->fields();
                $fields += $this->model_felhasznalok->fields();
                $osztalyok_set = $this->model_diakok->related_osztalyok();

                $this->template->assign( 'related_osztalyok', $osztalyok_set );

                
                $this->template->assign( 'action_mode', 'create' );
        		$this->template->assign( 'diakok_fields', $fields );
                $this->template->assign( 'metadata', $this->model_diakok->metadata() );
        		$this->template->assign( 'table_name', 'Diakok' );
        		$this->template->assign( 'template', 'form_diakok' );
        		$this->template->display( 'frame_admin.tpl' );
            break;

            /**
             *  Insert data TO diakok table
             */
            case 'POST':
                $fields = $this->model_felhasznalok->fields();
                $fields += $this->model_diakok->fields();

                $this->form_validation->set_rules( 'felhasznalo_id', lang('felhasznalo_id'), 'required|max_length[11]|integer' );
                $this->form_validation->set_rules( 'felhasznalo_jelszo', lang('felhasznalo_jelszo'), 'required|max_length[128]' );
                $this->form_validation->set_rules( 'felhasznalo_email', lang('felhasznalo_email'), 'max_length[256]' );

                $this->form_validation->set_rules( 'diak_vnev', lang('diak_vnev'), 'required|max_length[45]' );
                $this->form_validation->set_rules( 'diak_knev', lang('diak_knev'), 'required|max_length[45]' );
                $this->form_validation->set_rules( 'diak_knev2', lang('diak_knev2'), 'max_length[45]' );
                $this->form_validation->set_rules( 'diak_oszt_id', lang('diak_oszt_id'), 'required|max_length[11]|integer' );

                $data_post['felhasznalo_id'] = $this->input->post( 'felhasznalo_id' );
                $data_post['felhasznalo_nev'] = $this->input->post( 'felhasznalo_id' );
                $data_post['felhasznalo_jelszo'] = md5($this->input->post( 'felhasznalo_jelszo' ));
                $data_post['felhasznalo_email'] = $this->input->post( 'felhasznalo_email' );

                $data_post['diak_felh_id'] = $this->input->post( 'felhasznalo_id' );
                $data_post['diak_vnev'] = $this->input->post( 'diak_vnev' );
                $data_post['diak_knev'] = $this->input->post( 'diak_knev' );
                $data_post['diak_knev2'] = $this->input->post( 'diak_knev2' );
                $data_post['diak_oszt_id'] = $this->input->post( 'diak_oszt_id' );


                if ( $this->form_validation->run() == FALSE )
                {
                    $errors = validation_errors();

                    $osztalyok_set = $this->model_diakok->related_osztalyok();

                    $this->template->assign( 'related_osztalyok', $osztalyok_set );

                    $this->template->assign( 'errors', $errors );
                    $this->template->assign( 'action_mode', 'create' );
                    $this->template->assign( 'diakok_data', $data_post );
                    $this->template->assign( 'diakok_fields', $fields );

                    $metadata = $this->model_felhasznalok->metadata();
                    $metadata += $this->model_diakok->metadata();

                    $this->template->assign( 'metadata', $metadata );
                    $this->template->assign( 'table_name', 'Diakok' );
                    $this->template->assign( 'template', 'form_diakok' );
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
                        $data_post_diak = array(
                            'diak_felh_id' => $data_post['felhasznalo_id'] , 
                            'diak_vnev' => $data_post['diak_vnev'] , 
                            'diak_knev' => $data_post['diak_knev'] , 
                            'diak_knev2' => $data_post['diak_knev2'] , 
                            'diak_oszt_id' => $data_post['diak_oszt_id']
                        );

                        $insert_id = $this->model_felhasznalok->insert( $data_post_felhasznalo );
                        $insert_id = $this->model_diakok->insert( $data_post_diak );
                        redirect( 'diakok' );
                    }
                    else
                    {
                        $osztalyok_set = $this->model_diakok->related_osztalyok();

                        $this->template->assign( 'related_osztalyok', $osztalyok_set );

                        $this->template->assign( 'errors', $errors );
                        $this->template->assign( 'action_mode', 'create' );
                        $this->template->assign( 'diakok_data', $data_post );
                        $this->template->assign( 'diakok_fields', $fields );

                        $metadata = $this->model_felhasznalok->metadata();
                        $metadata += $this->model_diakok->metadata();

                        $this->template->assign( 'metadata', $metadata );
                        $this->template->assign( 'table_name', 'Diakok' );
                        $this->template->assign( 'template', 'form_diakok' );
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
        if (!$id) {
            redirect( base_url().'diakok' );
        }
        if ($this->logged_in['permission'] < 8 && !$this->model_diakok->isOsztalyFonoke($id,$this->logged_in['uid'])) {
            redirect( base_url().'diakok' );
        }
        $this->load->library('form_validation');

        switch ( $_SERVER ['REQUEST_METHOD'] )
        {
            case 'GET':
                $this->model_diakok->raw_data = TRUE;

        		$data = $this->model_diakok->get( $id );
                $fields = $this->model_diakok->fields();

                $data += $this->model_felhasznalok->get( $id );
                $fields += $this->model_felhasznalok->fields( TRUE );
                
                $osztalyok_set = $this->model_diakok->related_osztalyok();

                
                $this->template->assign( 'related_osztalyok', $osztalyok_set );

                
          		$this->template->assign( 'action_mode', 'edit' );
        		$this->template->assign( 'diakok_data', $data );
        		$this->template->assign( 'diakok_fields', $fields );
                $this->template->assign( 'metadata', $this->model_diakok->metadata() );
        		$this->template->assign( 'table_name', 'Diakok' );
        		$this->template->assign( 'template', 'form_diakok' );
        		$this->template->assign( 'record_id', $id );
        		$this->template->display( 'frame_admin.tpl' );
            break;
    
            case 'POST':
                $fields = $this->model_felhasznalok->fields();
                $fields += $this->model_diakok->fields();
                
                /* we set the rules */
                /* don't forget to edit these */
                $this->form_validation->set_rules( 'felhasznalo_id', lang('felhasznalo_id'), 'required|max_length[11]|integer' );
                $this->form_validation->set_rules( 'felhasznalo_jelszo', lang('felhasznalo_jelszo'), 'max_length[128]' );
                $this->form_validation->set_rules( 'felhasznalo_email', lang('felhasznalo_email'), 'max_length[256]' );

                $this->form_validation->set_rules( 'diak_vnev', lang('diak_vnev'), 'required|max_length[45]' );
                $this->form_validation->set_rules( 'diak_knev', lang('diak_knev'), 'required|max_length[45]' );
                $this->form_validation->set_rules( 'diak_knev2', lang('diak_knev2'), 'max_length[45]' );
                $this->form_validation->set_rules( 'diak_oszt_id', lang('diak_oszt_id'), 'required|max_length[11]|integer' );

                $data_post['felhasznalo_id'] = $this->input->post( 'felhasznalo_id' );
                $data_post['felhasznalo_nev'] = $this->input->post( 'felhasznalo_id' );
                if (!empty($this->input->post( 'felhasznalo_jelszo' ))) {
                    $data_post['felhasznalo_jelszo'] = md5($this->input->post( 'felhasznalo_jelszo' ));
                }
                $data_post['felhasznalo_email'] = $this->input->post( 'felhasznalo_email' );

                $data_post['diak_vnev'] = $this->input->post( 'diak_vnev' );
                $data_post['diak_knev'] = $this->input->post( 'diak_knev' );
                $data_post['diak_knev2'] = $this->input->post( 'diak_knev2' );
                $data_post['diak_oszt_id'] = $this->input->post( 'diak_oszt_id' );


                if ( $this->form_validation->run() == FALSE )
                {
                    $errors = validation_errors();
                   
                    $osztalyok_set = $this->model_diakok->related_osztalyok();

                    $this->template->assign( 'related_osztalyok', $osztalyok_set );

                    
                    $this->template->assign( 'action_mode', 'edit' );
                    $this->template->assign( 'errors', $errors );
                    $this->template->assign( 'diakok_data', $data_post );
                    $this->template->assign( 'diakok_fields', $fields );

                    $metadata = $this->model_felhasznalok->metadata();
                    $metadata += $this->model_diakok->metadata();

                    $this->template->assign( 'metadata', $metadata );
                    $this->template->assign( 'table_name', 'Diakok' );
                    $this->template->assign( 'template', 'form_diakok' );
                    $this->template->assign( 'record_id', $id );
                    $this->template->display( 'frame_admin.tpl' );

                }
                elseif ( $this->form_validation->run() == TRUE )
                {
                    if ($data_post['felhasznalo_id'] != $id) {
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
                        $data_post_diak = array(
                            'diak_felh_id' => $data_post['felhasznalo_id'] , 
                            'diak_vnev' => $data_post['diak_vnev'] , 
                            'diak_knev' => $data_post['diak_knev'] , 
                            'diak_knev2' => $data_post['diak_knev2'] , 
                            'diak_oszt_id' => $data_post['diak_oszt_id']
                        );

                        $this->model_felhasznalok->update( $id, $data_post_felhasznalo );
                        $this->model_diakok->update( $data_post['felhasznalo_id'], $data_post_diak );
                        redirect( 'diakok/show/' . $data_post['felhasznalo_id'] );   
                    }
                    else
                    {
                        $osztalyok_set = $this->model_diakok->related_osztalyok();

                        $this->template->assign( 'related_osztalyok', $osztalyok_set );

                        
                        $this->template->assign( 'action_mode', 'edit' );
                        $this->template->assign( 'errors', $errors );
                        $this->template->assign( 'diakok_data', $data_post );
                        $this->template->assign( 'diakok_fields', $fields );

                        $metadata = $this->model_felhasznalok->metadata();
                        $metadata += $this->model_diakok->metadata();

                        $this->template->assign( 'metadata', $metadata );
                        $this->template->assign( 'table_name', 'Diakok' );
                        $this->template->assign( 'template', 'form_diakok' );
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
        if ($this->logged_in['permission'] < 8 && !$this->model_diakok->isOsztalyFonoke($id,$this->logged_in['uid'])) {
            redirect( base_url().'diakok' );
        }
        switch ( $_SERVER ['REQUEST_METHOD'] )
        {
            case 'GET':
                $this->model_diakok->delete( $id );
                $this->model_felhasznalok->delete( $id );
                
            break;

            case 'POST':
                $this->model_diakok->delete( $this->input->post('delete_ids') );
                $this->model_felhasznalok->delete( $this->input->post('delete_ids') );
                
            break;
            
        }
        redirect( $_SERVER['HTTP_REFERER'] );
    }
}

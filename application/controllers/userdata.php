<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class userdata extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();

		$this->load->library( 'template' ); 
		$this->load->model( 'model_felhasznalok' ); 
        $this->load->model( 'model_tanarok' );
		
		$this->load->helper( 'form' );
		$this->load->helper( 'language' ); 
		$this->load->helper( 'url' );
        $this->load->model( 'model_auth' );

        $this->logged_in = $this->model_auth->check( TRUE );
        $this->template->assign( 'logged_in', $this->logged_in );
        
		$this->lang->load( 'db_fields', 'english' ); // This is the language file
	}

	function index()
	{
		redirect( base_url().'userdata/editpass');
	}

	function editpass()
	{
		$this->load->library('form_validation');
		$id = $this->logged_in['uid'];

        switch ( $_SERVER ['REQUEST_METHOD'] )
        {
            case 'GET':
                $fields = $this->model_felhasznalok->fields();
                
          		$this->template->assign( 'action_mode', 'editpass' );
        		$this->template->assign( 'felhasznalok_fields', $fields );
                $this->template->assign( 'metadata', $this->model_felhasznalok->metadata() );
        		$this->template->assign( 'table_name', 'userdata' );
        		$this->template->assign( 'template', 'form_changepass' );
        		$this->template->display( 'frame_admin.tpl' );
            break;
    
            case 'POST':
    
                $fields = $this->model_felhasznalok->fields();
                $this->form_validation->set_rules( 'felhasznalo_jelszo', lang('felhasznalo_jelszo'), 'required|max_length[128]' );
				$this->form_validation->set_rules( 'felhasznalo_jelszo_megerosit', lang('felhasznalo_jelszo_megerosit'), 'required|max_length[128]' );
				$this->form_validation->set_rules( 'felhasznalo_jelszo_regi', lang('felhasznalo_jelszo_regi'), 'required|max_length[128]' );

				$data_post['felhasznalo_jelszo'] = md5($this->input->post( 'felhasznalo_jelszo' ));
				
                if ( $this->form_validation->run() == FALSE )
                {
                    $errors = validation_errors();
                    
                    $this->template->assign( 'action_mode', 'editpass' );
              		$this->template->assign( 'errors', $errors );
            		$this->template->assign( 'felhasznalok_fields', $fields );
                    $this->template->assign( 'metadata', $this->model_felhasznalok->metadata() );
            		$this->template->assign( 'table_name', 'userdata' );
            		$this->template->assign( 'template', 'form_changepass' );
            		$this->template->display( 'frame_admin.tpl' );
                }
                elseif ( $this->form_validation->run() == TRUE )
                {
                	if ($this->input->post( 'felhasznalo_jelszo' ) == $this->input->post( 'felhasznalo_jelszo_megerosit' )) 
                	{
                		if ($this->model_felhasznalok->checkPass($id, md5($this->input->post( 'felhasznalo_jelszo_regi' )))) 
                		{
                			$this->model_felhasznalok->update( $id, $data_post );
                			$success = "A jelszó sikeresen módosult";
                			$this->template->assign( 'success', $success );
                		}
                		else
                		{
                			$errors = "A régi jelszó hibás";
                			$this->template->assign( 'errors', $errors );
                		}
                	}
                	else
                	{
                		$errors = "A megadott jelszavaknak egyeznie kell";
            			$this->template->assign( 'errors', $errors );
                	}
                	$this->template->assign( 'action_mode', 'editpass' );
              		$this->template->assign( 'felhasznalok_fields', $fields );
                    $this->template->assign( 'metadata', $this->model_felhasznalok->metadata() );
            		$this->template->assign( 'table_name', 'userdata' );
            		$this->template->assign( 'template', 'form_changepass' );
            		$this->template->display( 'frame_admin.tpl' );
				}
            break;

        }
	}

	function editemail()
	{
		$this->load->library('form_validation');
		$id = $this->logged_in['uid'];

        switch ( $_SERVER ['REQUEST_METHOD'] )
        {
            case 'GET':
                $this->model_felhasznalok->raw_data = TRUE;
        		$data = $this->model_felhasznalok->get( $id );
                $fields = $this->model_felhasznalok->fields();
                
          		$this->template->assign( 'action_mode', 'editemail' );
        		$this->template->assign( 'felhasznalok_fields', $fields );
        		$this->template->assign( 'felhasznalok_data', $data );
                $this->template->assign( 'metadata', $this->model_felhasznalok->metadata() );
        		$this->template->assign( 'table_name', 'userdata' );
        		$this->template->assign( 'template', 'form_changemail' );
        		$this->template->display( 'frame_admin.tpl' );
            break;
    
            case 'POST':
    
                $fields = $this->model_felhasznalok->fields();
                $this->form_validation->set_rules( 'felhasznalo_jelszo', lang('felhasznalo_jelszo'), 'required|max_length[128]' );
                $this->form_validation->set_rules( 'felhasznalo_email', lang('felhasznalo_email'), 'max_length[256]' );

				$data_post['felhasznalo_email'] = $this->input->post( 'felhasznalo_email' );
				
                if ( $this->form_validation->run() == FALSE )
                {
                    $errors = validation_errors();
                    $this->template->assign( 'action_mode', 'editemail' );
              		$this->template->assign( 'errors', $errors );
            		$this->template->assign( 'felhasznalok_data', $data_post );
            		$this->template->assign( 'felhasznalok_fields', $fields );
                    $this->template->assign( 'metadata', $this->model_felhasznalok->metadata() );
            		$this->template->assign( 'table_name', 'userdata' );
            		$this->template->assign( 'template', 'form_changemail' );
            		$this->template->display( 'frame_admin.tpl' );

                }
                elseif ( $this->form_validation->run() == TRUE )
                {
                	if ( $this->model_felhasznalok->checkPass( $id, md5( $this->input->post( 'felhasznalo_jelszo' ) ) ) )
            		{
            			$this->model_felhasznalok->update( $id, $data_post );
            			$success = "Az e-mail cím sikeresen módosult";
            			$this->template->assign( 'success', $success );
            		}
            		else
            		{
            			$errors = "A régi jelszó hibás";
            			$this->template->assign( 'errors', $errors );
            		}
                	$this->template->assign( 'action_mode', 'editemail' );
              		$this->template->assign( 'felhasznalok_fields', $fields );
              		$this->template->assign( 'felhasznalok_data', $data_post );
                    $this->template->assign( 'metadata', $this->model_felhasznalok->metadata() );
            		$this->template->assign( 'table_name', 'userdata' );
            		$this->template->assign( 'template', 'form_changemail' );
            		$this->template->display( 'frame_admin.tpl' );
				}
            break;

        }
	}

	function editferohely()
	{
		if ($this->logged_in['permission'] < 1) {
			redirect('userdata');
		}
		$this->load->library('form_validation');
		$id = $this->logged_in['uid'];

        switch ( $_SERVER ['REQUEST_METHOD'] )
        {
            case 'GET':
                $this->model_tanarok->raw_data = TRUE;
        		$data = $this->model_tanarok->get( $id );
                $fields = $this->model_tanarok->fields();

          		$this->template->assign( 'action_mode', 'editferohely' );
        		$this->template->assign( 'tanarok_fields', $fields );
        		$this->template->assign( 'tanarok_data', $data );
                $this->template->assign( 'metadata', $this->model_tanarok->metadata() );
        		$this->template->assign( 'table_name', 'userdata' );
        		$this->template->assign( 'template', 'form_changeferohely' );
        		$this->template->display( 'frame_admin.tpl' );
            break;
    
            case 'POST':
                $fields = $this->model_tanarok->fields();

                $this->form_validation->set_rules( 'tanar_ferohely', lang('tanar_ferohely'), 'min[0]|max[100]' );
                $data_post['tanar_ferohely'] = $this->input->post( 'tanar_ferohely' );
                

                if ( $this->form_validation->run() == FALSE )
                {
                    $errors = validation_errors();
                
                    $this->template->assign( 'action_mode', 'editferohely' );
                    $this->template->assign( 'errors', $errors );
                    $this->template->assign( 'tanarok_data', $data_post );
                    $this->template->assign( 'tanarok_fields', $fields );
                    $this->template->assign( 'metadata', $this->model_tanarok->metadata() );
                    $this->template->assign( 'table_name', 'userdata' );
                    $this->template->assign( 'template', 'form_changferohely' );
                    $this->template->display( 'frame_admin.tpl' );
                }
                elseif ( $this->form_validation->run() == TRUE )
                {
                    $this->model_tanarok->update( $id, $data_post );

        			$success = "A férőhely sikeresen módosult";

        			$this->template->assign( 'success', $success );
            		$this->template->assign( 'action_mode', 'editferohely' );
              		$this->template->assign( 'tanarok_fields', $fields );
              		$this->template->assign( 'tanarok_data', $data_post );
                    $this->template->assign( 'metadata', $this->model_tanarok->metadata() );
            		$this->template->assign( 'table_name', 'userdata' );
            		$this->template->assign( 'template', 'form_changeferohely' );
            		$this->template->display( 'frame_admin.tpl' );
                }
            break;
        }
	}

}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_auth extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

        $this->load->library( 'session' );
    }

    /**
     *  Function check
     *  @return false / user data
     */
    function check( $redirect = TRUE )
    {
        $udata = $this->session->userdata( 'logged_in' );

        if( $udata['valid'] == 'yes' )
        {
            return $udata;
        }
        else
        {
            if( $redirect )
            {
                redirect( base_url() );
                die();
            }
            return FALSE;
        }
    }

    function validate($user,$pass){
        $this->db->start_cache();

        $this->db->select( 'felhasznalo_nev,felhasznalo_jelszo');
        $this->db->from( 'felhasznalok' );
        $this->db->where( 'felhasznalo_nev',$user);
        $this->db->where( 'felhasznalo_jelszo',md5($pass));

        $query = $this->db->get();

        $this->db->flush_cache();
        
        if ( $query->num_rows() > 0 )
        {
            return true;
            $row = $query->row_array();
        }
        else
        {
            return false;
        }

    }
    function getuserdata($user){
        $this->db->start_cache();

        $this->db->select( 'felhasznalo_id');
        $this->db->from( 'felhasznalok' );
        $this->db->where( 'felhasznalo_nev',$user);

        $query = $this->db->get();

        $this->db->flush_cache();

        if ( $query->num_rows() > 0 )
        {
            $row = $query->row_array();
            $uid = $row['felhasznalo_id'];

            $this->db->start_cache();
            $this->db->select( 'CONCAT(diak_vnev," ",diak_knev," ",IFNULL(diak_knev2,"")) AS name');
            $this->db->from( 'diakok' );
            $this->db->where( 'diak_felh_id',$uid);
            
            $query = $this->db->get();

            $this->db->flush_cache();
            if ( $query->num_rows() > 0 )
            {
                $row = $query->row_array();

                return array( 
                    'uid'          => $uid,
                    'permission'   => -1,
                    'name'         => $row['name'] 
                );
            }
            else
            {
                $this->db->start_cache();
                $this->db->select( 'CONCAT(tanar_vnev," ",tanar_knev," ",IFNULL(tanar_knev2,"")) AS name, tanar_jogosultsag_id AS perm');
                $this->db->from( 'tanarok' );
                $this->db->where( 'tanar_felh_id', $uid);
                
                $query = $this->db->get();
                if ( $query->num_rows() > 0 )
                {
                    $row = $query->row_array();

                    return array( 
                        'uid'          => $uid,
                        'permission'   => $row['perm'],
                        'name'         => $row['name'] 
                    );
                }
                else
                {
                    return array();
                }
            }
        }
    }

    /** 
     *  Function login
     *  Makes the user logged in, by updating the session     
     */
    function login( $compData )
    {
        $this->session->set_userdata( 'logged_in', $compData );
    }


    /** 
     *  Function logout
     *  Makes the user logged out, by updating the session     
     */
   function logout()
    {
        $data = array(
					'valid'        => 'no',
					'uid'          => FALSE,
                    'permission'   => FALSE,
                    'name'  => '');
    
    	$this->session->set_userdata( 'logged_in', $data );
    }    
}

/* End of file model_auth.php */
/* Location: ./application/models/model_auth.php */
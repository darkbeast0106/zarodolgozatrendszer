<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_felhasznalok extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
 
		$this->load->database();

		// Paginaiton defaults
		$this->pagination_enabled = FALSE;
		$this->pagination_per_page = 10;
		$this->pagination_num_links = 5;
		$this->pager = '';

        /**
		 *    bool $this->raw_data		
		 *    Used to decide what data should the SQL queries retrieve if tables are joined
		 *     - TRUE:  just the field names of the felhasznalok table
		 *     - FALSE: related fields are replaced with the forign tables values
		 *    Triggered to TRUE in the controller/edit method		 
		 */
        $this->raw_data = FALSE;  
    }

	function get ( $id, $get_one = false )
	{
        
	    $select_statement = ( $this->raw_data ) ? 'felhasznalo_id,felhasznalo_nev,felhasznalo_jelszo,felhasznalo_email' : 'felhasznalo_id,felhasznalo_nev,felhasznalo_jelszo,felhasznalo_email';
		$this->db->select( $select_statement );
		$this->db->from('felhasznalok');
        

		// Pick one record
		// Field order sample may be empty because no record is requested, eg. create/GET event
		if( $get_one )
        {
            $this->db->limit(1,0);
        }
		else // Select the desired record
        {
            $this->db->where( 'felhasznalo_id', $id );
        }

		$query = $this->db->get();

		if ( $query->num_rows() > 0 )
		{
			$row = $query->row_array();
			return array( 
	'felhasznalo_id' => $row['felhasznalo_id'],
	'felhasznalo_nev' => $row['felhasznalo_nev'],
	'felhasznalo_jelszo' => $row['felhasznalo_jelszo'],
	'felhasznalo_email' => $row['felhasznalo_email'],
 );
		}
        else
        {
            return array();
        }
	}

    function checkPass($id, $pass)
    {
        $this->db->select( '*' );
        $this->db->from('felhasznalok');
        $this->db->where('felhasznalo_id',$id);
        $this->db->where('felhasznalo_jelszo',$pass);
        $query = $this->db->get();

        if ( $query->num_rows() > 0 )
        {
            return TRUE;
        } 
        else
        {
            return FALSE;
        }
    }

	function insert ( $data )
	{
		$this->db->insert( 'felhasznalok', $data );
		return $this->db->insert_id();
	}
	


	function update ( $id, $data )
	{
		$this->db->where( 'felhasznalo_id', $id );
		$this->db->update( 'felhasznalok', $data );
	}


	
	function delete ( $id )
	{
        if( is_array( $id ) )
        {
            $this->db->where_in( 'felhasznalo_id', $id );            
        }
        else
        {
            $this->db->where( 'felhasznalo_id', $id );
        }
        $this->db->delete( 'felhasznalok' );
	}



	function lister ( $page = FALSE )
	{
        
	    $this->db->start_cache();
		$this->db->select( 'felhasznalo_id,felhasznalo_nev,felhasznalo_jelszo,felhasznalo_email');
		$this->db->from( 'felhasznalok' );
		//$this->db->order_by( '', 'ASC' );
        

        /**
         *   PAGINATION
         */
        if( $this->pagination_enabled == TRUE )
        {
            $config = array();
            $config['total_rows']  = $this->db->count_all_results();
            $config['base_url']    = 'felhasznalok/index/';
            $config['uri_segment'] = 3;
            $config['cur_tag_open'] = '<span class="current">';
            $config['cur_tag_close'] = '</span>';
            $config['per_page']    = $this->pagination_per_page;
            $config['num_links']   = $this->pagination_num_links;

            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $this->pager = $this->pagination->create_links();
    
            $this->db->limit( $config['per_page'], $page );
        }

        // Get the results
		$query = $this->db->get();
		
		$temp_result = array();

		foreach ( $query->result_array() as $row )
		{
			$temp_result[] = array( 
	'felhasznalo_id' => $row['felhasznalo_id'],
	'felhasznalo_nev' => $row['felhasznalo_nev'],
	'felhasznalo_jelszo' => $row['felhasznalo_jelszo'],
	'felhasznalo_email' => $row['felhasznalo_email'],
 );
		}
        $this->db->flush_cache(); 
		return $temp_result;
	}



	function search ( $keyword, $page = FALSE )
	{
	    $meta = $this->metadata();
	    $this->db->start_cache();
		$this->db->select( 'felhasznalo_id,felhasznalo_nev,felhasznalo_jelszo,felhasznalo_email');
		$this->db->from( 'felhasznalok' );
        

		// Delete this line after setting up the search conditions 
        die('Please see models/model_felhasznalok.php for setting up the search method.');
		
        /**
         *  Rename field_name_to_search to the field you wish to search 
         *  or create advanced search conditions here
		 */
        $this->db->where( 'field_name_to_search LIKE "%'.$keyword.'%"' );

        /**
         *   PAGINATION
         */
        if( $this->pagination_enabled == TRUE )
        {
            $config = array();
            $config['total_rows']  = $this->db->count_all_results();
            $config['base_url']    = '/felhasznalok/search/'.$keyword.'/';
            $config['uri_segment'] = 4;
            $config['per_page']    = $this->pagination_per_page;
            $config['num_links']   = $this->pagination_num_links;
    
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $this->pager = $this->pagination->create_links();
    
            $this->db->limit( $config['per_page'], $page );
        }

		$query = $this->db->get();

		$temp_result = array();

		foreach ( $query->result_array() as $row )
		{
			$temp_result[] = array( 
	'felhasznalo_id' => $row['felhasznalo_id'],
	'felhasznalo_nev' => $row['felhasznalo_nev'],
	'felhasznalo_jelszo' => $row['felhasznalo_jelszo'],
	'felhasznalo_email' => $row['felhasznalo_email'],
 );
		}
        $this->db->flush_cache(); 
		return $temp_result;
	}





    /**
     *  Some utility methods
     */
    function fields( $withID = FALSE )
    {
        $fs = array(
	'felhasznalo_id' => lang('felhasznalo_id'),
	'felhasznalo_nev' => lang('felhasznalo_nev'),
    'felhasznalo_jelszo' => lang('felhasznalo_jelszo'),
    'felhasznalo_jelszo_megerosit' => lang('felhasznalo_jelszo_megerosit'),
	'felhasznalo_jelszo_regi' => lang('felhasznalo_jelszo_regi'),
	'felhasznalo_email' => lang('felhasznalo_email')
);

        if( $withID == FALSE )
        {
            unset( $fs[0] );
        }
        return $fs;
    }  
    
    function checkIfUserExists($username)
    {
        $this->db->select( '*');
        $this->db->from( 'felhasznalok' );
        $this->db->where('felhasznalo_nev', $username);
        $query = $this->db->get();

        if ( $query->num_rows() > 0 )
        {
            return TRUE;
        } 
        else
        {
            return FALSE;
        }
    }

    function checkIfIDExists($id)
    {
        $this->db->select( '*');
        $this->db->from( 'felhasznalok' );
        $this->db->where('felhasznalo_id', $id);
        $query = $this->db->get();

        if ( $query->num_rows() > 0 )
        {
            return TRUE;
        } 
        else
        {
            return FALSE;
        }
    }

    function pagination( $bool )
    {
        $this->pagination_enabled = ( $bool === TRUE ) ? TRUE : FALSE;
    }



    /**
     *  Parses the table data and look for enum values, to match them with language variables
     */             
    function metadata()
    {
        $this->load->library('explain_table');

        $metadata = $this->explain_table->parse( 'felhasznalok' );

        foreach( $metadata as $k => $md )
        {
            if( !empty( $md['enum_values'] ) )
            {
                $metadata[ $k ]['enum_names'] = array_map( 'lang', $md['enum_values'] );                
            } 
        }
        return $metadata; 
    }
}

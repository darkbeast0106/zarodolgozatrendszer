<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_tanarok extends CI_Model
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
		 *     - TRUE:  just the field names of the tanarok table
		 *     - FALSE: related fields are replaced with the forign tables values
		 *    Triggered to TRUE in the controller/edit method		 
		 */
        $this->raw_data = FALSE;  
    }

	function get ( $id, $get_one = false )
	{
        $select_statement = ( $this->raw_data ) ? 'tanar_felh_id,tanar_vnev,tanar_knev,tanar_knev2,tanar_ferohely,tanar_jogosultsag_id,felhasznalo_nev,felhasznalo_jelszo,felhasznalo_email' : 'felhasznalok.felhasznalo_id AS tanar_felh_id,tanar_vnev,tanar_knev,tanar_knev2,tanar_ferohely,jogosultsag.jogosultsag_nev AS tanar_jogosultsag_id,felhasznalok.felhasznalo_nev AS felhasznalo_nev,felhasznalok.felhasznalo_jelszo AS felhasznalo_jelszo,felhasznalok.felhasznalo_email AS felhasznalo_email';
		$this->db->select( $select_statement );
		$this->db->from('tanarok');
        $this->db->join( 'felhasznalok', 'tanar_felh_id = felhasznalo_id', 'left' );
        $this->db->join( 'jogosultsag', 'tanar_jogosultsag_id = jogosultsag_id', 'left' );


		// Pick one record
		// Field order sample may be empty because no record is requested, eg. create/GET event
		if( $get_one )
        {
            $this->db->limit(1,0);
        }
		else // Select the desired record
        {
            $this->db->where( 'tanar_felh_id', $id );
        }

		$query = $this->db->get();

		if ( $query->num_rows() > 0 )
		{
			$row = $query->row_array();
            return array( 
	'tanar_felh_id' => $row['tanar_felh_id'],
	'tanar_vnev' => $row['tanar_vnev'],
	'tanar_knev' => $row['tanar_knev'],
	'tanar_knev2' => $row['tanar_knev2'],
    'tanar_ferohely' => $row['tanar_ferohely'],
    'tanar_jogosultsag_id' => $row['tanar_jogosultsag_id'],
	'felhasznalo_email' => $row['felhasznalo_email'],
 );
		}
        else
        {
            return array();
        }
	}



	function insert ( $data )
	{
        $this->db->insert( 'tanarok', $data );
		return $this->db->insert_id();
	}
	


	function update ( $id, $data )
    {
        $this->db->where( 'tanar_felh_id', $id );
		$this->db->update( 'tanarok', $data );
	}


	
	function delete ( $id )
	{
        if( is_array( $id ) )
        {
            $this->db->where_in( 'tanar_felh_id', $id );            
        }
        else
        {
            $this->db->where( 'tanar_felh_id', $id );
        }
        $this->db->delete( 'tanarok' );

	}



	function lister ( $page = FALSE )
	{
        
	    $this->db->start_cache();
		$this->db->select( 'felhasznalok.felhasznalo_id AS tanar_felh_id,tanar_vnev,tanar_knev,tanar_knev2,tanar_ferohely,jogosultsag.jogosultsag_nev AS tanar_jogosultsag_id,felhasznalok.felhasznalo_nev AS felhasznalo_nev,felhasznalok.felhasznalo_jelszo AS felhasznalo_jelszo,felhasznalok.felhasznalo_email AS felhasznalo_email');
		$this->db->from( 'tanarok' );
        $this->db->order_by( 'tanar_vnev', 'ASC' );
		$this->db->order_by( 'tanar_knev', 'ASC' );
        $this->db->join( 'felhasznalok', 'tanar_felh_id = felhasznalo_id', 'left' );
        $this->db->join( 'jogosultsag', 'tanar_jogosultsag_id = jogosultsag_id', 'left' );


        /**
         *   PAGINATION
         */
        if( $this->pagination_enabled == TRUE )
        {
            $config = array();
            $config['total_rows']  = $this->db->count_all_results();
            $config['base_url']    = 'tanarok/index/';
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
	'tanar_felh_id' => $row['tanar_felh_id'],
	'tanar_vnev' => $row['tanar_vnev'],
	'tanar_knev' => $row['tanar_knev'],
	'tanar_knev2' => $row['tanar_knev2'],
    'tanar_ferohely' => $row['tanar_ferohely'],
	'tanar_jogosultsag_id' => $row['tanar_jogosultsag_id'],
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
		$this->db->select( 'felhasznalok.felhasznalo_id AS tanar_felh_id,tanar_vnev,tanar_knev,tanar_knev2,tanar_ferohely,jogosultsag.jogosultsag_nev AS tanar_jogosultsag_id,felhasznalok.felhasznalo_nev AS felhasznalo_nev,felhasznalok.felhasznalo_jelszo AS felhasznalo_jelszo,felhasznalok.felhasznalo_email AS felhasznalo_email');
		$this->db->from( 'tanarok' );
        $this->db->join( 'felhasznalok', 'tanar_felh_id = felhasznalo_id', 'left' );
        $this->db->join( 'jogosultsag', 'tanar_jogosultsag_id = jogosultsag_id', 'left' );


		// Delete this line after setting up the search conditions 
        die('Please see models/model_tanarok.php for setting up the search method.');
		
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
            $config['base_url']    = '/tanarok/search/'.$keyword.'/';
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
	'tanar_felh_id' => $row['tanar_felh_id'],
	'tanar_vnev' => $row['tanar_vnev'],
	'tanar_knev' => $row['tanar_knev'],
	'tanar_knev2' => $row['tanar_knev2'],
    'tanar_ferohely' => $row['tanar_ferohely'],
    'felhasznalo_email' => $row['felhasznalo_email'],
	'tanar_jogosultsag_id' => $row['tanar_jogosultsag_id'],
 );
		}
        $this->db->flush_cache(); 
		return $temp_result;
	}

	function related_jogosultsag()
    {
        $this->db->select( 'jogosultsag_id AS jogosultsag_id, jogosultsag_nev AS jogosultsag_name' );
        $rel_data = $this->db->get( 'jogosultsag' );
        return $rel_data->result_array();
    }







    /**
     *  Some utility methods
     */
    function fields( $withID = FALSE )
    {
        $fs = array(
	'tanar_felh_id' => lang('tanar_felh_id'),
    'tanar_vnev' => lang('tanar_vnev'),
	'nev' => lang('nev'),
	'tanar_knev' => lang('tanar_knev'),
	'tanar_knev2' => lang('tanar_knev2'),
    'tanar_ferohely' => lang('tanar_ferohely'),
    'tanar_jogosultsag_id' => lang('tanar_jogosultsag_id'),
    'felhasznalo_email' => lang('felhasznalo_email'),
);

        if( $withID == FALSE )
        {
            unset( $fs[0] );
        }
        return $fs;
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

        $metadata = $this->explain_table->parse( 'tanarok' );

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

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_jogosultsag extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
 
		$this->load->database();

		// Paginaiton defaults
		$this->pagination_enabled = FALSE;
		$this->pagination_per_page = 20;
		$this->pagination_num_links = 5;
		$this->pager = '';

        /**
		 *    bool $this->raw_data		
		 *    Used to decide what data should the SQL queries retrieve if tables are joined
		 *     - TRUE:  just the field names of the jogosultsag table
		 *     - FALSE: related fields are replaced with the forign tables values
		 *    Triggered to TRUE in the controller/edit method		 
		 */
        $this->raw_data = FALSE;  
    }

	function get ( $id, $get_one = false )
	{
        
	    $select_statement = ( $this->raw_data ) ? 'jogosultsag_id,jogosultsag_nev,konzulens,osztalyfonok,vezetoseg,koordinator' : 'jogosultsag_id,jogosultsag_nev,konzulens,osztalyfonok,vezetoseg,koordinator';
		$this->db->select( $select_statement );
		$this->db->from('jogosultsag');
        

		// Pick one record
		// Field order sample may be empty because no record is requested, eg. create/GET event
		if( $get_one )
        {
            $this->db->limit(1,0);
        }
		else // Select the desired record
        {
            $this->db->where( 'jogosultsag_id', $id );
        }

		$query = $this->db->get();

		if ( $query->num_rows() > 0 )
		{
			$row = $query->row_array();
			return array( 
	'jogosultsag_id' => $row['jogosultsag_id'],
	'jogosultsag_nev' => $row['jogosultsag_nev'],
	'konzulens' => $row['konzulens'],
	'osztalyfonok' => $row['osztalyfonok'],
	'vezetoseg' => $row['vezetoseg'],
	'koordinator' => $row['koordinator'],
 );
		}
        else
        {
            return array();
        }
	}

	function isOsztF( $id )
	{
		$select_statement = ( $this->raw_data ) ? 'jogosultsag_id,jogosultsag_nev,konzulens,osztalyfonok,vezetoseg,koordinator' : 'jogosultsag_id,jogosultsag_nev,konzulens,osztalyfonok,vezetoseg,koordinator';
		$this->db->select( $select_statement );
		$this->db->from('jogosultsag');
		$this->db->where( 'jogosultsag_id', $id );
		$query = $this->db->get();
		if ( $query->num_rows() > 0 )
		{
			$row = $query->row_array();
			if ($row['osztalyfonok'] == 1) {
				return TRUE;
			}
		}else{
			return FALSE;
		}
	}

	function insert ( $data )
	{
		$this->db->insert( 'jogosultsag', $data );
		return $this->db->insert_id();
	}
	


	function update ( $id, $data )
	{
		$this->db->where( 'jogosultsag_id', $id );
		$this->db->update( 'jogosultsag', $data );
	}


	
	function delete ( $id )
	{
        if( is_array( $id ) )
        {
            $this->db->where_in( 'jogosultsag_id', $id );            
        }
        else
        {
            $this->db->where( 'jogosultsag_id', $id );
        }
        $this->db->delete( 'jogosultsag' );
	}



	function lister ( $page = FALSE )
	{
        
	    $this->db->start_cache();
		$this->db->select( 'jogosultsag_id,jogosultsag_nev,konzulens,osztalyfonok,vezetoseg,koordinator');
		$this->db->from( 'jogosultsag' );
		//$this->db->order_by( '', 'ASC' );
        

        /**
         *   PAGINATION
         */
        if( $this->pagination_enabled == TRUE )
        {
            $config = array();
            $config['total_rows']  = $this->db->count_all_results();
            $config['base_url']    = 'jogosultsag/index/';
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
	'jogosultsag_id' => $row['jogosultsag_id'],
	'jogosultsag_nev' => $row['jogosultsag_nev'],
	'konzulens' => $row['konzulens'],
	'osztalyfonok' => $row['osztalyfonok'],
	'vezetoseg' => $row['vezetoseg'],
	'koordinator' => $row['koordinator'],
 );
		}
        $this->db->flush_cache(); 
		return $temp_result;
	}



	function search ( $keyword, $page = FALSE )
	{
	    $meta = $this->metadata();
	    $this->db->start_cache();
		$this->db->select( 'jogosultsag_id,jogosultsag_nev,konzulens,osztalyfonok,vezetoseg,koordinator');
		$this->db->from( 'jogosultsag' );
        

		// Delete this line after setting up the search conditions 
        die('Please see models/model_jogosultsag.php for setting up the search method.');
		
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
            $config['base_url']    = '/jogosultsag/search/'.$keyword.'/';
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
	'jogosultsag_id' => $row['jogosultsag_id'],
	'jogosultsag_nev' => $row['jogosultsag_nev'],
	'konzulens' => $row['konzulens'],
	'osztalyfonok' => $row['osztalyfonok'],
	'vezetoseg' => $row['vezetoseg'],
	'koordinator' => $row['koordinator'],
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
	'jogosultsag_id' => lang('jogosultsag_id'),
	'jogosultsag_nev' => lang('jogosultsag_nev'),
	'konzulens' => lang('konzulens'),
	'osztalyfonok' => lang('osztalyfonok'),
	'vezetoseg' => lang('vezetoseg'),
	'koordinator' => lang('koordinator')
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

        $metadata = $this->explain_table->parse( 'jogosultsag' );

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

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_osztalyok extends CI_Model 
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
		 *     - TRUE:  just the field names of the osztalyok table
		 *     - FALSE: related fields are replaced with the forign tables values
		 *    Triggered to TRUE in the controller/edit method		 
		 */
        $this->raw_data = FALSE;  
    }

	function get ( $id, $get_one = false )
	{
        
	    $select_statement = ( $this->raw_data ) ? 'osztaly_id,osztaly_nev,osztalyfonok_id,vegzes_eve' : 'osztaly_id,osztaly_nev,CONCAT(tanarok.tanar_vnev," ",tanarok.tanar_knev," ",IFNULL(tanarok.tanar_knev2,"")) AS osztalyfonok_id,vegzes_eve';
		$this->db->select( $select_statement );
		$this->db->from('osztalyok');
        $this->db->join( 'tanarok', 'osztalyfonok_id = tanar_felh_id', 'left' );


		// Pick one record
		// Field order sample may be empty because no record is requested, eg. create/GET event
		if( $get_one )
        {
            $this->db->limit(1,0);
        }
		else // Select the desired record
        {
            $this->db->where( 'osztaly_id', $id );
        }

		$query = $this->db->get();

		if ( $query->num_rows() > 0 )
		{
			$row = $query->row_array();
			return array( 
	'osztaly_id' => $row['osztaly_id'],
	'osztaly_nev' => $row['osztaly_nev'],
	'osztalyfonok_id' => $row['osztalyfonok_id'],
	'vegzes_eve' => $row['vegzes_eve'],
 );
		}
        else
        {
            return array();
        }
	}



	function insert ( $data )
	{
		$this->db->insert( 'osztalyok', $data );
		return $this->db->insert_id();
	}
	


	function update ( $id, $data )
	{
		$this->db->where( 'osztaly_id', $id );
		$this->db->update( 'osztalyok', $data );
	}


	
	function delete ( $id )
	{
        if( is_array( $id ) )
        {
            $this->db->where_in( 'osztaly_id', $id );            
        }
        else
        {
            $this->db->where( 'osztaly_id', $id );
        }
        $this->db->delete( 'osztalyok' );
        /*
		$this->db->where( 'osztalyok_id', $id );
        $this->db->delete('diakok_osztalyok');


		$this->db->where( 'osztalyok_id', $id );
        $this->db->delete('diakok_osztalyok');


		$this->db->where( 'osztalyok_id', $id );
        $this->db->delete('diakok_osztalyok');
*/

	}



	function lister ( $page = FALSE )
	{
        
	    $this->db->start_cache();
		$this->db->select( 'osztaly_id,osztaly_nev,CONCAT(tanarok.tanar_vnev," ",tanarok.tanar_knev," ",IFNULL(tanarok.tanar_knev2,"")) AS osztalyfonok_id,vegzes_eve');
		$this->db->from( 'osztalyok' );
		//$this->db->order_by( '', 'ASC' );
        $this->db->join( 'tanarok', 'osztalyfonok_id = tanar_felh_id', 'left' );


        /**
         *   PAGINATION
         */
        if( $this->pagination_enabled == TRUE )
        {
            $config = array();
            $config['total_rows']  = $this->db->count_all_results();
            $config['base_url']    = 'osztalyok/index/';
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
	'osztaly_id' => $row['osztaly_id'],
	'osztaly_nev' => $row['osztaly_nev'],
	'osztalyfonok_id' => $row['osztalyfonok_id'],
	'vegzes_eve' => $row['vegzes_eve'],
 );
		}
        $this->db->flush_cache(); 
		return $temp_result;
	}



	function search ( $keyword, $page = FALSE )
	{
	    $meta = $this->metadata();
	    $this->db->start_cache();
		$this->db->select( 'osztaly_id,osztaly_nev,CONCAT(tanarok.tanar_vnev," ",tanarok.tanar_knev," ",IFNULL(tanarok.tanar_knev2,"")) AS osztalyfonok_id,vegzes_eve');
		$this->db->from( 'osztalyok' );
        $this->db->join( 'tanarok', 'osztalyfonok_id = tanar_felh_id', 'left' );


		// Delete this line after setting up the search conditions 
        die('Please see models/model_osztalyok.php for setting up the search method.');
		
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
            $config['base_url']    = '/osztalyok/search/'.$keyword.'/';
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
	'osztaly_id' => $row['osztaly_id'],
	'osztaly_nev' => $row['osztaly_nev'],
	'osztalyfonok_id' => $row['osztalyfonok_id'],
	'vegzes_eve' => $row['vegzes_eve'],
 );
		}
        $this->db->flush_cache(); 
		return $temp_result;
	}

	function related_tanarok()
    {
        $this->db->select( 'tanar_felh_id AS tanarok_id, CONCAT(tanar_vnev," ",tanar_knev," ",IFNULL(tanar_knev2,"")) AS tanarok_name' );
        $rel_data = $this->db->get( 'tanarok' );
        return $rel_data->result_array();
    }







    /**
     *  Some utility methods
     */
    function fields( $withID = FALSE )
    {
        $fs = array(
	'osztaly_id' => lang('osztaly_id'),
	'osztaly_nev' => lang('osztaly_nev'),
	'osztalyfonok_id' => lang('osztalyfonok_id'),
	'vegzes_eve' => lang('vegzes_eve')
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

        $metadata = $this->explain_table->parse( 'osztalyok' );

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

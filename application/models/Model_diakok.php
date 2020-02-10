<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_diakok extends CI_Model 
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
		 *     - TRUE:  just the field names of the diakok table
		 *     - FALSE: related fields are replaced with the forign tables values
		 *    Triggered to TRUE in the controller/edit method		 
		 */
        $this->raw_data = FALSE;  
    }

	function get ( $id, $get_one = false )
	{
        $meta = $this->metadata();
	    $select_statement = ( $this->raw_data ) ? 'diak_felh_id,diak_vnev,diak_knev,diak_knev2,diak_oszt_id,valasztott_status,felhasznalo_email' : 'felhasznalok.felhasznalo_id AS diak_felh_id,diak_vnev,diak_knev,diak_knev2,osztalyok.osztaly_nev AS diak_oszt_id,valasztott_status,felhasznalo_email';
		$this->db->select( $select_statement );
		$this->db->from('diakok');
        $this->db->join( 'felhasznalok', 'diak_felh_id = felhasznalo_id', 'left' );
        $this->db->join( 'osztalyok', 'diak_oszt_id = osztaly_id', 'left' );
        $this->db->join( 'valasztott', 'diak_felh_id = valaszto_diak_id', 'left' );

		// Pick one record
		// Field order sample may be empty because no record is requested, eg. create/GET event
		if( $get_one )
        {
            $this->db->limit(1,0);
        }
		else // Select the desired record
        {
            $this->db->where( 'diak_felh_id', $id );
        }

		$query = $this->db->get();

		if ( $query->num_rows() > 0 )
		{
			$row = $query->row_array();
			return array( 
	'diak_felh_id' => $row['diak_felh_id'],
	'diak_vnev' => $row['diak_vnev'],
	'diak_knev' => $row['diak_knev'],
	'diak_knev2' => $row['diak_knev2'],
    'diak_oszt_id' => $row['diak_oszt_id'],
	'felhasznalo_email' => $row['felhasznalo_email'],
    'valasztott_status' => ( array_search( $row['valasztott_status'], $meta['valasztott_status']['enum_values'] ) !== FALSE ) ? $meta['valasztott_status']['enum_names'][ array_search( $row['valasztott_status'], $meta['valasztott_status']['enum_values'] ) ] : 'Nincs',
 
            );
		}
        else
        {
            return array();
        }
	}



	function insert ( $data )
	{
		$this->db->insert( 'diakok', $data );
		return $this->db->insert_id();
	}
	


	function update ( $id, $data )
	{
		$this->db->where( 'diak_felh_id', $id );
		$this->db->update( 'diakok', $data );
	}


	
	function delete ( $id )
	{
        if( is_array( $id ) )
        {
            $this->db->where_in( 'diak_felh_id', $id );            
        }
        else
        {
            $this->db->where( 'diak_felh_id', $id );
        }
        $this->db->delete( 'diakok' );

	}

    function isOsztalyFonoke($diakid,$tanarid)
    {
        $meta = $this->metadata();
        $this->db->select( '*' );
        $this->db->from( 'diakok' );
        $this->db->join( 'osztalyok', 'diak_oszt_id = osztaly_id', 'left' );
        $this->db->where( 'diak_felh_id', $diakid );
        $this->db->where( 'osztalyfonok_id', $tanarid );
       

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

	function lister ( $page = FALSE )
	{
        $meta = $this->metadata();
	    $this->db->start_cache();
		$this->db->select( 'felhasznalok.felhasznalo_id AS diak_felh_id,diak_vnev,diak_knev,diak_knev2,osztalyok.osztaly_nev AS diak_oszt_id,felhasznalok.felhasznalo_nev AS felhasznalo_nev,felhasznalok.felhasznalo_jelszo AS felhasznalo_jelszo,felhasznalok.felhasznalo_email AS felhasznalo_email,valasztott_status,valasztott_cim');
		$this->db->from( 'diakok' );
		$this->db->order_by( 'diak_vnev', 'ASC' );
        $this->db->order_by( 'diak_knev', 'ASC' );
        $this->db->join( 'felhasznalok', 'diak_felh_id = felhasznalo_id', 'left' );
        $this->db->join( 'osztalyok', 'diak_oszt_id = osztaly_id', 'left' );
        $this->db->join( 'valasztott', 'diak_felh_id = valaszto_diak_id', 'left' );
        

        /**
         *   PAGINATION
         */
        if( $this->pagination_enabled == TRUE )
        {
            $config = array();
            $config['total_rows']  = $this->db->count_all_results();
            $config['base_url']    = 'diakok/index/';
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
	'diak_felh_id' => $row['diak_felh_id'],
	'diak_vnev' => $row['diak_vnev'],
	'diak_knev' => $row['diak_knev'],
	'diak_knev2' => $row['diak_knev2'],
	'diak_oszt_id' => $row['diak_oszt_id'],
    'felhasznalo_nev' => $row['felhasznalo_nev'],
    'felhasznalo_jelszo' => $row['felhasznalo_jelszo'],
    'felhasznalo_email' => $row['felhasznalo_email'],
    'valasztott_cim' => $row['valasztott_cim'],
    'valasztott_status' => ( array_search( $row['valasztott_status'], $meta['valasztott_status']['enum_values'] ) !== FALSE ) ? $meta['valasztott_status']['enum_names'][ array_search( $row['valasztott_status'], $meta['valasztott_status']['enum_values'] ) ] : 'Nincs',
 );
		}
        $this->db->flush_cache(); 
		return $temp_result;
	}
    function konzulense($diakid,$tanarid)
    {
        $meta = $this->metadata();
        $this->db->select( '*' );
        $this->db->from( 'diakok' );
        $this->db->join( 'valasztott', 'diak_felh_id = valaszto_diak_id', 'left' );
        $this->db->where( 'diak_felh_id', $diakid );
        $this->db->where( 'konzulens_id', $tanarid );
       

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

    function konzulens ( $page = FALSE )
    {
        $meta = $this->metadata();
        $this->db->start_cache();
        $this->db->select( 'felhasznalok.felhasznalo_id AS diak_felh_id,diak_vnev,diak_knev,diak_knev2,osztalyok.osztaly_nev AS diak_oszt_id,felhasznalok.felhasznalo_nev AS felhasznalo_nev,felhasznalok.felhasznalo_jelszo AS felhasznalo_jelszo,felhasznalok.felhasznalo_email AS felhasznalo_email,valasztott_status,valasztott_link,valasztott_cim');
        $this->db->from( 'diakok' );
        $this->db->where( 'valasztott.konzulens_id',$this->logged_in['uid'] );
        $this->db->where( 'valasztott.valasztott_status !=', 'elutasitva' );
        $this->db->order_by( 'diak_vnev', 'ASC' );
        $this->db->order_by( 'diak_knev', 'ASC' );
        $this->db->join( 'felhasznalok', 'diak_felh_id = felhasznalo_id', 'left' );
        $this->db->join( 'osztalyok', 'diak_oszt_id = osztaly_id', 'left' );
        $this->db->join( 'valasztott', 'diak_felh_id = valaszto_diak_id', 'left' );
        

        /**
         *   PAGINATION
         */
        if( $this->pagination_enabled == TRUE )
        {
            $config = array();
            $config['total_rows']  = $this->db->count_all_results();
            $config['base_url']    = 'diakok/index/';
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
    'diak_felh_id' => $row['diak_felh_id'],
    'diak_vnev' => $row['diak_vnev'],
    'diak_knev' => $row['diak_knev'],
    'diak_knev2' => $row['diak_knev2'],
    'diak_oszt_id' => $row['diak_oszt_id'],
    'felhasznalo_nev' => $row['felhasznalo_nev'],
    'felhasznalo_jelszo' => $row['felhasznalo_jelszo'],
    'felhasznalo_email' => $row['felhasznalo_email'],
    'valasztott_link' => $row['valasztott_link'],
    'valasztott_cim' => $row['valasztott_cim'],
    'valasztott_status' => ( array_search( $row['valasztott_status'], $meta['valasztott_status']['enum_values'] ) !== FALSE ) ? $meta['valasztott_status']['enum_names'][ array_search( $row['valasztott_status'], $meta['valasztott_status']['enum_values'] ) ] : 'Nincs',
 );
        }
        $this->db->flush_cache(); 
        return $temp_result;
    }

    function osztaly ( $page = FALSE )
    {
        $meta = $this->metadata();
        $this->db->start_cache();
        $this->db->select( 'felhasznalok.felhasznalo_id AS diak_felh_id,diak_vnev,diak_knev,diak_knev2,osztalyok.osztaly_nev AS diak_oszt_id,felhasznalok.felhasznalo_nev AS felhasznalo_nev,felhasznalok.felhasznalo_jelszo AS felhasznalo_jelszo,felhasznalok.felhasznalo_email AS felhasznalo_email,valasztott_status,valasztott_cim');
        $this->db->from( 'diakok' );
        $this->db->where( 'osztalyok.osztalyfonok_id',$this->logged_in['uid'] );
        $this->db->order_by( 'diak_vnev', 'ASC' );
        $this->db->order_by( 'diak_knev', 'ASC' );
        $this->db->join( 'felhasznalok', 'diak_felh_id = felhasznalo_id', 'left' );
        $this->db->join( 'osztalyok', 'diak_oszt_id = osztaly_id', 'left' );
        $this->db->join( 'valasztott', 'diak_felh_id = valaszto_diak_id', 'left' );
        

        /**
         *   PAGINATION
         */
        if( $this->pagination_enabled == TRUE )
        {
            $config = array();
            $config['total_rows']  = $this->db->count_all_results();
            $config['base_url']    = 'diakok/index/';
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
    'diak_felh_id' => $row['diak_felh_id'],
    'diak_vnev' => $row['diak_vnev'],
    'diak_knev' => $row['diak_knev'],
    'diak_knev2' => $row['diak_knev2'],
    'diak_oszt_id' => $row['diak_oszt_id'],
    'felhasznalo_nev' => $row['felhasznalo_nev'],
    'felhasznalo_jelszo' => $row['felhasznalo_jelszo'],
    'felhasznalo_email' => $row['felhasznalo_email'],
    'valasztott_cim' => $row['valasztott_cim'],
    'valasztott_status' => ( array_search( $row['valasztott_status'], $meta['valasztott_status']['enum_values'] ) !== FALSE ) ? $meta['valasztott_status']['enum_names'][ array_search( $row['valasztott_status'], $meta['valasztott_status']['enum_values'] ) ] : 'Nincs',
 );
        }
        $this->db->flush_cache(); 
        return $temp_result;
    }    

	function search ( $keyword, $page = FALSE )
	{
	    $meta = $this->metadata();
	    $this->db->start_cache();
		$this->db->select( 'felhasznalok.felhasznalo_id AS diak_felh_id,diak_vnev,diak_knev,diak_knev2,osztalyok.osztaly_nev AS diak_oszt_id');
		$this->db->from( 'diakok' );
        $this->db->join( 'felhasznalok', 'diak_felh_id = felhasznalo_id', 'left' );
        $this->db->join( 'osztalyok', 'diak_oszt_id = osztaly_id', 'left' );


		// Delete this line after setting up the search conditions 
        die('Please see models/model_diakok.php for setting up the search method.');
		
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
            $config['base_url']    = '/diakok/search/'.$keyword.'/';
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
	'diak_felh_id' => $row['diak_felh_id'],
	'diak_vnev' => $row['diak_vnev'],
	'diak_knev' => $row['diak_knev'],
	'diak_knev2' => $row['diak_knev2'],
	'diak_oszt_id' => $row['diak_oszt_id'],
 );
		}
        $this->db->flush_cache(); 
		return $temp_result;
	}

	function related_osztalyok()
    {
        $this->db->select( 'osztaly_id AS osztalyok_id, osztaly_nev AS osztalyok_name' );
        $rel_data = $this->db->get( 'osztalyok' );
        return $rel_data->result_array();
    }

    /**
     *  Some utility methods
     */
    function fields( $withID = FALSE )
    {
        $fs = array(
	'diak_felh_id' => lang('diak_felh_id'),
    'nev' => lang('nev'),
	'diak_vnev' => lang('diak_vnev'),
	'diak_knev' => lang('diak_knev'),
	'diak_knev2' => lang('diak_knev2'),
	'diak_oszt_id' => lang('diak_oszt_id'),
    'valasztott_status' => lang('valasztott_status'),
    'valasztott_link' => lang('valasztott_link'),
    'valasztott_cim' => lang('valasztott_cim'),
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

        $metadata = $this->explain_table->parse( 'diakok' );
        $metadata = $this->explain_table->parse( 'valasztott' );

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

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_valasztott extends CI_Model 
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
		 *     - TRUE:  just the field names of the valasztott table
		 *     - FALSE: related fields are replaced with the forign tables values
		 *    Triggered to TRUE in the controller/edit method		 
		 */
        $this->raw_data = FALSE;  
    }
    function elfogad($id)
    {
        $this->db->set('valasztott_status','felt_elfogadva');
        $this->db->where( 'valaszto_diak_id', $id );
        $this->db->update( 'valasztott' );
    }
    function promote($id,$progi,$doksi)
    {
        $this->db->set('valasztott_status','valasztott_status+1',false);
        $this->db->set('program_allapot',$progi);
        $this->db->set('dokumentacio_allapot',$doksi);
        $this->db->where( 'valaszto_diak_id', $id );
        $this->db->update( 'valasztott' );
    }
    function elutasit($id)
    {
        $this->db->set('valasztott_status','elutasitva');
        $this->db->where( 'valaszto_diak_id', $id );
        $this->db->update( 'valasztott' );
    }
	function get ( $id, $get_one = false )
	{
        $meta = $this->metadata();
	    $select_statement = ( $this->raw_data ) ? 'valasztott_id,valaszto_diak_id,konzulens_id,valasztott_tema_id,valasztott_cim,valasztott_link,valasztott_status,program_allapot,dokumentacio_allapot' : 'valasztott_id,CONCAT(diakok.diak_vnev," ",diakok.diak_knev," ",IFNULL(diakok.diak_knev2,"")) AS valaszto_diak_id,CONCAT(tanarok.tanar_vnev," ",tanarok.tanar_knev," ",IFNULL(tanarok.tanar_knev2,"")) AS konzulens_id,temak.tema_cim AS valasztott_tema_id,IF(valasztott_tema_id IS NULL,"igen","nem") AS sajat_tema,valasztott_cim,valasztott_link,valasztott_status,program_allapot,dokumentacio_allapot,felhasznalo_email as konzulens_email';
		$this->db->select( $select_statement );
		$this->db->from('valasztott');
        $this->db->join( 'diakok', 'valaszto_diak_id = diak_felh_id', 'left' );
        $this->db->join( 'tanarok', 'konzulens_id = tanar_felh_id', 'left' );
        $this->db->join('felhasznalok', 'konzulens_id = felhasznalo_id', 'left');
        $this->db->join( 'temak', 'valasztott_tema_id = tema_id', 'left' );


		// Pick one record
		// Field order sample may be empty because no record is requested, eg. create/GET event
		if( $get_one )
        {
            $this->db->limit(1,0);
        }
		else // Select the desired record
        {
            $this->db->where( 'valasztott_id', $id );
        }

		$query = $this->db->get();

		if ( $query->num_rows() > 0 )
		{
			$row = $query->row_array();
                if ($this->raw_data) {
                    return array( 
                    'valasztott_id' => $row['valasztott_id'],
                    'valaszto_diak_id' => $row['valaszto_diak_id'],
                    'konzulens_id' => $row['konzulens_id'],
                    'valasztott_tema_id' => $row['valasztott_tema_id'],
                    'valasztott_cim' => $row['valasztott_cim'],
                    'valasztott_link' => $row['valasztott_link'],
                    'dokumentacio_allapot' => $row['dokumentacio_allapot'],
                    'program_allapot' => $row['program_allapot'],
                    'valasztott_status' => ( array_search( $row['valasztott_status'], $meta['valasztott_status']['enum_values'] ) !== FALSE ) ? $meta['valasztott_status']['enum_names'][ array_search( $row['valasztott_status'], $meta['valasztott_status']['enum_values'] ) ] : 'Nincs',
                );
                }else{
        			return array( 
                	'valasztott_id' => $row['valasztott_id'],
                	'valaszto_diak_id' => $row['valaszto_diak_id'],
                    'konzulens_id' => $row['konzulens_id'],
                	'konzulens_email' => $row['konzulens_email'],
                    'valasztott_tema_id' => $row['valasztott_tema_id'],
                	'sajat_tema' => $row['sajat_tema'],
                	'valasztott_cim' => $row['valasztott_cim'],
                	'valasztott_link' => $row['valasztott_link'],
                    'dokumentacio_allapot' => $row['dokumentacio_allapot'],
                    'program_allapot' => $row['program_allapot'],
                    'valasztott_status' => ( array_search( $row['valasztott_status'], $meta['valasztott_status']['enum_values'] ) !== FALSE ) ? $meta['valasztott_status']['enum_names'][ array_search( $row['valasztott_status'], $meta['valasztott_status']['enum_values'] ) ] : 'Nincs',
                );
            }
		}
        else
        {
            return array();
        }
	}

    function getDiakTema ( $id, $get_one = false )
    {
        $meta = $this->metadata();
        $select_statement = ( $this->raw_data ) ? 'valasztott_id,valaszto_diak_id,konzulens_id,valasztott_tema_id,valasztott_cim,valasztott_link,valasztott_status,program_allapot,dokumentacio_allapot' : 'valasztott_id,CONCAT(diakok.diak_vnev," ",diakok.diak_knev," ",IFNULL(diakok.diak_knev2,"")) AS valaszto_diak_id,CONCAT(tanarok.tanar_vnev," ",tanarok.tanar_knev," ",IFNULL(tanarok.tanar_knev2,"")) AS konzulens_id,IF(valasztott_tema_id IS NULL,"igen","nem") AS sajat_tema,valasztott_cim,valasztott_link,valasztott_status,temak.tema_cim AS valasztott_tema_id,program_allapot,dokumentacio_allapot';
        $this->db->select( $select_statement );
        $this->db->from('valasztott');
        $this->db->join( 'diakok', 'valaszto_diak_id = diak_felh_id', 'left' );
        $this->db->join( 'tanarok', 'konzulens_id = tanar_felh_id', 'left' );
        $this->db->join( 'temak', 'valasztott_tema_id = tema_id', 'left' );


        // Pick one record
        // Field order sample may be empty because no record is requested, eg. create/GET event
        if( $get_one )
        {
            $this->db->limit(1,0);
        }
        else // Select the desired record
        {
            $this->db->where( 'valaszto_diak_id', $id );
        }

        $query = $this->db->get();

        if ( $query->num_rows() > 0 )
        {
            $row = $query->row_array();
            if ($this->raw_data) {
            return array( 
    'valasztott_id' => $row['valasztott_id'],
    'valaszto_diak_id' => $row['valaszto_diak_id'],
    'konzulens_id' => $row['konzulens_id'],
    'valasztott_tema_id' => $row['valasztott_tema_id'],
    'valasztott_cim' => $row['valasztott_cim'],
    'valasztott_link' => $row['valasztott_link'],
    'dokumentacio_allapot' => $row['dokumentacio_allapot'],
    'program_allapot' => $row['program_allapot'],
    'valasztott_status' => ( array_search( $row['valasztott_status'], $meta['valasztott_status']['enum_values'] ) !== FALSE ) ? $meta['valasztott_status']['enum_names'][ array_search( $row['valasztott_status'], $meta['valasztott_status']['enum_values'] ) ] : 'Nincs',
 );
            }else{
            return array( 
    'valasztott_id' => $row['valasztott_id'],
    'valaszto_diak_id' => $row['valaszto_diak_id'],
    'konzulens_id' => $row['konzulens_id'],
    'valasztott_tema_id' => $row['valasztott_tema_id'],
    'sajat_tema' => $row['sajat_tema'],
    'valasztott_cim' => $row['valasztott_cim'],
    'valasztott_link' => $row['valasztott_link'],
    'dokumentacio_allapot' => $row['dokumentacio_allapot'],
    'program_allapot' => $row['program_allapot'],
    'valasztott_status' => ( array_search( $row['valasztott_status'], $meta['valasztott_status']['enum_values'] ) !== FALSE ) ? $meta['valasztott_status']['enum_names'][ array_search( $row['valasztott_status'], $meta['valasztott_status']['enum_values'] ) ] : 'Nincs',
 );
            }
        }
        else
        {
            return array();
        }
    }


	function insert ( $data )
	{
		$this->db->insert( 'valasztott', $data );
		return $this->db->insert_id();
	}
	


	function update ( $id, $data )
	{
		$this->db->where( 'valasztott_id', $id );
		$this->db->update( 'valasztott', $data );
	}


	
	function delete ( $id )
	{
        if( is_array( $id ) )
        {
            $this->db->where_in( 'valasztott_id', $id );            
        }
        else
        {
            $this->db->where( 'valasztott_id', $id );
        }
        $this->db->delete( 'valasztott' );
        
	}

    function foglalthely($id)
    {
        $this->db->select('count(*) AS foglalthely');
        $this->db->from('valasztott');
        $this->db->where( 'konzulens_id', $id );
        $this->db->where( 'valasztott_status !=', 'elutasitva' );
        $this->db->where( 'valasztott_status !=', 'elfogadasra_var' );
        
        $query = $this->db->get();
        if ( $query->num_rows() > 0 )
        {
            $row = $query->row_array();
            $foglalthely = $row['foglalthely'];
        }else{
            $foglalthely = 0;
        }
        return $foglalthely;
    }

    function szabadhely($id)
    {
        $foglalthely = $this->foglalthely($id);
        
        $this->db->select('tanar_ferohely AS ferohely');
        $this->db->from('tanarok');
        $this->db->where( 'tanar_felh_id', $id );
        
        $query = $this->db->get();
        if ( $query->num_rows() > 0 )
        {
            $row = $query->row_array();
            $ferohely = $row['ferohely'];
        }else{
            $ferohely = 0;
        }

        return $ferohely - $foglalthely;

    }

	function lister ( $page = FALSE )
	{
        $meta = $this->metadata();
	    $this->db->start_cache();
		$this->db->select( 'valasztott_id,CONCAT(diakok.diak_vnev," ",diakok.diak_knev," ",IFNULL(diakok.diak_knev2,""))AS valaszto_diak_id,CONCAT(tanarok.tanar_vnev," ",tanarok.tanar_knev," ",IFNULL(tanarok.tanar_knev2,"")) AS konzulens_id,IF(valasztott_tema_id IS NULL,"igen","nem") AS sajat_tema,valasztott_cim,valasztott_link,valasztott_status,temak.tema_cim AS valasztott_tema_id,program_allapot,dokumentacio_allapot');
		$this->db->from( 'valasztott' );
		//$this->db->order_by( '', 'ASC' );
        $this->db->join( 'diakok', 'valaszto_diak_id = diak_felh_id', 'left' );
$this->db->join( 'tanarok', 'konzulens_id = tanar_felh_id', 'left' );
$this->db->join( 'temak', 'valasztott_tema_id = tema_id', 'left' );


        /**
         *   PAGINATION
         */
        if( $this->pagination_enabled == TRUE )
        {
            $config = array();
            $config['total_rows']  = $this->db->count_all_results();
            $config['base_url']    = 'valasztott/index/';
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
	'valasztott_id' => $row['valasztott_id'],
	'valaszto_diak_id' => $row['valaszto_diak_id'],
	'konzulens_id' => $row['konzulens_id'],
    'valasztott_tema_id' => $row['valasztott_tema_id'],
	'sajat_tema' => $row['sajat_tema'],
	'valasztott_cim' => $row['valasztott_cim'],
	'valasztott_link' => $row['valasztott_link'],
    'dokumentacio_allapot' => $row['dokumentacio_allapot'],
    'program_allapot' => $row['program_allapot'],
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
		$this->db->select( 'valasztott_id,CONCAT(diakok.diak_vnev," ",diakok.diak_knev," ",IFNULL(diakok.diak_knev2,"")) AS valaszto_diak_id,CONCAT(tanarok.tanar_vnev," ",tanarok.tanar_knev," ",IFNULL(tanarok.tanar_knev2,"")) AS konzulens_id,IF(valasztott_tema_id IS NULL,"igen","nem") AS sajat_tema,valasztott_cim,valasztott_link,valasztott_status,temak.tema_cim AS valasztott_tema_id,program_allapot,dokumentacio_allapot');
		$this->db->from( 'valasztott' );
        $this->db->join( 'diakok', 'valaszto_diak_id = diak_felh_id', 'left' );
        $this->db->join( 'tanarok', 'konzulens_id = tanar_felh_id', 'left' );
        $this->db->join( 'temak', 'valasztott_tema_id = tema_id', 'left' );


		// Delete this line after setting up the search conditions 
        die('Please see models/model_valasztott.php for setting up the search method.');
		
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
            $config['base_url']    = '/valasztott/search/'.$keyword.'/';
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
	'valasztott_id' => $row['valasztott_id'],
	'valaszto_diak_id' => $row['valaszto_diak_id'],
	'konzulens_id' => $row['konzulens_id'],
    'valasztott_tema_id' => $row['valasztott_tema_id'],
	'sajat_tema' => $row['sajat_tema'],
	'valasztott_cim' => $row['valasztott_cim'],
    'valasztott_link' => $row['valasztott_link'],
    'dokumentacio_allapot' => $row['dokumentacio_allapot'],
	'program_allapot' => $row['program_allapot'],
    'valasztott_status' => ( array_search( $row['valasztott_status'], $meta['valasztott_status']['enum_values'] ) !== FALSE ) ? $meta['valasztott_status']['enum_names'][ array_search( $row['valasztott_status'], $meta['valasztott_status']['enum_values'] ) ] : 'Nincs',
 );
		}
        $this->db->flush_cache(); 
		return $temp_result;
	}

	function related_diakok()
    {
        $this->db->select( 'diak_felh_id AS diakok_id, CONCAT(diak_vnev," ",diak_knev," ",IFNULL(diak_knev2,"")) AS diakok_name' );
        $rel_data = $this->db->get( 'diakok' );
        return $rel_data->result_array();
    }



	function related_tanarok()
    {
        $this->db->select( 'tanar_felh_id AS tanarok_id, CONCAT(tanar_vnev," ",tanar_knev," ",IFNULL(tanar_knev2,"")) AS tanarok_name' );
        $this->db->where( 'MOD(tanar_jogosultsag_id,2)' , 1);
        $this->db->order_by('tanarok_name');
        $rel_data = $this->db->get( 'tanarok' );
        return $rel_data->result_array();
    }



	function related_temak()
    {
        $this->db->select( 'tema_id AS temak_id, tema_cim AS temak_name' );
        $rel_data = $this->db->get( 'temak' );
        return $rel_data->result_array();
    }


    /**
     *  Some utility methods
     */
    function fields( $withID = FALSE )
    {
        $fs = array(
	'valasztott_id' => lang('valasztott_id'),
	'valaszto_diak_id' => lang('valaszto_diak_id'),
    'konzulens_id' => lang('konzulens_id'),
	'konzulens_email' => lang('felhasznalo_email'),
	'valasztott_tema_id' => lang('valasztott_tema_id'),
	'valasztott_cim' => lang('valasztott_cim'),
    'valasztott_link' => lang('valasztott_link'),
    'sajat_tema' => lang('sajat_tema'),
    'program_allapot' => lang('program_allapot'),
	'dokumentacio_allapot' => lang('dokumentacio_allapot'),
    'valasztott_status' => lang('valasztott_status')

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

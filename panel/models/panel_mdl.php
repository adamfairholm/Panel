<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Panel Model
 *
 * @author		Addict Add-ons Dev Team
 * @copyright	Copyright (c) 2011, Addict Add-ons
 * @link		http://addictaddons.com/panel
 * @license		http://addictaddons.com/panel/license
 */
class Panel_mdl extends CI_Model {

	function __construct()
	{
		parent::__construct();
    }

	// --------------------------------------------------------------------------
	
	/**
	 * Add a panel
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function add_panel( $panel_name )
	{
		$insert_data['panel_name']		= $panel_name;
		
		// Find the +1 of the order
		$this->db->limit(1);
		$this->db->select("MAX(sort_order) as last_number");
		$obj = $this->db->get('panels');
		
		if( $obj->num_rows() == 0 ):
		
			$sort = 1;
		
		else:
		
			$row = $obj->row();
			
			$sort = $row->last_number + 1;
		
		endif;
		
		$insert_data['sort_order']		= $sort;
		
		return $this->db->insert('panels', $insert_data);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Update a panel
	 *
	 * @access	public
	 * @param	int
	 * @param	string
	 * @return	bool
	 */
	function update_panel( $panel_id, $panel_name )
	{
		$update_data['panel_name']		= $panel_name;
		
		$this->db->where('id', $panel_id);
		
		return $this->db->update('panels', $update_data);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Get panels
	 *
	 * @access	public
	 * @param	mixed
	 * @param	int
	 * @return	obj
	 */
	function get_panels( $limit = FALSE, $offset = 0 )
	{
		if( $limit ):
		
			$this->db->limit( $limit, $offset );
		
		endif;
		
		$obj = $this->db->get('panels');
		
		return $obj->result();
	}

	// --------------------------------------------------------------------------

	/**
	 * Get a single panel
	 *
	 * @access	public
	 * @param	int
	 * @return	mixed
	 */
	function get_panel( $panel_id )
	{
		$this->db->limit(1);
		
		$this->db->where('id', $panel_id);
		
		$obj = $this->db->get('panels');
		
		if( $obj->num_rows() == 0 ):
		
			return FALSE;
		
		else:
		
			return $obj->row();
		
		endif;
	}

	// --------------------------------------------------------------------------

	/**
	 * Delete a panel and attending data
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_panel( $panel_id )
	{
		// -------------------------------------
		// Delete from panels table	
		// -------------------------------------	
	
		$this->db->where('id', $panel_id);
		
		$outcome = $this->db->delete('panels');

		// -------------------------------------
		// Delete settings	
		// -------------------------------------
		
		if( $outcome ):	

		$this->db->where('panel_id', $panel_id);
		
		$outcome = $this->db->delete('panel_settings');
		
		endif;
	
		return $outcome; 
	}

}

/* End of file panel_mdl.php */
/* Location: ./system/expressionengine/third_party/panel/models/panel_mdl.php */
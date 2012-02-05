<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Panel Model
 *
 * @author		Parse19
 * @copyright	Copyright (c) 2011-2012, Parse19
 * @link		http://parse19.com/panel
 * @license		http://parse19.com/panel/license
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
	function add_panel($panel_name)
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
	function get_panels($limit = FALSE, $offset = 0)
	{
		if ($limit)
		{
			$this->db->limit($limit, $offset);
		}
		
		return $this->db->get('panels')->result();
	}

	// --------------------------------------------------------------------------

	/**
	 * Get a single panel
	 *
	 * @access	public
	 * @param	int
	 * @return	mixed
	 */
	function get_panel($panel_id)
	{
		if ( ! $panel_id) return NULL;
	
		$obj = $this->db
						->limit(1)
						->where('id', $panel_id)
						->get('panels');
		
		return ($obj->num_rows() == 0) ? FALSE : $obj->row();
	}

	// --------------------------------------------------------------------------

	/**
	 * Delete a panel and attending data
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_panel($panel_id)
	{
		// -------------------------------------
		// Delete from panels table	
		// -------------------------------------	
	
		$outcome = $this->db->limit(1)->where('id', $panel_id)->delete('panels');

		// -------------------------------------
		// Delete settings	
		// -------------------------------------
		
		if ($outcome)	
		{
			$outcome = $this->db->limit(1)->where('panel_id', $panel_id)->delete('panel_settings');
		}
	
		return $outcome; 
	}

}
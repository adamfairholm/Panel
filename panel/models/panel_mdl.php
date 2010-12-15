<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Panel_mdl extends CI_Model {

	function Panel_mdl()
	{
		parent::CI_Model();
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

}

/* End of file panel_mdl.php */
/* Location: ./system/expressionengine/third_party/panel/models/panel_mdl.php */
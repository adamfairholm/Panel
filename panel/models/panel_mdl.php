<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Panel_mdl extends CI_Model {

	function Panel_mdl()
	{
		parent::CI_Model();
    }

	// --------------------------------------------------------------------------
	
	/**
	 * Add panel into the database
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

}

/* End of file panel_mdl.php */
/* Location: ./system/expressionengine/third_party/panel/models/panel_mdl.php */
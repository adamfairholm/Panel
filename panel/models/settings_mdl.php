<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_mdl extends CI_Model {

	function Settings_mdl()
	{
		parent::CI_Model();
    }

	// --------------------------------------------------------------------------
	
	/**
	 * Get the settings for a panel
	 *
	 * @access	public
	 * @param	int
	 * @return	obj
	 */
	function get_settings_for_panel( $panel_id )
	{
		$this->db->where('panel_id', $panel_id);
		
		$obj = $this->db->get('panel_settings');
		
		return $obj->result();
	}
}

/* End of file settings_mdl.php */
/* Location: ./expressionengine/third_party/panel/models/settings_mdl.php */
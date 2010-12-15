<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_mdl extends CI_Model {

	function Settings_mdl()
	{
		parent::CI_Model();
    }

	// --------------------------------------------------------------------------
	
	/**
	 * Get a setting
	 *
	 * @access	public
	 * @param	int
	 * @return	obj
	 */
	function get_setting( $setting_id )
	{
		$this->db->limit(1);
	
		$this->db->where('id', $setting_id);
		
		$obj = $this->db->get('panel_settings');
		
		return $obj->row();
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

	// --------------------------------------------------------------------------
	
	/**
	 * Get a master obj of settings
	 *
	 * Settings are classes in the settings folder with a standard format.
	 *
	 * @access	public
	 * @return	obj
	 */
	function get_setting_types()
	{
		$this->load->helper('directory');
	
		$types = new stdClass;

		$types_files = directory_map(APPPATH.'third_party/panel/settings/');

		foreach( $types_files as $type ):

			$items = explode(".", $type);

			//If this isn't a setting, forget it
			if( $items[0] != 'setting' )
				break;

			$class_name = 'Setting_'.$items[1];

			require_once(APPPATH.'third_party/panel/settings/'.$type);

			$types->$items[1] = new $class_name();

		endforeach;

		return $types;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * See if a name is unique in the db
	 *
	 * @access	public
	 * @param	string
	 * @param	string ('new' or 'edit')
	 * @return	bool
	 */	
	function is_name_unique( $name, $method )
	{
		$this->db->where('setting_name', $name);
		
		$obj = $this->db->get('panel_settings');
		
		$count = $obj->num_rows();
		
		if( $method == 'new' ):
		
			$threshold = 0;
		
		else:
		
			$threshold = 1;
		
		endif;

		if( $count > $threshold ):
		
			return FALSE;
		
		endif;

		return TRUE;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Add a setting to a panel
	 *
	 * @access	public
	 * @param	array
	 * @param	int
	 * @return	bool
	 */	
	function add_setting_to_panel( $data, $panel_id )
	{
		$insert_data = array(
			'panel_id'			=> $panel_id,
			'setting_type'		=> $data['setting_type'],
			'setting_label'		=> $data['setting_label'],
			'setting_name'		=> $data['setting_name'],
			'instructions'		=> $data['instructions'],
			'default_value'		=> $data['default_value'],
			'value'				=> $data['default_value']
		);
	
		return $this->db->insert( 'panel_settings', $insert_data );
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Updates a setting
	 *
	 * @access	public
	 * @param	array
	 * @param	int
	 * @return	bool
	 */	
	function update_setting( $data, $setting_id )
	{
		$update_data = array(
			'setting_type'		=> $data['setting_type'],
			'setting_label'		=> $data['setting_label'],
			'setting_name'		=> $data['setting_name'],
			'instructions'		=> $data['instructions'],
			'default_value'		=> $data['default_value'],
		);
		
		$this->db->where('id', $setting_id);
	
		return $this->db->update( 'panel_settings', $update_data );
	}

	// --------------------------------------------------------------------------

	/**
	 * Counts the number of settings for a given panel
	 *
	 * @access	public
	 * @param	int
	 * @return	int
	 */
	function count_panel_settings( $panel_id )
	{
		$this->db->where('panel_id', $panel_id);
	
		$obj = $this->db->get('panel_settings');
	
		return $obj->num_rows();
	}
}

/* End of file settings_mdl.php */
/* Location: ./expressionengine/third_party/panel/models/settings_mdl.php */
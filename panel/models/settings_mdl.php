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
		
		$setting = $obj->row();
		
		// Get extra params if they exist
		
		if( $setting->data != '' ):
		
			$setting->data = unserialize($setting->data);
		
		endif;
		
		return $setting;
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

		// Get the folders

		$folders = directory_map(APPPATH.'third_party/panel/settings/');

		// Run through them
		
		foreach( $folders as $folder => $node ):
		
			$setting_path = APPPATH.'third_party/panel/settings/'.$folder.'/';
		
			if( file_exists($setting_path.'setting.'.$folder.EXT) ):
			
				require_once($setting_path.'setting.'.$folder.EXT);

				$class_name = 'Setting_'.$folder;
	
				$types->$folder = new $class_name();
		
			endif;
			
			// Add language files

			if( file_exists($setting_path.'language/'.$this->config->item('deft_lang').'/lang.'.$folder.EXT) ):
			
				require_once($setting_path.'language/'.$this->config->item('deft_lang').'/lang.'.$folder.EXT);
			
				$types->$folder->lang = $lang[$folder];
			
			endif;
	
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
	 * @param	obj
	 * @return	bool
	 */	
	function add_setting( $data, $panel_id, $type )
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
		
		// See if there are custom params & add them into a serialized array
		
		if( isset( $type->setting_data ) && is_array( $type->setting_data ) ):
		
			$params = array();
		
			foreach( $type->setting_data as $setting ):
			
				if( isset($data[$setting]) ):
			
					$params[$setting] = $data[$setting];
				
				endif;
			
			endforeach;
		
			if( count($params) > 0 ):
			
				$insert_data['data'] = serialize($params);
			
			endif;
		
		endif;
	
		return $this->db->insert( 'panel_settings', $insert_data );
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Updates a setting
	 *
	 * @access	public
	 * @param	array
	 * @param	int
	 * @param	obj
	 * @return	bool
	 */	
	function update_setting( $data, $setting_id, $type )
	{
		$update_data = array(
			'setting_type'		=> $data['setting_type'],
			'setting_label'		=> $data['setting_label'],
			'setting_name'		=> $data['setting_name'],
			'instructions'		=> $data['instructions'],
			'default_value'		=> $data['default_value'],
		);

		// See if there are custom params & add them into a serialized array
		
		if( isset( $type->setting_data ) && is_array( $type->setting_data ) ):
		
			$params = array();
		
			foreach( $type->setting_data as $setting ):
			
				if( isset($data[$setting]) ):
			
					$params[$setting] = $data[$setting];
				
				endif;
			
			endforeach;
		
			if( count($params) > 0 ):
			
				$update_data['data'] = serialize($params);
				
			else:
			
				$update_data['data'] = null;
			
			endif;
		
		endif;
		
		// Update the setting
		
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

	// --------------------------------------------------------------------------

	/**
	 * Deletes a setting
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_setting( $setting_id )
	{
		$this->db->where('id', $setting_id);
	
		return $this->db->delete('panel_settings');
	}

}

/* End of file settings_mdl.php */
/* Location: ./expressionengine/third_party/panel/models/settings_mdl.php */
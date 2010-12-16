<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Entry Setting
 *
 * Retrieves the id of a setting for use in the channel entries tag
 *
 * @package		Panel
 * @author		Adam Fairholm (Green Egg Media)
 */
class Setting_entry
{
	var $setting_type_name			= 'entry';

	var $setting_data				= array( 'channel' );

	// --------------------------------------------------------------------------

	/**
	 * Constructor
	 */
	function Setting_entry()
	{
		$this->EE =& get_instance();
	}

	/**
	 * Extra field to choose a channel
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function channel_input( $value = '' )
	{
		// Get the channels and display in a drop down
		
		$this->EE->db->order_by('channel_title', 'ASC');
		
		$obj = $this->EE->db->get('channels');
	
		$channels = array();
	
		$channels_result = $obj->result();
	
		foreach( $channels_result as $item ):
		
			$channels[$item->channel_id] = $item->channel_title;
		
		endforeach;
	
		return form_dropdown('channel', $channels, $value);
	}
	
	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	string
	 * @param	array
	 * @return	string
	 */
	function form_output( $name, $value = '' )
	{
	}
	
}

/* End of file setting.text.php */
/* Location: ./expressionengine/third_party/panel/settings/setting.text.php */
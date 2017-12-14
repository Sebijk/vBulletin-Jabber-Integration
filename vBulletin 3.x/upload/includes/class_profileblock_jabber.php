<?php
/**
* Profile Block for "Jabber"
*
* @package Enhanced Jabber Integration
*/
class vB_ProfileBlock_Jabber extends vB_ProfileBlock
{
	/**
	* The name of the template to be used for the block
	*
	* @var string
	*/
	var $template_name = 'memberinfo_block_jabber';

	/**
	* Variables to automatically prepare
	*
	* @var array
	*/
	var $auto_prepare = array('');

	/**
	* Whether to return an empty wrapper if there is no content in the blocks
	*
	* @return bool
	*/
	function confirm_empty_wrap()
	{
		return false;
	}

	/**
	* Should we actually display anything?
	*
	* @return	bool
	*/
	function confirm_display()
	{
		return (!empty($this->profile->userinfo['jabber']) AND $this->registry->userinfo['userid'] OR $this->registry->options['jabber_show_guest'] == 1);
	}

	/**
	* Prepare any data needed for the output
	*
	* @param	string	The id of the block
	* @param	array	Options specific to the block
	*/
	function prepare_output($id = '', $options = array())
	{
		global $vbphrase;
		$this->block_data = array();
		$this->prepared['jabber'] = $this->userinfo['jabber'];
		if($this->profile->userinfo['jabber']) $this->profile->prepared['hasimdetails'] = true; // If the user has a Jabber ID
	}
}
?>
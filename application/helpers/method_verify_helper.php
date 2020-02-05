<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

function is_get()
{
	$CI = &get_instance();

	$method = $CI->input->method(TRUE);
	if ($method != 'GET') {
		$CI->output
			->set_status_header(403)
			->set_content_type('application/json', 'utf-8')
			->_display();
		return false;
	}
	return true;
}

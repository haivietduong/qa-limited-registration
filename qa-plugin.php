<?php

/*
	Plugin Name: Limited Registration
	Plugin URI:
	Plugin Description: Provides support for limiting registration based on user information in Question2Answer
	Plugin Version: 1.0
	Plugin Date: 2014-08-16
	Plugin Author: Hai Duong
	Plugin Author URI: http://www.haiduong.me/
	Plugin License: GPLv2
	Plugin Minimum Question2Answer Version: 1.5
	Plugin Update Check URI:
*/

	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
		header('Location: ../../');
		exit;
	}

	qa_register_plugin_module('filter', 'qa-limited-registration.php', 'qa_limited_registration', 'Limited Registration');

/*
	Omit PHP closing tag to help avoid accidental output
*/

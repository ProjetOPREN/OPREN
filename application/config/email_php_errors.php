<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * where to send php errors to and from
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file email_php_errors.php
 */
// to enable, set this to true
$config['email_php_errors'] = true;
$config['php_error_from'] = 'contact@covoit-karen.org';
$config['php_error_to'] = 'contact@covoit-karen.org';
// available shortcodes are {{severity}}, {{message}}, {{filepath}}, {{line}}
$config['php_error_subject'] = 'PHP Error';

/* End of file email_php_errors.php */
/* Location: ./application/config/email_php_errors.php */

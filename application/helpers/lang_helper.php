<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('isFr'))
{
	function isFr()
	{
	    if(empty($_SESSION['lang']) OR $_SESSION['lang'] == "fr"){
	        return true;
	    }
	    else {
	        return false;
	    }
	}
}

if ( ! function_exists('whats_lang'))
{

	function whats_lang()
	{
	    if(empty($_SESSION['lang']) OR $_SESSION['lang'] == "fr"){
	        return 'fr';
	    }
	    else {
	        return $_SESSION['lang'];
	    }
	}
}
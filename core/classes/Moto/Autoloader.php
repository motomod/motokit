<?php

/**
 * Author: Matt De'Ath
 * Date: 21/09/12
 * Package: motoload
 * Description: Autoloader for motokit
 */

require_once('Find.php');

class Moto_Autoloader
{
	/* Directories we can search, from root (above htdocs) */
	private $directories = array('components', 'vendor');

	/* Initiate seach and include if found */
	public static function load($class_name)
	{
		$ml = new self;

		/* Find file by class name */
		$location = Moto_Find::instance()->search('class', $class_name);
		
		/*
		echo "<pre>";
		var_dump($class_name, $location);
		echo "</pre>";
		*/

		if ($location != FALSE)
		{
			include($location);
		}
	}

	/* Find the class and return location if exists */
}

/* Function called upon every Class initiation */
spl_autoload_register('Moto_Autoloader::load');

?>

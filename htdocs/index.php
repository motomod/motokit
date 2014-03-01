<?php

/**
 * Author: Matt De'Ath
 * Date: 21/09/12
 * Package: motokit
 * Description: Bootstrap
 */

/* Set some locations */
DEFINE('ROOT', '../');

/* include motoload to autoload classes */
include('../core/classes/Moto/Autoloader.php');

/* Set modules */
Moto_Find::instance()->set_modules(
	array(
		'Database' => 'MySql'
	)
);



/* Set exception handler */
//set_exception_handler('Controller_Error::handle');
//set_error_handler('Controller_Error::handle');



/* include routes */
include(ROOT . 'routes.php');

?>

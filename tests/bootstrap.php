<?php

use Gin0115\Remove_Hook\Tests\Stubs\Class_Static;
use Gin0115\Remove_Hook\Tests\Stubs\Class_Instance;

/**
 * PHPUnit bootstrap file
 */

const ACTION_HANDLE = 'some_action_handle_function';
const FILTER_HANDLE = 'some_filter_handle_function';

// No Operation callback used in tests.
function noOp() {
}

// Callback for action test with global function.
function action_callback_function() {
}

// Callback for filter test with global function.
function filter_callback_function( string $var ): string {
	return 'FUNCTION';
}

// Composer autoloader must be loaded before WP_PHPUNIT__DIR will be available
require_once dirname( __DIR__ ) . '/vendor/autoload.php';

// Give access to tests_add_filter() function.
require_once getenv( 'WP_PHPUNIT__DIR' ) . '/includes/functions.php';

tests_add_filter(
	'muplugins_loaded',
	function() {

		// Register the stubbed hooks.
		( new Class_Instance() )->register();
		( new Class_Static() )->register();

		// Register global function callbacks.
		add_action( ACTION_HANDLE, 'action_callback_function' );
		add_filter( FILTER_HANDLE, 'filter_callback_function' );

		do_action( ACTION_HANDLE );

	}
);

// Start up the WP testing environment.
require getenv( 'WP_PHPUNIT__DIR' ) . '/includes/bootstrap.php';

<?php

namespace Gin0115\Remove_Hook\Tests;

use WP_UnitTestCase;
use Gin0115\Remove_Hook\Tests\Stubs\Class_Static;
use Gin0115\Remove_Hook\Tests\Stubs\Class_Instance;

class Test_Remove_Hook extends WP_UnitTestCase {

	public function test_returns_false_if_hook_not_registered(): void {
		// This hook hasnt been registered.
		$this->assertFalse( remove_hook( 'fake_hook', 'noOp' ) );
	}

	public function test_returns_false_if_hook_priority_unset(): void {
		add_action( 'wrong_priroity', 'noOp', 9999 );
		$this->assertFalse( remove_hook( 'wrong_priroity', 'noOp', 9998 ) );

	}

	public function test_returns_false_if_lambda_used() {
		$this->assertFalse(
			remove_hook(
				'fake_hook',
				function() {
					echo 'THIS CAN NOT BE REMOVED';
				}
			)
		);
	}

	public function test_can_remove_action_using_instance() {
		$class  = new Class_Instance();
		$result = remove_hook( Class_Instance::ACTION_HANDLE, array( $class, 'action_callback_instance' ) );

		// Check we removed the hook.
		$this->assertTrue( $result );
		$this->assertEmpty( $GLOBALS['wp_filter'][ Class_Instance::ACTION_HANDLE ]->callbacks[10] );
	}

	public function test_can_remove_action_using_static() {
		$class  = new Class_Static();
		$result = remove_hook( Class_Static::ACTION_HANDLE, array( $class, 'action_callback_static' ) );

		// Check the hook was removed.
		$this->assertTrue( $result );
		$this->assertEmpty( $GLOBALS['wp_filter'][ Class_Static::ACTION_HANDLE ]->callbacks[10] );
	}

	public function test_can_remove_action_using_global_functions() {
		$result = remove_hook( ACTION_HANDLE, 'action_callback_function' );

		// Check we removed the hook.
		$this->assertTrue( $result );
		$this->assertEmpty( $GLOBALS['wp_filter'][ ACTION_HANDLE ]->callbacks[10] );
	}

	public function test_can_remove_filter_using_instance() {
		$class  = new Class_Instance();
		$result = remove_hook( Class_Instance::FILTER_HANDLE, array( $class, 'filter_callback_instance' ) );

		// Check we removed the hook.
		$this->assertTrue( $result );
		$this->assertEmpty( $GLOBALS['wp_filter'][ Class_Instance::FILTER_HANDLE ]->callbacks[10] );
	}

	public function test_can_remove_filter_using_static() {
		$class  = new Class_Static();
		$result = remove_hook( Class_Static::FILTER_HANDLE, array( $class, 'filter_callback_static' ) );

		// Check the hook was removed.
		$this->assertTrue( $result );
		$this->assertEmpty( $GLOBALS['wp_filter'][ Class_Static::FILTER_HANDLE ]->callbacks[10] );

	}

	public function test_can_remove_filter_using_global_functions() {
		$result = remove_hook( FILTER_HANDLE, 'filter_callback_function' );

		// Check we removed the hook.
		$this->assertTrue( $result );
		$this->assertEmpty( $GLOBALS['wp_filter'][ FILTER_HANDLE ]->callbacks[10] );
	}
}

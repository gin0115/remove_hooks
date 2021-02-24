<?php

namespace Gin0115\Remove_Hook\Tests\Stubs;

class Class_Static {

	public const ACTION_HANDLE = 'some_action_handle_static';
	public const FILTER_HANDLE = 'some_filter_handle_static';

	public function register() {
		add_action( self::ACTION_HANDLE, array( self::class, 'action_callback_static' ) );
		add_filter( self::FILTER_HANDLE, array( self::class, 'filter_callback_static' ) );
	}

	public static function action_callback_static(): void {
		print self::class;
	}

	public static function filter_callback_static( string $var ): string {
		return self::class;
	}

}

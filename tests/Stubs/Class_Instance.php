<?php

namespace Gin0115\Remove_Hook\Tests\Stubs;

class Class_Instance {

	public const ACTION_HANDLE = 'some_action_handle_instance';
	public const FILTER_HANDLE = 'some_filter_handle_instance';

	public function register() {
		add_action(self::ACTION_HANDLE, [$this, 'action_callback_instance']);
		add_filter(self::FILTER_HANDLE, [$this, 'filter_callback_instance']);
	}

	public function action_callback_instance(): void {
		print self::class;
	}

	public function filter_callback_instance( string $var ): string {
		return self::class;
	}

}

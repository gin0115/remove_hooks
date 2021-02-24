<?php

declare(strict_types=1);

/**
 * Used to remove both actions and filters
 */
function remove_hook( string $hook_handle, callable $callback, int $priority = 10 ): bool {

	global $wp_filter;

	// Ensure the hook is already registered at the specified priority.
	if ( ! array_key_exists( $hook_handle, $wp_filter ) || ! array_key_exists( $priority, $wp_filter[ $hook_handle ]->callbacks ) ) {
		return false;
	}

	// Bail if lamda passed.
	if ( $callback instanceof Closure ) {
		return false;
	}

	// Extract class and method, based on callback type.
	$callback_class    = is_array( $callback ) ? get_class( $callback[0] ) : false;
	$callback_function = is_array( $callback ) ? $callback[1] : $callback;
	$removed_hooks     = false;

	// Loop through all registered hooks.
	foreach ( $wp_filter[ $hook_handle ]->callbacks[ $priority ] as $key => $registered_callbacks ) {

		// If no callback set, skip.
		if ( ! is_array( $registered_callbacks ) || ! array_key_exists( 'function', $registered_callbacks ) ) {
			continue;
		}

		// If the callback is a class method.
		if ( $callback_class !== false && count( $registered_callbacks['function'] ) === 2 ) {
			// Remove registered hook if both class and method match.
			$registered_class = is_object( $registered_callbacks['function'][0] )
				? get_class( $registered_callbacks['function'][0] )
				: $registered_callbacks['function'][0];

			// Check we have a valid class, skip if we dont.
			if ( ! class_exists( $registered_class ) ) {
				continue;
			}

			// If both class and method match, remove the hook.
			if ( $registered_class === $callback_class && $registered_callbacks['function'][1] === $callback_function ) {
				unset( $wp_filter[ $hook_handle ]->callbacks[ $priority ][ $key ] );

				// Mark the hook as removed and continue to remove any duplicates.
				// Duplicates can be caused by registering hooks in constructor.
				$removed_hooks = true;
				continue;
			}
		}

		// If the callback is plain function.
		if ( function_exists( $callback_function )
			&& is_string( $registered_callbacks['function'] )
			&& $registered_callbacks['function'] === $callback_function
		) {
			unset( $wp_filter[ $hook_handle ]->callbacks[ $priority ][ $key ] );
			$removed_hooks = true;
			continue;
		}
	}

	return $removed_hooks;
}

<?php
if ( ! function_exists('pgcu_get_paged_num') ) {
    /**
     * Get current page number for the pagination.
     *
     * @since    1.0.0
     *
     * @return    int    $paged    The current page number for the pagination.
     */
    function pgcu_get_paged_num() {

        global $paged;

        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } else if (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }

        return absint($paged);

    }

}

if ( ! function_exists('pgcu_load_dependencies') ) {
    function pgcu_load_dependencies( $files = 'all', $directory = PGCU_INC_DIR, $ext = '.php' )
    {
        if ( ! file_exists( $directory ) ) return; // vail if the directory does not exist

        switch( $files ) {
            case is_array( $files ) && 'all' !== strtolower( $files[0] ):
                // include one or more file looping through the $files array
                load_some_file( $files, $directory );
                break;
            case ! is_array( $files ) && 'all' !== $files:
                //load a single file here
                ( file_exists( $directory . $files . $ext ) ) ? require_once $directory . $files . $ext : null;
                break;
            case 'all' == $files || 'all' == strtolower( $files[0] ):
                // load all php file here
                load_all_files( $directory );
                break;
        }

        return false;

    }
}

if ( ! function_exists('load_all_files') ) {
    function load_all_files( $dir = '', $ext = '.php' )
    {
        if ( ! file_exists( $dir ) ) return;
        foreach ( scandir( $dir ) as $file ) {
            // require once all the files with the given ext. eg. .php
            if ( preg_match( "/{$ext}$/i", $file ) ) {
                require_once( $dir . $file );
            }
        }
    }
}

if( ! function_exists('pgcu_pagination') ) {
    /**
     * Prints pagination for custom post
     * @param object|WP_Query $custom_post_query
     * @param int $paged
     *
     * @return string
     */
    function pgcu_pagination( $custom_post_query, $paged = 1 )
    {
        $navigation = '';
        $largeNumber = 999999999; // we need a large number here
        $links = paginate_links( array(
            'base' => str_replace( $largeNumber, '%#%', esc_url( get_pagenum_link( $largeNumber ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, $paged ),
            'total' => $custom_post_query->max_num_pages,
            'prev_text' => apply_filters('pgcu_pagination_prev_text', '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z"/></svg>'),
            'next_text' => apply_filters('pgcu_pagination_next_text', '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"/></svg>'),
        ) );
        if( $links ) {
            $navigation = _navigation_markup($links, 'pagination', ' ');
        }
        return apply_filters('pgcu_pagination', $navigation, $links, $custom_post_query, $paged);
    }
}

if ( ! function_exists( 'pgcu_sanitize_array' ) ) {
	/**
	 * It sanitize a multi-dimensional array
	 * @param array &$array The array of the data to sanitize
	 * @return mixed
	 */
	function pgcu_sanitize_array( &$array ) {
		foreach ( $array as &$value ) {
			if ( ! is_array( $value ) ) {
				// sanitize if value is not an array
				$value = sanitize_text_field( $value );
			} else {
				// go inside this function again
				pgcu_sanitize_array( $value );
			}
		}
		return $array;
	}
}

/**
 * Checks if a string is a valid JSON-encoded string.
 *
 * @param string $data The string to be checked for JSON encoding.
 *
 * @return bool Returns true if the string is a valid JSON-encoded string, false otherwise.
 */
if ( ! function_exists( 'is_json_encoded' ) ) {
	function is_json_encoded( $data ) {
		json_decode( $data );
		return (json_last_error() == JSON_ERROR_NONE);
	}
}

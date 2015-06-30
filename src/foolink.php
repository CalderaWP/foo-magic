<?php
/**
 * When a Foo Gallery permalink is passed, get the link to the page it is on.
 *
 * @package   foo-magic
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2015 Josh Pollock
 */

namespace calderawp\filter\foo;


class foolink {

	/**
	 * Constructor for class
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'caldera_magic_tag-post', 'permalink' );
	}

	/**
	 * Parse the URL to get the used page.
	 *
	 * @since 1.0.0
	 *
	 * @uses "caldera_magic_tag-post" filter
	 *
	 * @param array $params
	 *
	 * @return string|array
	 */
	public function permalink( $params ) {

		if ( class_exists('FooGallery') && is_string( $params ) && strpos( $params, '?foogallery' ) ) {
			$url = parse_url( $params );
			if ( isset( $url[ 'query' ] )  ) {
				parse_str( $url['query'] );
				if ( isset( $foogallery ) ) {
					$foo  = FooGallery::get_by_slug( $foogallery );
					$usages = $foo->find_usages();
					if ( is_array( $usages ) && isset( $usages[0] ) ) {
						return esc_url( get_permalink( $usages[0]->ID ) );
					}

				}

			}

		}

		return $params;

	}

}

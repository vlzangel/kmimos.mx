<?php

/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */

// ini_set("session.cookie_httponly", true);
// header( 'X-Content-Type-Options: nosniff' );
// header( 'X-Frame-Options: SAMEORIGIN' );
// header( 'X-XSS-Protection: 1' );
// header( 'Cache-Control: no-cache, no-store, must-revalidate');

define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
require( dirname( __FILE__ ) . '/wp-blog-header.php' );

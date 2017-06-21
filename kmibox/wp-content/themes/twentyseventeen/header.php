<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- BEGIN Style - Plugins -->
	<link rel="stylesheet" href="/plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/plugins/fontawesome/css/font-awesome.css">
	<!-- BEGIN Style - Plugins -->
	
	<?php #wp_head(); ?>

	<!-- BEGIN Style -->
	<link rel="stylesheet" href="/css/animate.css">
	<link rel="stylesheet" href="/css/kmibox.css">
	<!-- END Style -->

</head>

<body <?php body_class(); ?>>
	<div class="container-fluid">




<?php
/*
Plugin Name: Related Posts By Taxonomy
Version: 0.1.1
Plugin URI: http://keesiemeijer.wordpress.com/2013/05/11/related-posts-by-taxonomy-plugin/
Description: This lightweight WordPress plugin provides a widget and shortcode to display related posts by taxonomies as links, full posts or excerpts. Posts that have the most terms in common will display at the top.
Author: keesiemijer
Author URI:
License: GPL v2
Text Domain: related-posts-by-taxonomy
Domain Path: /lang

Related Posts By Taxonomy
Copyright 2013  Kees Meijer  (email : keesie.meijer@gmail.com)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version. You may NOT assume that you can use any other version of the GPL.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/* load plugin files and text domain */
if ( !function_exists( 'related_posts_by_taxonomy_init' ) ) {

	function related_posts_by_taxonomy_init() {

		load_plugin_textdomain( 'related-posts-by-taxonomy', '', dirname( plugin_basename( __FILE__ ) ) . '/lang' );

		// functions to retrieve related posts from the database
		require_once plugin_dir_path( __FILE__ ) . 'functions.php';

		// functions for display of related post thumbnail gallery
		require_once plugin_dir_path( __FILE__ ) . 'functions-thumbnail.php';

		// loads the different templates uses for the widget and shortcode
		require_once plugin_dir_path( __FILE__ ) . 'template-loader.php';

		require_once plugin_dir_path( __FILE__ ) . 'widget.php';
		require_once plugin_dir_path( __FILE__ ) . 'shortcode.php';

		add_shortcode( 'related_posts_by_tax', 'km_rpbt_related_posts_by_taxonomy_shortcode' );
	}


	/* initialize plugin */
	related_posts_by_taxonomy_init();

} // !function_exists
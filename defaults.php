<?php
/**
 * A helper class to get all the defaults needed for this plugin.
 * Used by the widget and shortcode.
 */

if ( !class_exists( 'Related_Posts_By_Taxonomy_Defaults' ) ) {
	class Related_Posts_By_Taxonomy_Defaults {

		/**
		 * Post types.
		 *
		 * @since 0.2.1
		 * @var array
		 */
		public static $post_types;

		/**
		 * Taxonomies.
		 *
		 * @since 0.2.1
		 * @var array
		 */
		public static $taxonomies;

		/**
		 * slug for "all" taxonomies.
		 *
		 * @since 0.2.1
		 * @var string
		 */
		public static $all_tax;

		/**
		 * Default taxonomy (category).
		 *
		 * @since 0.2.1
		 * @var string
		 */
		public static $default_tax;

		/**
		 * Formats.
		 *
		 * @since 0.2.1
		 * @var array
		 */
		public static $formats;

		/**
		 * Image sizes.
		 *
		 * @since 0.2.1
		 * @var array
		 */
		public static $image_sizes;

		/**
		 * Class instance.
		 *
		 * @since 0.2.1
		 * @see get_instance()
		 * @var object
		 */
		private static $instance = null;


		/**
		 * Acces this plugin's working instance.
		 *
		 * @since 0.2.1
		 *
		 * @return object
		 */
		public static function get_instance() {
			// create a new object if it doesn't exist.
			is_null( self::$instance ) && self::$instance = new self;
			return self::$instance;
		}


		/**
		 * Sets up class properties on action hook wp_loaded.
		 * wp_loaded is fired after custom post types and taxonomies are registered by themes and plugins.
		 *
		 * @since 0.2.1
		 */
		public static function init() {
			add_action( 'wp_loaded', array( self::get_instance(), '_setup' ) );
		}


		/**
		 * Sets up class properties.
		 *
		 * @since 0.2.1
		 */
		public function _setup() {

			// default taxonomies
			$this->all_tax = 'all'; // all taxonomies
			$this->default_tax = array( 'category' => __( 'Category', 'related-posts-by-taxonomy' ) );

			$this->post_types = $this->get_post_types();
			if ( empty( $this->post_types ) )
				$this->post_types = array( 'post' => __( 'Post', 'related-posts-by-taxonomy' ) );

			$this->taxonomies = $this->get_taxonomies();
			if ( empty( $this->taxonomies ) )
				$this->taxonomies = $this->default_tax;

			$this->image_sizes = $this->get_image_sizes();
			if ( empty( $this->image_sizes ) )
				$this->image_sizes = array( 'thumbnail' => __( 'Thumbnail', 'related-posts-by-taxonomy' ) );

			$this->formats = $this->get_formats();
		}


		/**
		 * Returns all public post types.
		 *
		 * @since 0.2.1
		 *
		 * @return array Array with post type objects.
		 */
		public function get_post_types() {
			$post_types = array();
			$post_types_obj = get_post_types( array( 'public' => true, '_builtin' => false ), 'objects', 'and' );

			$post_types_obj = array( 'post' => get_post_type_object( 'post' ) ) + $post_types_obj;

			foreach ( (array) $post_types_obj as $key => $value ) {
				$post_types[$key] = esc_attr( $value->labels->menu_name );
			}
			return $post_types;
		}


		/**
		 * Returns all public taxonomies
		 * Sets the id for 'All Taxonomies'
		 * Sets the default taxonomy
		 *
		 * @since 0.2.1
		 *
		 * @return array Array with taxonomy names and labels.
		 */
		public function get_taxonomies() {
			$tax = array();
			$taxonomies = get_taxonomies( array( 'public' => true ), 'objects', 'and' );

			$i=0;
			foreach ( (array) $taxonomies as $key => $value ) {

				$tax[$key] = esc_attr( $value->labels->menu_name );

				// set first taxonomy as the default taxonomy
				if ( !$i++ )
					$this->default_tax = array( $key => esc_attr( $value->labels->menu_name ) );
			}

			// if 'all' is a registered taxonomy change the all_tax value (slug: all-2)
			if ( !empty( $tax ) ) {
				if ( in_array( $this->all_tax, array_keys( $tax ) ) ) {
					$num = 2;
					do {
						$alt_slug = $this->all_tax . "-$num";
						$num++;
						$slug_check = in_array( $alt_slug, $tax );
					} while ( $slug_check );
					$this->all_tax = $alt_slug;
				}
			}

			return $tax;
		}


		/**
		 * Returns all image sizes.
		 *
		 * @since 0.2.1
		 *
		 * @global array $_wp_additional_image_sizes
		 * @return array Array with all image sized.
		 */
		public function get_image_sizes() {

			global $_wp_additional_image_sizes;
			$sizes = array();
			$image_sizes = get_intermediate_image_sizes();

			foreach ( $image_sizes as $s ) {

				$width = $height = false;
				if ( isset( $_wp_additional_image_sizes[$s] ) ) {
					$width = intval( $_wp_additional_image_sizes[$s]['width'] );
					$height = intval( $_wp_additional_image_sizes[$s]['height'] );
				} else {
					$width = get_option( $s.'_size_w' );
					$height = get_option( $s.'_size_h' );
				}

				if ( $width && $height ) {
					$size = sanitize_title( $s );
					$size = ucwords( str_replace( array( '-', '_' ), ' ', $s ) );
					$sizes[$s] = $size . ' (' . $width . ' x ' . $height . ')';
				}

			}

			return $sizes;
		}


		/**
		 * returns all formats.
		 *
		 * @since 0.2.1
		 *
		 * @return array Formats.
		 */
		public function get_formats() {
			$formats = array(
				'links'      => __( 'Links', 'related-posts-by-taxonomy' ),
				'posts'      => __( 'Posts', 'related-posts-by-taxonomy' ),
				'excerpts'   => __( 'Excerpts', 'related-posts-by-taxonomy' ),
				'thumbnails' => __( 'Post thumbnails', 'related-posts-by-taxonomy' ),
			);
			return $formats;
		}


	} // end class

	Related_Posts_By_Taxonomy_Defaults::init();

} // class exists
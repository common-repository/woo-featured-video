<?php

/**
 * The file that defines the core plugin class
 *
 * @link       https://figarts.co
 * @since      1.0.0
 *
 * @package    Woofv
 * @subpackage Woofv/includes
 */

/**
 * The core plugin class.
 *
 * @since      1.0.0
 * @package    Woofv
 * @subpackage Woofv/includes
 * @author     David Towoju <hello@figarts.co>
 */
class Woofv_Ctrl {

	/**
	 * Path to the template used to display the content of the meta box.
	 *
	 * @var string
	 */
	private $template;


	/**
	 * Define the core functionality of the plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $template ) {

		$this->template = rtrim( $template, '/' );

		$this->load_dependencies();
		$this->define_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		require plugin_dir_path( __FILE__ ) . 'class-woofv-metabox.php';
	}

	/**
	 * Scripts and Styles
	 *
	 * @return void
	 */
	public function enqueue_scripts() {

		if ( !is_product() && !is_admin() )
			return;

		global $pagenow;
		if ( is_admin() && ( $pagenow == 'post.php' ) && (get_post_type() != 'product'))
			return;

		wp_enqueue_media();
		wp_enqueue_style( WOOFV_SLUG . '-css', WOOFV_URL . 'assets/woofv.css', array(), WOOFV_VERSION, false );
		wp_enqueue_script( WOOFV_SLUG . '-js', WOOFV_URL . 'assets/woofv.js', array( 'jquery' ), WOOFV_VERSION, true );
		wp_localize_script(
			WOOFV_SLUG,
			'meta_image',
			array(
				'title'  => esc_html__( 'Choose or Upload Media', 'woofv' ),
				'button' => esc_html__( 'Use this file', 'woofv' ),
			)
		);
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_hooks() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_meta_box' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'woocommerce_single_product_image_thumbnail_html', array( $this, 'add_video' ), 10, 2 );
	}

	public function add_meta_box( $post_type ) {
		if ( 'product' != $post_type ) {
			return;
		}

		global $post;

		$meta_box = new Woofv_MetaBox( 'woofv', WOOFV_PATH . 'views/metabox.php', esc_html__( 'Featured Video', 'woofv' ), 'side', 'low', $post_type );
	}

	public function save_meta_box( $post_id ) {
		if ( ! isset( $_POST['woofv_video_box_nonce'] ) || ! wp_verify_nonce( $_POST['woofv_video_box_nonce'], 'woofv_video_box' ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Exit if this is an autosave, our form has not been submitted,
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if ( isset( $_POST['woofv_video_embed'] ) && $data = $_POST['woofv_video_embed'] ) {

			// Sanitize the user input.
			$woofv_data              = array_map( 'esc_url_raw', $_POST['woofv_video_embed'] );
			$woofv_data['url']       = esc_url_raw( $_POST['woofv_video_embed']['url'] );
			$woofv_data['thumbnail'] = esc_url_raw( $_POST['woofv_video_embed']['thumbnail'] );
			$woofv_data['poster']    = esc_url_raw( $_POST['woofv_video_embed']['poster'] );
			$woofv_data['autoplay']  = wp_validate_boolean( $_POST['woofv_video_embed']['autoplay'] );
			update_post_meta( $post_id, '_woofv_video_embed', $woofv_data );
		}
	}

	public function add_video( $html, $thumbnail_id ) {

		$current_thumbnail_id = get_post_thumbnail_id( get_the_ID() );

		if ( $current_thumbnail_id != $thumbnail_id ) {
			return $html;
		}

		$meta      = get_post_meta( get_the_ID(), '_woofv_video_embed', true );
		$url       = isset( $meta['url'] ) ? $meta['url'] : '';
		$thumbnail = isset( $meta['thumbnail'] ) ? $meta['thumbnail'] : '';
		$poster    = isset( $meta['poster'] ) ? $meta['poster'] : '';
		$autoplay  = isset( $meta['autoplay'] ) ? $meta['autoplay'] : 'off';

		ob_start();
		include $this->template;
		$content = ob_get_clean();
		$html    = $content . $html;

		return $html;
	}

}

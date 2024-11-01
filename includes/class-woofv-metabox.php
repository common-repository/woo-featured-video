<?php

/**
 * A WordPress meta box that appears in the editor.
 */
class Woofv_MetaBox {

	/**
	 * Screen context where the meta box should display.
	 *
	 * @var string
	 */
	private $context;

	/**
	 * The ID of the meta box.
	 *
	 * @var string
	 */
	private $id;

	/**
	 * The display priority of the meta box.
	 *
	 * @var string
	 */
	private $priority;

	/**
	 * Screens where this meta box will appear.
	 *
	 * @var string[]
	 */
	private $screens;

	/**
	 * Path to the template used to display the content of the meta box.
	 *
	 * @var string
	 */
	private $template;

	/**
	 * The title of the meta box.
	 *
	 * @var string
	 */
	private $title;

	/**
	 * Constructor.
	 *
	 * @param string   $id
	 * @param string   $template
	 * @param string   $title
	 * @param string   $context
	 * @param string   $priority
	 * @param string[] $screens
	 */
	public function __construct( $id, $template, $title, $context = 'advanced', $priority = 'default', $screens = array() ) {
		if ( is_string( $screens ) ) {
			$screens = (array) $screens;
		}

		$this->context  = $context;
		$this->id       = $id;
		$this->priority = $priority;
		$this->screens  = $screens;
		$this->template = rtrim( $template, '/' );
    $this->title    = $title;
    $this->create();
	}

	/**
	 * Get the callable that will the content of the meta box.
	 *
	 * @return callable
	 */
	public function get_callback() {
		return array( $this, 'render' );
	}

	/**
	 * Get the screen context where the meta box should display.
	 *
	 * @return string
	 */
	public function get_context() {
		return $this->context;
	}

	/**
	 * Get the ID of the meta box.
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Get the display priority of the meta box.
	 *
	 * @return string
	 */
	public function get_priority() {
		return $this->priority;
	}

	/**
	 * Get the screen(s) where the meta box will appear.
	 *
	 * @return array|string|WP_Screen
	 */
	public function get_screens() {
		return $this->screens;
	}

	/**
	 * Get the title of the meta box.
	 *
	 * @return string
	 */
	public function get_title() {
		return $this->title;
	}

	/**
	 * Render the content of the meta box using a PHP template.
	 *
	 * @param WP_Post $post
	 */
	public function render( WP_Post $post ) {
		if ( ! is_readable( $this->template ) )
			return;

		ob_start();
    include_once $this->template;
    echo ob_get_clean();
  }
  

  public function create(){
		add_meta_box(
			$this->get_id(), 
			$this->get_title(), 
			$this->get_callback(), 
			$this->get_screens(), 
			$this->get_context(), 
			$this->get_priority()
		);
  }
}

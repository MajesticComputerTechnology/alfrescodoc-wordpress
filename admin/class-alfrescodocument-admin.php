<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://majestic.com.au
 * @since      1.0.0
 *
 * @package    Alfrescodocument
 * @subpackage Alfrescodocument/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Alfrescodocument
 * @subpackage Alfrescodocument/admin
 * @author     ShibeLord HODL <nath@majestic.com.au>
 */
class Alfrescodocument_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Alfrescodocument_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Alfrescodocument_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/alfrescodocument-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Alfrescodocument_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Alfrescodocument_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/alfrescodocument-admin.js', array( 'jquery' ), $this->version, false );

	}
    

    
    public function add_options_page() {
	
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Alfresco Document Settings', $this->plugin_name ),
			__( 'Alfresco Document', $this->plugin_name ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);
	
	}
    
    public function display_options_page() {
		include_once 'partials/alfrescodocument-admin-display.php';
	}
    
    //register setting
    public function register_setting() {
        // Add a General section
        add_settings_section(
            $this->plugin_name.'_general',
            __( 'General', $this->plugin_name ),
            array( $this, $this->plugin_name . '_general_cb' ),
            $this->plugin_name
        );
        //add setting field
        //url
        add_settings_field(
            $this->plugin_name . '_url',
            __( 'URL', $this->plugin_name ),
            array( $this, $this->plugin_name . '_url_cb' ),
            $this->plugin_name,
            $this->plugin_name . '_general',
            array( 'label_for' => $this->plugin_name . '_url' )
        );
        //port
        add_settings_field(
            $this->plugin_name . '_port',
            __( 'Port', $this->plugin_name ),
            array( $this, $this->plugin_name . '_port_cb' ),
            $this->plugin_name,
            $this->plugin_name . '_general',
            array( 'label_for' => $this->plugin_name . '_port' )
        );
        //username
        add_settings_field(
            $this->plugin_name . '_folder',
            __( 'Folder', $this->plugin_name ),
            array( $this, $this->plugin_name . '_folder_cb' ),
            $this->plugin_name,
            $this->plugin_name . '_general',
            array( 'label_for' => $this->plugin_name . '_folder' )
        );
        //username
        add_settings_field(
            $this->plugin_name . '_username',
            __( 'Username', $this->plugin_name ),
            array( $this, $this->plugin_name . '_username_cb' ),
            $this->plugin_name,
            $this->plugin_name . '_general',
            array( 'label_for' => $this->plugin_name . '_username' )
        );
        //password
        add_settings_field(
            $this->plugin_name . '_password',
            __( 'Password', $this->plugin_name ),
            array( $this, $this->plugin_name . '_password_cb' ),
            $this->plugin_name,
            $this->plugin_name . '_general',
            array( 'label_for' => $this->plugin_name . '_password' )
        );
        
        //password
        add_settings_field(
            $this->plugin_name . '_password',
            __( 'Password', $this->plugin_name ),
            array( $this, $this->plugin_name . '_password_cb' ),
            $this->plugin_name,
            $this->plugin_name . '_general',
            array( 'label_for' => $this->plugin_name . '_password' )
        );
        
        // Add an Optional section
        add_settings_section(
            $this->plugin_name.'_options',
            __( 'Display Options', $this->plugin_name ),
            array( $this, $this->plugin_name . '_options_cb' ),
            $this->plugin_name
        );
        //password
        add_settings_field(
            $this->plugin_name . '_display',
            __( 'Display Meta Data', $this->plugin_name ),
            array( $this, $this->plugin_name . '_display_cb' ),
            $this->plugin_name,
            $this->plugin_name . '_options',
            array( 'label_for' => $this->plugin_name . '_display' )
        );
        
        register_setting( $this->plugin_name, $this->plugin_name . '_url', 'esc_url' );
        register_setting( $this->plugin_name, $this->plugin_name . '_port', 'intval' );
        register_setting( $this->plugin_name, $this->plugin_name . '_folder', 'sanitize_text_field' );
        register_setting( $this->plugin_name, $this->plugin_name . '_username', 'sanitize_text_field' );
        register_setting( $this->plugin_name, $this->plugin_name . '_password', 'sanitize_text_field' );
        
        register_setting( $this->plugin_name, $this->plugin_name . '_display' );
        
    }
    
    public function alfrescodocument_general_cb() {
        //echo '<p>' . __( 'Alfresco information.', $this->plugin_name ) . '</p>';
    }
    
    public function alfrescodocument_url_cb() {
        ?>
			<input type="url" name="<?php echo $this->plugin_name . '_url' ?>" id="<?php echo $this->plugin_name . '_url'?>" value="<?php echo get_option( $this->plugin_name . '_url' )?>" placeholder="http://example.com">
		<?php
    }
    
    public function alfrescodocument_port_cb() {
        ?>
			<input type="number" maxlength="5" name="<?php echo $this->plugin_name . '_port' ?>" id="<?php echo $this->plugin_name . '_port' ?>" value="<?php echo get_option( $this->plugin_name . '_port' )?>" placeholder="1234">
		<?php
    }
    
    public function alfrescodocument_folder_cb() {
        ?>
			<input type="text" name="<?php echo $this->plugin_name . '_folder' ?>" id="<?php echo $this->plugin_name . '_folder' ?>" value="<?php echo get_option( $this->plugin_name . '_folder' )?>" placeholder="a684bfed-707f-4f1f-ab8d-8ef52563ffef">
		<?php
    }
    
    public function alfrescodocument_username_cb() {
        ?>
			<input type="text" name="<?php echo $this->plugin_name . '_username' ?>" id="<?php echo $this->plugin_name . '_username' ?>" value="<?php echo get_option( $this->plugin_name . '_username' )?>" placeholder="username">
		<?php
    }
    
    public function alfrescodocument_password_cb() {
        ?>
			<input type="password" name="<?php echo $this->plugin_name . '_password' ?>" id="<?php echo $this->plugin_name . '_password' ?>" value="<?php echo get_option( $this->plugin_name . '_password' )?>" placeholder="password">
		<?php
    }
    
    public function alfrescodocument_options_cb() {
        //echo '<p>' . __( 'Display options', $this->plugin_name ) . '</p>';
    }
    
    public function alfrescodocument_display_cb() {
        $options = get_option( $this->plugin_name . '_display' );
        ?>
            <input type="checkbox" name="<?php echo $this->plugin_name . '_display' ?>[thumbnail]" value="1" <?php checked( 1 == $options['thumbnail'] ); ?> >Thumbnail<br>
			<input type="checkbox" name="<?php echo $this->plugin_name . '_display' ?>[title]" value="1" <?php checked( 1 == $options['title'] ); ?> >Title<br>
            <input type="checkbox" name="<?php echo $this->plugin_name . '_display' ?>[name]"  value="1" <?php checked( 1 == $options['name'] ); ?> >Name<br>
            <input type="checkbox" name="<?php echo $this->plugin_name . '_display' ?>[path]"  value="1" <?php checked( 1 == $options['path'] ); ?> >Path<br>
            <input type="checkbox" name="<?php echo $this->plugin_name . '_display' ?>[description]"  value="1" <?php checked( 1 == $options['description'] ); ?> >Description<br>
            <input type="checkbox" name="<?php echo $this->plugin_name . '_display' ?>[download]"  value="1" <?php checked( 1 == $options['download'] ); ?> >Download Link<br>

		<?php
    }
    
    
    
    
    
    
    
    
}
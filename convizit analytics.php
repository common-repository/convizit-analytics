<?php
	/*
	Plugin Name: Convizit Analytics
	Description: Integrate Convizit Analytics with your WordPress website
	Author: Convizit
	Plugin URI: https://convizit.com
	Author URI: https://convizit.com
	Version: 1.1
	*/

	namespace convizit;

	class ConvizitAnalytics {
		public function __construct() {
			if(is_admin()) {
		    	add_action('admin_menu', array($this, 'add_settings_page'));
		    	add_action('admin_init', array($this, 'convizit_init'));
			} else {
				require_once dirname( __FILE__ ) . '/page.php';
			}
	    }

	     public function add_settings_page() {
	        // Page under "Settings"
			add_options_page('Convizit Analytics', 'Convizit Analytics', 'manage_options', 'convizit-admin', array($this, 'create_settings_page'));
	    }

		public function create_settings_page() {
?>
			<div class="wrap">
			    <?php screen_icon(); ?>
			    <h2>Convizit Analytics Settings</h2>
			    <?php settings_errors(  ) ?>
			    <form method="post" action="options.php">
			    <?php
		            // This prints out all hidden setting fields
				    settings_fields('convizit_settings_group');
				    do_settings_sections('convizit_options');
				?>
			        <?php submit_button(); ?>
			    </form>
			</div>
<?php
	    }

		public function print_section_info() {
			print 'Please enter your Convizit Analytics token ID below:';
	    }

		function my_text_input( $args ) {
		    $name = esc_attr( $args['name'] );
		    $value = esc_attr( $args['value'] );
		    if(strlen($value) > 0) {
		    	$size = strlen($value) + 2;
		    } else {
		    	$size = 10;
		    }
		    echo "<input type='text' name='$name' size='$size' value='$value' />";
		}

	    public function convizit_init() {
			register_setting('convizit_settings_group', 'convizit_settings', array(&$this, 'validate'));
	      	$settings = (array) get_option( 'convizit_settings' );
			
	        add_settings_section(
			    'convizit_settings_section',
			    'Convizit Analytics',
			    array($this, 'print_section_info'),
			    'convizit_options'
			);

			add_settings_field(
			    'token_id',
			    'Token ID', // Display text
			    array($this, 'my_text_input'),  // Render field function
			    	'convizit_options',
			    	'convizit_settings_section', array(
				    	'name' => 'convizit_settings[token_id]',
				    	'value' => $settings['token_id'],
					)
			);
		}
		public function validate($input) {
			$output = get_option( 'convizit_settings' );
		    if ( ctype_digit( $input['token_id'] ) ) {
		        $output['token_id'] = $input['token_id'];
		    } else {
		    	echo "Adding Error \n"; #Die;
		        add_settings_error( 'convizit_options', 'token_id', 'Invalid Token' );
		    }
		    return $output;
		}
	}
	$convizitAnalytics = new \convizit\ConvizitAnalytics();
?>
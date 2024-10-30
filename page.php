<?php
	add_action( 'wp_head', array('ConvizitAnalytics','insert_tracker' ));

  	class ConvizitAnalytics {

    /**
    * Adds the Convizit Analytics tracking code to the header.
    *
    * @return [type] [description]
    */
    function insert_tracker() {
		$settings = (array) get_option( 'convizit_settings' );
		if(!isset($settings['token_id'])) {
		self::no_convizit_analytics_token_found();
		return false;
    }

    require_once dirname(__FILE__) . '/convizit_analytics_js.php';
    return true;
    }

    static function no_convizit_analytics_token_found() {
		echo "<!-- Convizit Analytics Token Is Not Defined -->";
    }
  }
?>
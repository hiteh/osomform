<?php

class OsomformDBRepository implements OsomformRepositoryInterface {
	
	public function create( array $data ) {

		global $wpdb;
		$table = $wpdb->prefix . 'osomform';
		$format = array('%s', '%s', '%s', '%s', '%s');
		$wpdb->insert( $table, $data, $format );
		$id = $wpdb->insert_id;

		return $id;
	}

    public function readAll() {
    	
    	global $wpdb;
    	$table_name = $wpdb->prefix . "osomform";
		$myrows = $wpdb->get_results( "SELECT * FROM $table_name" );
		return $myrows;
    }

    public static function osomform_db_table_setup() {
    	
    	global $wpdb;
		$table_name = $wpdb->prefix . "osomform";
		$charset_collate = $wpdb->get_charset_collate();
		// dbDelta checks if table exists by using DESCRIBE. 
		$sql = "CREATE TABLE $table_name (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  first_name tinytext NOT NULL,
		  last_name tinytext NOT NULL,
		  login tinytext NOT NULL,
		  email tinytext NOT NULL,
		  city tinytext NOT NULL,
		  submitted_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
    }

    public function osomform_db_table_drop() {

		global $wpdb;
		$table_name = $wpdb->prefix . "osomform";
		$wpdb->query( "DROP TABLE IF EXISTS $table_name" );
	}
}
<?php

class OsomformDBRepository implements OsomformRepositoryInterface {
	
	const TABLE_NAME = 'osomform';
	const DB_PREFIX = $wpdb->prefix;
	const DB_TABLE = DB_PREFIX . TABLE_NAME 
 
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
    	$table_name = OsomformDBRepository::DB_TABLE;
		$myrows = $wpdb->get_results( "SELECT * FROM $table_name" );
		return $myrows;
    }

    public static function storage_setup() {
    	
    	global $wpdb;
		$table_name = OsomformDBRepository::DB_TABLE;
		$charset_collate = $wpdb->get_charset_collate();
		// dbDelta checks if table exists by using DESCRIBE. If you are unig Query Monitor plugin for some reasons it displays error.
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

    public static function storage_remove() {

		global $wpdb;
		$table_name = OsomformDBRepository::DB_TABLE;
		$wpdb->query( "DROP TABLE IF EXISTS $table_name" );
	}
}
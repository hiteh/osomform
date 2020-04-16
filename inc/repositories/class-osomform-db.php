<?php

 /**
 * Theme database repository
 *
 * @implements OsomformRepositoryInterface
 * @package osomform
 * @since Osom Form 1.0
 * @version 1.0
 */

class OsomformDBRepository implements OsomformRepositoryInterface {
	
	/**
	* Repository interface.
	*
	* @var string DB_TABLE table name
	*/
	const DB_TABLE = 'osomform';
 
	/**
	* Create item
	*
	* @param array $data creates db record.
	* @return int
	*/
	public function create( array $data ) {

		global $wpdb;
		$table = $wpdb->prefix . 'osomform';
		$format = array('%s', '%s', '%s', '%s', '%s');
		$wpdb->insert( $table, $data, $format );
		$id = $wpdb->insert_id;

		return $id;
	}

	/**
	* Get all db records
	*
	* @return array
	*/
    public function readAll() {
    	
    	global $wpdb;
    	$table_name = $wpdb->prefix . OsomformDBRepository::DB_TABLE;
		$rows = $wpdb->get_results( "SELECT * FROM $table_name" );
		return $rows;
    }

	/**
	* Setup db table
	*
	* @return array
	*/
    public static function storage_setup() {
    	
    	global $wpdb;
		$table_name = $wpdb->prefix . OsomformDBRepository::DB_TABLE;
		$charset_collate = $wpdb->get_charset_collate();
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
		maybe_create_table( $table_name, $sql );
    }

	/**
	* Remove db table
	*
	* @return array
	*/
    public static function storage_remove() {

		global $wpdb;
		$table_name = $wpdb->prefix . OsomformDBRepository::DB_TABLE;
		$wpdb->query( "DROP TABLE IF EXISTS $table_name" );
	}
}

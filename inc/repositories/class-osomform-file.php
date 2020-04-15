<?php

class OsomformFileRepository implements OsomformRepositoryInterface {

	const FILE_NAME = 'contacts.json';
	const DIR_NAME  = 'osomform_storage';
	const FW_SLASH  = '/';
	const FILE_PATH = WP_CONTENT_DIR . OsomformFileRepository::FW_SLASH . OsomformFileRepository::DIR_NAME . OsomformFileRepository::FW_SLASH . OsomformFileRepository::FILE_NAME;
	const DIR_PATH = WP_CONTENT_DIR . OsomformFileRepository::FW_SLASH . OsomformFileRepository::DIR_NAME;

	private static $current_id = 1;
	
	public function create( array $data ) {
    	
    	if( ! wp_is_writable( WP_CONTENT_DIR ) ) {
    		return;
    	}
		$file = file_get_contents( OsomformFileRepository::FILE_PATH );
		$temp = json_decode( $file ), true );
		// Release some memory.
		$unset( $file );
		// Add item id.
		array_unshift( $data, $current_id++ );
		// Add current data.
		$temp[] = $data;
		file_put_contents( OsomformFileRepository::FILE_PATH, json_encode( $temp ), LOCK_EX );
		// Remove temporary data.
		unset( $temp );
		return $data['id'];
	}

    public function readAll() {
    	
    	if( ! file_exists( OsomformFileRepository::FILE_PATH ) ) {
    		return;
    	}
    	return json_decode( file_get_contents( OsomformFileRepository::FILE_PATH ), true );
    }

    public static function storage_setup() {
    	
    	if( ! wp_is_writable( WP_CONTENT_DIR ) ) {
    		return;
    	}
    	wp_mkdir_p( OsomformFileRepository::DIR_PATH );
		file_put_contents( OsomformFileRepository::FILE_PATH, json_encode( array() ), LOCK_EX );
    }

    public static function storage_remove() {

    	if( ! wp_is_writable( WP_CONTENT_DIR ) || ! file_exists( OsomformFileRepository::DIR_PATH ) {
    		return;
    	}
    	rmdir( OsomformFileRepository::DIR_PATH );
    }
}
<?php

 /**
 * Theme file repository
 *
 * @implements OsomformRepositoryInterface
 * @package osomform
 * @since Osom Form 1.0
 * @version 1.0
 */


class OsomformFileRepository implements OsomformRepositoryInterface {

	const FILE_NAME = 'contacts.json';
	const DIR_NAME  = 'osomform_storage';
	const FW_SLASH  = '/';
	
	const FILE_PATH = WP_CONTENT_DIR .
	OsomformFileRepository::FW_SLASH .
	OsomformFileRepository::DIR_NAME .
	OsomformFileRepository::FW_SLASH .
	OsomformFileRepository::FILE_NAME;
	
	const DIR_PATH = WP_CONTENT_DIR .
	OsomformFileRepository::FW_SLASH .
	OsomformFileRepository::DIR_NAME;

	public function create( array $data ) {
		
		if( ! file_exists( OsomformFileRepository::FILE_PATH ) ) {
			file_put_contents( OsomformFileRepository::FILE_PATH, json_encode( array() ), LOCK_EX );
		}
		$file = file_get_contents( OsomformFileRepository::FILE_PATH );
		$temp = json_decode( $file, true );
		$count = count( $temp );
		// Release some memory.
		unset( $file );
		// Add item id.
		$current_id  = $count > 0 ?  $temp[$count -1]['id'] + 1 : 1;
		$data = array_merge(['id' => $current_id], $data );
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
    	return json_decode( file_get_contents( OsomformFileRepository::FILE_PATH ) );
    }

    public static function storage_setup() {
    	
    	if( ! wp_is_writable( WP_CONTENT_DIR ) ) {
    		return;
    	}
    	if( ! file_exists( OsomformFileRepository::DIR_PATH  ) ) {
    		wp_mkdir_p( OsomformFileRepository::DIR_PATH );
    	}
    }

    public static function storage_remove() {

    	if( ! wp_is_writable( WP_CONTENT_DIR ) || ! file_exists( OsomformFileRepository::DIR_PATH ) ) {
    		return;
    	}
    	if ( file_exists( OsomformFileRepository::FILE_PATH ) ) {
    		unlink(OsomformFileRepository::FILE_PATH);
    	}

    	rmdir( OsomformFileRepository::DIR_PATH );
    }
}

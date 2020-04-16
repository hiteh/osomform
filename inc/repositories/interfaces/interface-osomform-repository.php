<?php

 /**
 * Theme repository interface
 *
 * @package osomform
 * @since Osom Form 1.0
 * @version 1.0
 */

interface OsomformRepositoryInterface
{
    public function create( array $data );
    public function readAll();
    public static function storage_setup();
    public static function storage_remove();
}

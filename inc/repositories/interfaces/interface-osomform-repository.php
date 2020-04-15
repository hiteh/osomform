<?php

interface OsomformRepositoryInterface
{
    public function create( array $data );
    public function readAll();
    public static function storage_setup();
    public static function storage_remove();
}
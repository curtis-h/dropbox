<?php


class Dropbox extends Eloquent {
    protected $table = 'dropbox';
    protected $fillable = ['id', 'access_token', 'filename', 'latitude', 'longitude', 'link'];
    
    public static $json = ['id', 'access_token', 'filename', 'latitude', 'longitude', 'link'];


}

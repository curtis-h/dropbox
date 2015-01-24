<?php


class Dropbox extends Eloquent {
    protected $table = 'dropbox';
    protected $fillable = ['access_token', 'filename', 'latitude', 'longitude'];
    
    public static $json = ['access_token', 'filename', 'latitude', 'longitude'];


}

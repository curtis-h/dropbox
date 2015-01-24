<?php
use \Dropbox as dbx;

class HomeController extends BaseController {

    public function __construct() {
        session_start();
    }
	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

    protected function getDbx() {
        $appInfo = dbx\AppInfo::loadFromJsonFile(__DIR__."/../../dropbox_info.json");
        $csrfTokenStore = new dbx\ArrayEntryStore($_SESSION, 'dropbox-auth-csrf-token');
        $webAuth = new dbx\WebAuth($appInfo, "PHP-Example/1.0", "https://dropbox.curtish.me/auth/", $csrfTokenStore);
        return $webAuth;
    }
    
    
    public function index() {
        $boxes = Dropbox::all(Dropbox::$json);
        $dbxClient   = new dbx\Client($_ENV['dropbox_at'], "PHP-Example/1.0");
        
        foreach($boxes as &$box) {
            $data = $dbxClient->createTemporaryDirectLink("/hack/{$box->filename}");
            $box->link = $data[0];
        }
        
        return View::make('map')->with('boxes', $boxes);
    }
    
    
    public function create() {
        $boxes     = Dropbox::all(Dropbox::$json);
        $dbxClient = new dbx\Client($_ENV['dropbox_at'], "PHP-Example/1.0");
        
        foreach($boxes as &$box) {
            $data = $dbxClient->createTemporaryDirectLink("/hack/{$box->filename}");
            $box->link = $data[0];
        }
        
        return View::make('mapCreate')->with('boxes', $boxes);
    }
    
    
    public function login() {
        $webAuth       = $this->getDbx();
        $authorizeUrl  = $webAuth->start();
        $authorizeUrl .= '&redirect_uri=https://dropbox.curtish.me/auth/';
        return Redirect::to($authorizeUrl);
    }
    
    
    public function auth() {
        $webAuth     = $this->getDbx();
        list($accessToken, $userId, $urlState) = $webAuth->finish($_GET);
        $dbxClient   = new dbx\Client($accessToken, "PHP-Example/1.0");
        $accountInfo = $dbxClient->getAccountInfo();
        
        dd($accountInfo);
    }
    
    public function find() {
        $boxes = Dropbox::all(Dropbox::$json);
        $dbxClient   = new dbx\Client($_ENV['dropbox_at'], "PHP-Example/1.0");
        
        foreach($boxes as &$box) {
            $data = $dbxClient->createTemporaryDirectLink("/hack/{$box->filename}");
            $box->link = $data[0];
        }
        
        return Response::json($boxes);
        
        
        $dbxClient   = new dbx\Client($_ENV['dropbox_at'], "PHP-Example/1.0");
        $accountInfo = $dbxClient->getAccountInfo();
        $data        = $dbxClient->getMetadataWithChildren('/hack');
        $all         = Dropbox::all(Dropbox::$json);
        
        $list = $all->map(function($file) {
            $lat  = abs($file->latitude - Input::get('lat'));
            $lng  = abs($file->longitude - Input::get('lng'));
            
            if($lat < 2 && $lng < 2) {
                return $file;
            }
        });
        
        return Response::json($list);
    }
    
    public function data() {
        
        $dbxClient   = new dbx\Client($_ENV['dropbox_at'], "PHP-Example/1.0");
        $accountInfo = $dbxClient->getAccountInfo();
        $data        = $dbxClient->getMetadataWithChildren('/hack');
        $db          = Dropbox::where('filename', basename($data["contents"][0]["path"]))->get(Dropbox::$json);
        
        dd($db->toJson());
        dd($data);
        
    }
    
    public function upload() {
        $file   = Input::file('uploader');
        $name   = $file->getClientOriginalName();
        $path   = $file->getRealPath();
        $client = new dbx\Client($_ENV['dropbox_at'], "PHP-Example/1.0");
        $fd     = fopen($path, "rb");
        $md1    = $client->uploadFile("/hack/{$name}", dbx\WriteMode::add(), $fd);
        fclose($fd);
        
        // temp until I get client access tokens
        $token = $_ENV['dropbox_at'];
        $lat   = Input::get('latitude');
        $lng   = Input::get('longitude');
        
        $dropbox = new Dropbox([
            'access_token' => $token,
            'filename'     => $name,
            'latitude'     => $lat,
            'longitude'    => $lng
        ]);
        
        $dropbox->save();
        return "ok";
    }

}

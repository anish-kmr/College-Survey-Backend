<?php
class Handler{
    private $method,$url,$no_routes_matched;
    public function __construct(){
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->url = explode('/testapi', $_SERVER['REQUEST_URI'])[1];
        $this->url = explode('?', $this->url)[0];
        $this->no_routes_matched=true;

    }
    public function get($url,$callback)
    {
        if( $this->method== 'GET' && $this->url == $url){
            $this->no_routes_matched=false;
            $callback();
        }
    }
    public function post($url,$callback)
    {
        if($this->method== 'POST' && $this->url == $url){
            $this->no_routes_matched=false;
            $callback();
        }
    }
    public function route_unmatched()   
    {
        return $this->no_routes_matched;
    }
}
?>
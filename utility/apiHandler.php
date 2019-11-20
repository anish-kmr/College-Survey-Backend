<?php
class Handler{
    private $method,$url,$no_routes_matched;
    public function __construct(){
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->url = explode('/surveyBackend', $_SERVER['REQUEST_URI'])[1];
        $this->url = explode('?', $this->url)[0];
        $this->no_routes_matched=true;

    }
    public function check(){
        echo "worrkingg apiHAndler";
    }
    
    public function get($url,$callback){
        if( $this->method== 'GET' && $this->url == $url){
            $this->no_routes_matched=false;
            $callback();
        }
    }

    public function post($url,$callback){
        if($this->method== 'POST' && $this->url == $url){
            $this->no_routes_matched=false;
            $callback();
        }
    }
    

    public function put($url,$callback){
        if($this->method== 'PUT' && $this->url == $url){
            $this->no_routes_matched=false;
            $callback();
        }
    }

    public function delete($url,$callback){
        if($this->method== "DELETE" && $this->url == $url){
            $this->no_routes_matched=false;
            $callback();
        }
    }

    public function route_unmatched()   {
        return $this->no_routes_matched;
    }
}

$app=new Handler;
?>